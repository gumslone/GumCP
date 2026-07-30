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
       . ((PHP_VERSION_ID < 70300 || (isset(\$p['samesite']) && \$p['samesite'] !== '')) ? 'x' : '-');
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

# The hardening only works if it runs before anything starts a session.
for f in include/init.php setup.php update.php; do
    sl=$(grep -n 'gumcp_start_session()' "$ROOT/$f" | head -1 | cut -d: -f1)
    cl=$(grep -n "include/config.php'\|/config.php'" "$ROOT/$f" | head -1 | cut -d: -f1)
    if [ -n "$sl" ] && [ -n "$cl" ] && [ "$sl" -lt "$cl" ]; then :; else
        fail "$f starts the session after loading config.php — cookie flags would be ignored"
    fi
done
pass "session hardening runs before config.php in every entry point"

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

echo ""
if [ $FAIL -eq 0 ]; then
    echo "All self-tests passed."
else
    echo "SELF-TESTS FAILED."
fi
exit $FAIL
