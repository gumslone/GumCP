#!/bin/bash
# GumCP self-test — runs without a web server or a Raspberry Pi.
#
#   bash scripts/selftest.sh
#
# Covers the logic that is easy to break silently and painful to debug in
# production: the access gate, credential handling, cron validation, the API IP
# allow-list, and PHP 7.0 compatibility. Run it before committing; CI runs it too.

if [ -z "${BASH_VERSION:-}" ]; then exec bash "$0" "$@"; fi
set -u

cd "$(dirname "$0")/.." || exit 1
ROOT="$(pwd)"
FAIL=0
pass() { echo "  ✓ $1"; }
fail() { echo "  ✗ $1"; FAIL=1; }

# ── 1. Syntax ─────────────────────────────────────────────────────────────────
echo "PHP syntax"
while IFS= read -r -d '' f; do
    php -l "$f" >/dev/null 2>&1 || fail "syntax error in $f"
done < <(find . -name '*.php' -not -path './modules/*' -print0)
[ $FAIL -eq 0 ] && pass "all first-party PHP parses"

# ── 2. PHP 7.0 compatibility ──────────────────────────────────────────────────
echo "PHP 7.0 compatibility"
if bash scripts/check-php70.sh >/dev/null 2>&1; then
    pass "no 7.1+ syntax"
else
    fail "7.1+ syntax found (run scripts/check-php70.sh)"
fi

# ── 3. Shell scripts ──────────────────────────────────────────────────────────
echo "Shell syntax"
for s in installer.sh uninstall.sh check.sh scripts/*.sh; do
    [ -f "$s" ] || continue
    bash -n "$s" 2>/dev/null || fail "syntax error in $s"
done
pass "shell scripts parse"

# ── 4. Access gate ────────────────────────────────────────────────────────────
# Each scenario needs its own process: the settings are define()d constants.
echo "Access gate"
gate() {  # gate <label> <expect: allow|deny> <php-config>
    out=$(php -r "
        \$_SERVER['SCRIPT_NAME']='/index.php';
        \$_SESSION=[];
        $3
        require '$ROOT/include/auth.php';
        gumcp_enforce_access();
        echo 'ALLOWED';
    " 2>/dev/null)
    got="deny"; [ "$out" = "ALLOWED" ] && got="allow"
    [ "$got" = "$2" ] && pass "$1" || fail "$1 (expected $2, got $got)"
}
gate "unconfigured auth is refused (fail closed)" deny \
    "define('LOGIN_REQUIRED',false); define('BASIC_AUTH',false); define('GUMCP_ALLOW_UNAUTHENTICATED',false);"
gate "explicit open mode is allowed"              allow \
    "define('LOGIN_REQUIRED',false); define('BASIC_AUTH',false); define('GUMCP_ALLOW_UNAUTHENTICATED',true);"
gate "login required, not signed in, is refused"  deny \
    "define('LOGIN_REQUIRED',true); define('LOGIN_USER','pi'); define('LOGIN_PASS','x'); define('BASIC_AUTH',false); define('GUMCP_ALLOW_UNAUTHENTICATED',false);"
gate "valid session is allowed"                   allow \
    "define('LOGIN_REQUIRED',true); define('LOGIN_USER','pi'); define('LOGIN_PASS','x'); define('BASIC_AUTH',false); define('GUMCP_ALLOW_UNAUTHENTICATED',false); \$_SESSION=['LOGIN_USER'=>md5('pi'),'LOGIN_PASS'=>md5('x')];"
gate "wrong password in session is refused"       deny \
    "define('LOGIN_REQUIRED',true); define('LOGIN_USER','pi'); define('LOGIN_PASS','x'); define('BASIC_AUTH',false); define('GUMCP_ALLOW_UNAUTHENTICATED',false); \$_SESSION=['LOGIN_USER'=>md5('pi'),'LOGIN_PASS'=>md5('nope')];"
gate "api.php bypasses the gate (hash-authenticated)" allow \
    "define('GUMCP_API_REQUEST',true); define('LOGIN_REQUIRED',false); define('BASIC_AUTH',false); define('GUMCP_ALLOW_UNAUTHENTICATED',false);"

# LOGIN_* inherit the system account when a config sets only the SSH credentials.
out=$(php -r "
    define('SSH_USER','oleg'); define('SSH_PASS','pw'); define('SSH_PORT','22');
    \$gumcp_modules=[];
    require '$ROOT/include/config.defaults.php';
    echo LOGIN_USER . ':' . LOGIN_PASS;
" 2>/dev/null)
[ "$out" = "oleg:pw" ] && pass "LOGIN_* inherit SSH_* when unset" \
                       || fail "LOGIN_* inheritance (got '$out')"

# ...but an explicit web login must still override, so the panel password can
# differ from the system account.
out=$(php -r "
    define('SSH_USER','pi'); define('SSH_PASS','systempw'); define('SSH_PORT','22');
    define('LOGIN_USER','webadmin'); define('LOGIN_PASS','webpw');
    \$gumcp_modules=[];
    require '$ROOT/include/config.defaults.php';
    echo LOGIN_USER . ':' . LOGIN_PASS;
" 2>/dev/null)
[ "$out" = "webadmin:webpw" ] && pass "explicit LOGIN_* overrides SSH_* (separate web login)" \
                             || fail "explicit LOGIN_* override (got '$out')"

# System-user checking: off by default, and when on the config password is
# not accepted (only the OS may validate the login).
echo "System-user login flag"
out=$(php -r "
    define('SSH_USER','pi'); define('SSH_PASS','pw'); define('SSH_PORT','22');
    \$gumcp_modules=[];
    require '$ROOT/include/config.defaults.php';
    require '$ROOT/include/auth.php';
    echo gumcp_check_system_user() ? 'on' : 'off';
" 2>/dev/null)
[ "$out" = "off" ] && pass "defaults to off (login is a config credential)" \
                   || fail "should default to off (got '$out')"

out=$(php -r "
    define('LOGIN_CHECK_SYSTEM_USER',true);
    define('SSH_USER','pi'); define('SSH_PASS','pw'); define('SSH_PORT','22');
    define('LOGIN_REQUIRED',true); define('LOGIN_USER','pi'); define('LOGIN_PASS','');
    define('BASIC_AUTH',false);
    require '$ROOT/include/auth.php';
    // empty LOGIN_PASS must still count as configured, and must never authenticate
    echo (gumcp_auth_configured() ? 'configured' : 'unconfigured') . ':' .
         (gumcp_system_login('root','pw') ? 'other-user-allowed' : 'other-user-denied');
" 2>/dev/null)
[ "$out" = "configured:other-user-denied" ] \
    && pass "when on: empty LOGIN_PASS is fine, wrong username refused" \
    || fail "system-user mode (got '$out')"

# LOGIN_USER still decides who may sign in; only the password goes to the OS.
# A username that does not match LOGIN_USER must be rejected before any SSH
# attempt is made (no ssh2 extension is needed to prove that).
out=$(php -r "
    define('LOGIN_CHECK_SYSTEM_USER',true);
    define('SSH_USER','pi'); define('SSH_PASS','pw'); define('SSH_PORT','22');
    define('LOGIN_REQUIRED',true); define('LOGIN_USER','webadmin'); define('LOGIN_PASS','');
    define('BASIC_AUTH',false);
    require '$ROOT/include/auth.php';
    echo gumcp_system_login('somebody-else','pw') ? 'accepted' : 'rejected';
" 2>/dev/null)
[ "$out" = "rejected" ] && pass "when on: only LOGIN_USER may sign in" \
                        || fail "non-LOGIN_USER should be rejected (got '$out')"

# ── Login throttling ──────────────────────────────────────────────────────────
# A successful login is shell access, so password guessing must be rate limited —
# and the limit must be per-address, or an attacker could lock the admin out.
echo "Login throttling"
TDIR=$(mktemp -d)
mkdir -p "$TDIR/include" "$TDIR/command_logs"
cp "$ROOT/include/auth.php" "$TDIR/include/"
out=$(php -r "
    define('LOGIN_MAX_FAILURES',3);
    define('LOGIN_FAILURE_WINDOW',900);
    define('LOGIN_LOCKOUT_TIME',900);
    require '$TDIR/include/auth.php';
    \$r = [];
    \$r[] = gumcp_login_locked_for('10.0.0.1') ? 'locked' : 'open';
    for (\$i=0; \$i<3; \$i++) gumcp_login_record_failure('10.0.0.1');
    \$r[] = gumcp_login_locked_for('10.0.0.1') > 0 ? 'locked' : 'open';
    \$r[] = gumcp_login_locked_for('10.0.0.2') > 0 ? 'locked' : 'open';
    gumcp_login_clear('10.0.0.1');
    \$r[] = gumcp_login_locked_for('10.0.0.1') > 0 ? 'locked' : 'open';
    echo implode(',', \$r);
" 2>/dev/null)
rm -rf "$TDIR"
[ "$out" = "open,locked,open,open" ] \
    && pass "locks after repeated failures, per address, cleared on success" \
    || fail "login throttling (got '$out', want 'open,locked,open,open')"

# Basic Auth uses the same throttle. A request with NO credentials is the normal
# first request from a browser and must never count as a failed guess.
TDIR=$(mktemp -d)
mkdir -p "$TDIR/include" "$TDIR/command_logs"
cp "$ROOT/include/auth.php" "$TDIR/include/"
out=$(php -r "
    define('BASIC_AUTH',true); define('BASIC_AUTH_USER','api'); define('BASIC_AUTH_PASS','s3cret');
    define('LOGIN_MAX_FAILURES',3); define('LOGIN_FAILURE_WINDOW',900); define('LOGIN_LOCKOUT_TIME',900);
    require '$TDIR/include/auth.php';
    \$_SERVER['REMOTE_ADDR'] = '10.1.1.1';
    \$r = [];
    for (\$i=0; \$i<10; \$i++) gumcp_basic_authenticated();          // no credentials sent
    \$r[] = gumcp_login_locked_for('10.1.1.1') ? 'locked' : 'open';
    \$_SERVER['PHP_AUTH_USER']='api'; \$_SERVER['PHP_AUTH_PW']='wrong';
    for (\$i=0; \$i<3; \$i++) gumcp_basic_authenticated();
    \$r[] = gumcp_login_locked_for('10.1.1.1') ? 'locked' : 'open';
    \$_SERVER['PHP_AUTH_PW']='s3cret';
    \$r[] = gumcp_basic_authenticated() ? 'in' : 'refused';           // locked: refuse even if correct
    echo implode(',', \$r);
" 2>/dev/null)
rm -rf "$TDIR"
[ "$out" = "open,locked,refused" ] \
    && pass "Basic Auth throttled; missing credentials are not a failed guess" \
    || fail "Basic Auth throttling (got '$out', want 'open,locked,refused')"

# ── Session hardening ─────────────────────────────────────────────────────────
# A GumCP session grants shell access, so the cookie must not be readable by
# JavaScript, must not ride along on cross-site requests, and the session ID must
# not be client-choosable. Cookie params only apply if set before session_start().
echo "Session cookie"
out=$(php -r "
    require '$ROOT/include/session.php';
    \$_SERVER = ['SERVER_PORT' => 80];
    gumcp_start_session();
    \$p = session_get_cookie_params();
    echo (\$p['httponly'] ? 'h' : '-')
       . (ini_get('session.use_strict_mode') ? 's' : '-')
       . (ini_get('session.use_only_cookies') ? 'c' : '-')
       . (((isset(\$p['samesite']) && \$p['samesite'] !== '')
           || stripos(\$p['path'], 'samesite=lax') !== false) ? 'x' : '-');
" 2>/dev/null)
[ "$out" = "hscx" ] && pass "HttpOnly, strict mode, cookies-only, SameSite" \
                    || fail "session cookie flags (got '$out', want 'hscx')"

out=$(php -r "
    require '$ROOT/include/session.php';
    \$_SERVER = ['HTTPS' => 'on', 'SERVER_PORT' => 443];
    gumcp_start_session();
    \$p = session_get_cookie_params();
    echo \$p['secure'] ? 'secure' : 'not-secure';
" 2>/dev/null)
[ "$out" = "secure" ] && pass "Secure flag set when served over HTTPS" \
                      || fail "Secure flag over HTTPS (got '$out')"

# Response headers. GumCP can run shell commands, so an attacker who can frame
# the panel can trick a logged-in admin into clicking a button that executes
# something. Checked over a real HTTP response, not by reading the source.
docroot="$(mktemp -d)"
printf '%s' "<?php require '$ROOT/include/session.php'; gumcp_start_session(); echo 'ok';" \
    > "$docroot/i.php"
php -S 127.0.0.1:8919 -t "$docroot" >/dev/null 2>&1 &
srv=$!
sleep 1
hdrs=$(curl -sI http://127.0.0.1:8919/i.php 2>/dev/null)
kill $srv 2>/dev/null || true
rm -rf "$docroot"

missing=""
for h in "X-Frame-Options: SAMEORIGIN" "X-Content-Type-Options: nosniff" \
         "Referrer-Policy: same-origin" "frame-ancestors 'self'" "object-src 'none'"; do
    case "$hdrs" in *"$h"*) ;; *) missing="$missing [$h]";; esac
done
[ -z "$missing" ] && pass "clickjacking / sniffing / CSP headers sent" \
                  || fail "missing response headers:$missing"

case "$hdrs" in
    *"SameSite=Lax"*) pass "Set-Cookie carries SameSite=Lax on this PHP version" ;;
    *)                fail "Set-Cookie has no SameSite attribute" ;;
esac

# The hardening only works if it runs before anything starts a session.
for f in include/init.php setup.php update.php; do
    sl=$(grep -n 'gumcp_start_session()' "$ROOT/$f" | head -1 | cut -d: -f1)
    cl=$(grep -n "include/config.php'\|/config.php'" "$ROOT/$f" | head -1 | cut -d: -f1)
    if [ -n "$sl" ] && [ -n "$cl" ] && [ "$sl" -lt "$cl" ]; then :; else
        fail "$f starts the session after loading config.php — cookie flags would be ignored"
    fi
done
pass "session hardening runs before config.php in every entry point"

# ── Session lifetime ──────────────────────────────────────────────────────────
# The cookie lives until the browser closes, so without these limits a signed-in
# tab left open on a shared machine keeps shell access indefinitely.
echo "Session lifetime"
out=$(php -r "
    define('LOGIN_REQUIRED', true);
    define('LOGIN_USER', 'pi'); define('LOGIN_PASS', 'secret');
    define('SESSION_IDLE_TIMEOUT', 100);
    define('SESSION_ABSOLUTE_TIMEOUT', 1000);
    require '$ROOT/include/auth.php';
    \$r = '';

    // fresh login is valid
    \$_SESSION = ['LOGIN_USER'=>md5('pi'), 'LOGIN_PASS'=>md5('secret')];
    gumcp_mark_login_time();
    \$r .= gumcp_session_authenticated() ? 'a' : '-';

    // idle past the limit: signed out, and the credentials are cleared
    \$_SESSION['GUMCP_LAST_SEEN'] = time() - 101;
    \$r .= gumcp_session_authenticated() ? '-' : 'b';
    \$r .= isset(\$_SESSION['LOGIN_USER']) ? '-' : 'c';

    // absolute limit applies even to a continuously active session
    \$_SESSION = ['LOGIN_USER'=>md5('pi'), 'LOGIN_PASS'=>md5('secret'),
                 'GUMCP_AUTH_TIME'=>time()-1001, 'GUMCP_LAST_SEEN'=>time()];
    \$r .= gumcp_session_authenticated() ? '-' : 'd';

    // background polling must not push the idle deadline out
    \$_SESSION = ['LOGIN_USER'=>md5('pi'), 'LOGIN_PASS'=>md5('secret'),
                 'GUMCP_AUTH_TIME'=>time(), 'GUMCP_LAST_SEEN'=>time()-50];
    \$_POST = ['gumcp_background' => 1];
    gumcp_session_authenticated();
    \$r .= (\$_SESSION['GUMCP_LAST_SEEN'] <= time()-50) ? 'e' : '-';
    \$_POST = [];
    gumcp_session_authenticated();
    \$r .= (\$_SESSION['GUMCP_LAST_SEEN'] > time()-50) ? 'f' : '-';
    echo \$r;
" 2>/dev/null)
[ "$out" = "abcdef" ] && pass "idle + absolute timeout, polling does not renew" \
                      || fail "session lifetime (got '$out', want 'abcdef')"

# A session that predates the feature must not be logged out by the upgrade.
out=$(php -r "
    define('LOGIN_REQUIRED', true);
    define('LOGIN_USER', 'pi'); define('LOGIN_PASS', 'secret');
    define('SESSION_IDLE_TIMEOUT', 100);
    define('SESSION_ABSOLUTE_TIMEOUT', 1000);
    require '$ROOT/include/auth.php';
    \$_SESSION = ['LOGIN_USER'=>md5('pi'), 'LOGIN_PASS'=>md5('secret')];  // no stamps
    echo gumcp_session_authenticated() ? 'kept' : 'dropped';
" 2>/dev/null)
[ "$out" = "kept" ] && pass "pre-upgrade sessions are not signed out on deploy" \
                    || fail "upgrade signs existing sessions out (got '$out')"

# ── Authentication log ────────────────────────────────────────────────────────
# GumCP runs every command as one system user, so the web server log cannot tell
# an intruder's session from the owner's. The auth log is the only record.
echo "Authentication log"
out=$(php -r "
    require '$ROOT/include/auth.php';
    \$f = gumcp_auth_log_file();
    \$backup = is_file(\$f) ? file_get_contents(\$f) : null;
    \$_SERVER['REMOTE_ADDR'] = '10.1.2.3';
    \$_SERVER['HTTP_USER_AGENT'] = \"evil\tagent\nnewline\";
    gumcp_auth_log('login_failed', \"user: bo\tb\");
    \$recent = gumcp_auth_log_recent(5);
    \$r = '';
    \$r .= (count(\$recent) >= 1 && \$recent[0]['event'] === 'login_failed') ? 'a' : '-';
    \$r .= \$recent[0]['ip'] === '10.1.2.3' ? 'b' : '-';
    // Injected tabs/newlines must not create extra columns or forged rows.
    \$r .= (strpos(\$recent[0]['detail'], 'bo b') !== false) ? 'c' : '-';
    \$r .= (substr_count(file_get_contents(\$f), \"\\n\") === substr_count(\$backup === null ? '' : \$backup, \"\\n\") + 1) ? 'd' : '-';
    // A password must never reach the log.
    \$r .= (strpos(file_get_contents(\$f), 'hunter2') === false) ? 'e' : '-';
    if (\$backup === null) { @unlink(\$f); } else { file_put_contents(\$f, \$backup); }
    echo \$r;
" 2>/dev/null)
[ "$out" = "abcde" ] && pass "auth events recorded, one line each, no injection" \
                     || fail "auth log (got '$out', want 'abcde')"

# The log records credentials being used, so it must never be web-readable.
grep -q "Deny from all\|Require all denied" "$ROOT/command_logs/.htaccess" \
    && pass "auth log directory is denied to the web server" \
    || fail "command_logs/.htaccess does not deny access"

# ── Button API ────────────────────────────────────────────────────────────────
# api.php runs shell commands with no login — the hash IS the credential.
echo "Button API"
out=$(php -r "
    define('LOGIN_MAX_FAILURES', 2);
    define('LOGIN_FAILURE_WINDOW', 900);
    define('LOGIN_LOCKOUT_TIME', 900);
    require '$ROOT/include/auth.php';
    \$f = gumcp_throttle_file();
    \$backup = is_file(\$f) ? file_get_contents(\$f) : null;
    gumcp_login_clear('api:9.9.9.9'); gumcp_login_clear('9.9.9.9');
    gumcp_login_record_failure('api:9.9.9.9');
    gumcp_login_record_failure('api:9.9.9.9');
    gumcp_login_record_failure('api:9.9.9.9');
    \$r  = gumcp_login_locked_for('api:9.9.9.9') > 0 ? 'a' : '-';
    // Hammering the API must never lock that address out of the web login.
    \$r .= gumcp_login_locked_for('9.9.9.9') === 0 ? 'b' : '-';
    gumcp_login_clear('api:9.9.9.9');
    if (\$backup === null) { @unlink(\$f); } else { file_put_contents(\$f, \$backup); }
    echo \$r;
" 2>/dev/null)
[ "$out" = "ab" ] && pass "unknown API keys are throttled, separately from the login" \
                  || fail "API key throttling (got '$out', want 'ab')"

if grep -qE "'hash' +=> +[$]hash *," "$ROOT/api.php"; then
    fail "api.php logs the full button hash — the log becomes a credential"
else
    pass "API log stores only a hash prefix"
fi

# ── Command logs ──────────────────────────────────────────────────────────────
# The Actions page lists command output and offers a Delete button. If the
# writer, the lister and the deleter disagree on which files those are, output
# goes missing (or the audit trail becomes deletable).
echo "Command logs"
grep -q "'.log';" "$ROOT/execute_command.php" \
    && pass "background command output is written as .log" \
    || fail "execute_command.php does not write .log — output will not be listed"

php -r "
    \$act = file_get_contents('$ROOT/actions.php');
    \$aj  = file_get_contents('$ROOT/ajax.php');
    \$f = 0;
    // Both sides must skip the reserved logs…
    if (strpos(\$act, 'gumcp_reserved_logs()') === false) \$f++;
    if (strpos(\$aj,  'gumcp_reserved_logs()') === false) \$f++;
    // …and both must accept the legacy extension.
    if (strpos(\$act, \".txt\") === false) \$f++;
    if (strpos(\$aj,  \".txt\") === false) \$f++;
    exit(\$f === 0 ? 0 : 1);
" 2>/dev/null && pass "listing and deletion agree, audit logs excluded from both" \
              || fail "actions.php and ajax.php disagree about which logs are command output"

php -r "
    require '$ROOT/include/config.defaults.php';
    \$r = gumcp_reserved_logs();
    exit((in_array('auth.log', \$r, true) && in_array('api_calls.log', \$r, true)) ? 0 : 1);
" 2>/dev/null && pass "auth.log and api_calls.log are reserved" \
              || fail "the audit trail is not in the reserved list"

# ── Upgrade safety ────────────────────────────────────────────────────────────
# include/config.php is user-owned and never overwritten, so any setting added to
# config.example.php MUST also have a fallback in config.defaults.php — otherwise
# existing installs hit an undefined constant the moment they upgrade.
echo "Upgrade safety"
php -r "
\$ex = file_get_contents('$ROOT/include/config.example.php');
\$df = file_get_contents('$ROOT/include/config.defaults.php');
\$bad = [];
preg_match_all('/^define\(\s*.([A-Z0-9_]+)./m', \$ex, \$m);
foreach (array_unique(\$m[1]) as \$c) {
    if (strpos(\$df, \"defined('\$c')\") === false) \$bad[] = \$c;
}
preg_match_all('/^\\\$(gumcp_[a-z_]+)\s*=/m', \$ex, \$a);
foreach (array_unique(\$a[1]) as \$v) {
    if (strpos(\$df, '\$' . \$v) === false) \$bad[] = '\$' . \$v;
}
if (\$bad) { fwrite(STDERR, implode(', ', \$bad)); exit(1); }
" 2>/tmp/gumcp_missing_defaults && pass "every config.example setting has a fallback in config.defaults" \
    || fail "no upgrade fallback for: $(cat /tmp/gumcp_missing_defaults 2>/dev/null)"

# Defaults must never clobber a value the user already set.
php -r "
\$df = file_get_contents('$ROOT/include/config.defaults.php');
// every define() in defaults must be guarded by defined() || define(...)
preg_match_all('/^\s*define\(\s*.([A-Z0-9_]+)./m', \$df, \$m);
exit(empty(\$m[1]) ? 0 : 1);
" 2>/dev/null && pass "config.defaults never overrides a user setting" \
              || fail "config.defaults has an unguarded define() — it would override config.php"

# ── 5. Pure helpers ───────────────────────────────────────────────────────────
echo "Validators"
php -r "
require '$ROOT/include/auth.php';
\$f=0;
foreach ([
  ['192.168.1.7',  ['192.168.1.0/24'], true ],
  ['192.168.2.7',  ['192.168.1.0/24'], false],
  ['192.168.1.7',  [],                 true ],
  ['192.168.1.7',  ['garbage'],        false],
  ['8.8.8.8',      ['0.0.0.0/0'],      true ],
] as \$t) { if (gumcp_ip_allowed(\$t[0],\$t[1]) !== \$t[2]) \$f++; }
exit(\$f === 0 ? 0 : 1);
" 2>/dev/null && pass "API IP allow-list" || fail "API IP allow-list"

php -r "
\$src=file_get_contents('$ROOT/ajax.php');
foreach (['cron_validate_schedule','cron_field_valid','cron_token_value'] as \$fn) {
    preg_match('/\nfunction '.\$fn.'\(.*?\n}\n/s', \$src, \$m); eval(\$m[0]);
}
\$f=0;
foreach (['0 4 * * *'=>true,'*/15 * * * *'=>true,'@reboot'=>true,'0 9-17 * * mon-fri'=>true,
          '60 * * * *'=>false,'* * * * 8'=>false,'abc'=>false,'* * * *'=>false,
          '*/0 * * * *'=>false,'@bogus'=>false] as \$expr=>\$want) {
    if (cron_validate_schedule((string)\$expr) !== \$want) \$f++;
}
exit(\$f === 0 ? 0 : 1);
" 2>/dev/null && pass "cron schedule validation" || fail "cron schedule validation"

# ── AJAX CSRF coverage ────────────────────────────────────────────────────────
# The CSRF token is the only thing separating a genuine request from one a
# malicious page made an authenticated browser send. If ajax.php ever reads its
# action (or an action parameter) from $_REQUEST, a GET can reach the dispatcher
# without a token — that is how pkg_upgrade once became CSRF-triggerable.
echo "AJAX CSRF coverage"
php -r "
\$src = file_get_contents('$ROOT/ajax.php');
\$src = preg_replace('!//.*!', '', \$src);           // ignore comments
exit(strpos(\$src, '\$_REQUEST') === false ? 0 : 1);
" 2>/dev/null && pass "ajax.php never reads \$_REQUEST" \
              || fail "ajax.php reads \$_REQUEST — GET would bypass the CSRF check"

php -r "
\$src = file_get_contents('$ROOT/ajax.php');
exit(preg_match('/REQUEST_METHOD..\s*!==\s*.POST./', \$src) ? 0 : 1);
" 2>/dev/null && pass "ajax.php rejects non-POST requests" \
              || fail "ajax.php does not require POST"

# The dashboard poller is the one caller that used to be GET.
if grep -q "type: 'GET'" "$ROOT/static/js/gumcp.js"; then
    fail "static/js/gumcp.js still issues a GET to ajax.php"
else
    pass "no frontend GET calls to ajax.php"
fi

echo ""
if [ $FAIL -eq 0 ]; then
    echo "All self-tests passed."
else
    echo "SELF-TESTS FAILED."
fi
exit $FAIL
