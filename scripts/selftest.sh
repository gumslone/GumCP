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
    && pass "when on: empty LOGIN_PASS is fine, non-SSH_USER refused" \
    || fail "system-user mode (got '$out')"

# LOGIN_USER is ignored too — the account is pinned to SSH_USER.
out=$(php -r "
    define('LOGIN_CHECK_SYSTEM_USER',true);
    define('SSH_USER','pi'); define('SSH_PASS','pw'); define('SSH_PORT','22');
    define('LOGIN_REQUIRED',true); define('LOGIN_USER','someone-else'); define('LOGIN_PASS','');
    define('BASIC_AUTH',false);
    require '$ROOT/include/auth.php';
    echo gumcp_system_login('someone-else','pw') ? 'login_user-honoured' : 'pinned-to-ssh_user';
" 2>/dev/null)
[ "$out" = "pinned-to-ssh_user" ] && pass "when on: LOGIN_USER is ignored, account pinned to SSH_USER" \
                                 || fail "LOGIN_USER should be ignored (got '$out')"

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
