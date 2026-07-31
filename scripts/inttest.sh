#!/usr/bin/env bash
# GumCP integration test.
#
# scripts/selftest.sh calls functions directly; this drives a real HTTP server
# with real cookies. That distinction matters — the bugs that reached users were
# wiring bugs, not logic bugs: an access gate that was never invoked, session
# hardening placed after something had already started the session, a CSRF check
# that a GET simply walked around. None of those are visible from a unit test.
#
# Runs against PHP's built-in server on a throwaway copy of the tree, so it
# never touches the working config or logs.
set -u

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
PORT="${GUMCP_TEST_PORT:-8929}"
BASE="http://127.0.0.1:$PORT"
PASS=0
FAIL=0

pass() { echo "  ✓ $1"; PASS=$((PASS + 1)); }
fail() { echo "  ✗ $1"; FAIL=$((FAIL + 1)); }

TDIR="$(mktemp -d)"
JAR="$TDIR/cookies.txt"
cleanup() {
    [ -n "${SRV:-}" ] && kill "$SRV" 2>/dev/null
    rm -rf "$TDIR"
}
trap cleanup EXIT

# ── Throwaway install ─────────────────────────────────────────────────────────
cp -R "$ROOT/." "$TDIR/app" 2>/dev/null
rm -rf "$TDIR/app/.git"
# Start from empty runtime state: the working tree's logs, buttons and throttle
# counters must not leak into a test run (or the other way round).
rm -rf "$TDIR/app/command_logs" "$TDIR/app/buttons"
mkdir -p "$TDIR/app/command_logs" "$TDIR/app/buttons"

cat > "$TDIR/app/include/config.php" <<'CFG'
<?php
declare(strict_types=1);
define('SSH_PORT', '22');
define('SSH_USER', 'pi');
define('SSH_PASS', 'raspberry');
define('LOGIN_REQUIRED', true);
define('LOGIN_USER', 'tester');
define('LOGIN_PASS', 'correct-horse');
define('SESSION_IDLE_TIMEOUT', 2);
define('SESSION_ABSOLUTE_TIMEOUT', 0);
define('GUMCP_UPDATE_KEY', 'recovery-key-for-tests');
define('LOGIN_MAX_FAILURES', 3);
// The Button API runs a command with no login, so it stays off here.
$gumcp_modules = ['button_api' => ['module_active' => 0]];
CFG

php -S "127.0.0.1:$PORT" -t "$TDIR/app" >"$TDIR/server.log" 2>&1 &
SRV=$!

ready=""
for _ in 1 2 3 4 5 6 7 8 9 10; do
    curl -s -o /dev/null "$BASE/login.php" && { ready=1; break; }
    sleep 0.5
done

# A leftover server on this port would answer every request from a stale copy of
# the tree and quietly turn the whole run into nonsense. Refuse to guess.
if [ -z "$ready" ] || ! kill -0 "$SRV" 2>/dev/null; then
    echo "Could not start the test server on port $PORT:"
    cat "$TDIR/server.log"
    echo "Set GUMCP_TEST_PORT to a free port, or stop whatever is listening there."
    exit 1
fi
if ! curl -s "$BASE/login.php" | grep -q 'name="csrf_token"'; then
    echo "Port $PORT is answering, but not with this GumCP copy — something else"
    echo "is listening there. Set GUMCP_TEST_PORT to a free port."
    exit 1
fi

code()  { curl -s -o /dev/null -w '%{http_code}' "$@"; }

# The hidden input's value sits on the next line, so flatten before matching.
login_token() {
    curl -s "$@" "$BASE/login.php" | tr '\n' ' ' \
        | grep -o 'name="csrf_token"[^>]*value="[a-f0-9]*' \
        | head -1 | sed 's/.*value="//'
}
loc()   { curl -s -o /dev/null -w '%{redirect_url}' "$@"; }

# ── Access gate ───────────────────────────────────────────────────────────────
echo "Access gate"

[ "$(code "$BASE/index.php")" = "302" ] \
    && pass "unauthenticated dashboard is refused" \
    || fail "unauthenticated dashboard returned $(code "$BASE/index.php"), expected 302"

case "$(loc "$BASE/index.php")" in
    *login.php*) pass "refusal redirects to the login page" ;;
    *)           fail "refusal did not redirect to login.php" ;;
esac

# Every page must be gated, not just the dashboard — one ungated page is the
# whole vulnerability back again.
ungated=""
for page in index.php buttons.php actions.php check.php gpio.php docker.php \
            rpi.php packages.php logs.php cron.php users.php iframe.php; do
    [ -f "$TDIR/app/$page" ] || continue
    c=$(code "$BASE/$page")
    [ "$c" = "302" ] || [ "$c" = "401" ] || ungated="$ungated $page($c)"
done
[ -z "$ungated" ] && pass "every page requires authentication" \
                  || fail "reachable without a login:$ungated"

# ── Login flow ────────────────────────────────────────────────────────────────
echo "Login"

rm -f "$JAR"
token=$(login_token -c "$JAR")
[ -n "$token" ] && pass "login page issues a CSRF token" \
                || fail "no CSRF token on the login page"

# Wrong password must not authenticate.
curl -s -o /dev/null -b "$JAR" -c "$JAR" -X POST "$BASE/index.php" \
     -d "gumcp_login_user=tester" -d "gumcp_login_pass=wrong" -d "csrf_token=$token"
[ "$(code -b "$JAR" "$BASE/index.php")" = "302" ] \
    && pass "wrong password does not sign in" \
    || fail "wrong password was accepted"

# A valid password without a CSRF token must not authenticate either.
curl -s -o /dev/null -b "$JAR" -c "$JAR" -X POST "$BASE/index.php" \
     -d "gumcp_login_user=tester" -d "gumcp_login_pass=correct-horse"
[ "$(code -b "$JAR" "$BASE/index.php")" = "302" ] \
    && pass "login without a CSRF token is refused" \
    || fail "login succeeded with no CSRF token"

rm -f "$JAR"
token=$(login_token -c "$JAR")
sid_before=$(grep -o 'PHPSESSID[[:space:]]*[a-z0-9]*' "$JAR" | awk '{print $2}')

curl -s -o /dev/null -b "$JAR" -c "$JAR" -X POST "$BASE/index.php" \
     -d "gumcp_login_user=tester" -d "gumcp_login_pass=correct-horse" \
     -d "csrf_token=$token"

[ "$(code -b "$JAR" "$BASE/index.php")" = "200" ] \
    && pass "correct credentials sign in" \
    || fail "correct credentials did not sign in"

sid_after=$(grep -o 'PHPSESSID[[:space:]]*[a-z0-9]*' "$JAR" | awk '{print $2}')
[ -n "$sid_before" ] && [ "$sid_before" != "$sid_after" ] \
    && pass "session ID is regenerated on login (no fixation)" \
    || fail "session ID unchanged across login — fixation is possible"

# ── Response headers ──────────────────────────────────────────────────────────
echo "Headers"
hdrs=$(curl -sI -b "$JAR" "$BASE/index.php")
missing=""
for h in "X-Frame-Options: SAMEORIGIN" "X-Content-Type-Options: nosniff" \
         "Referrer-Policy: same-origin" "frame-ancestors 'self'"; do
    case "$hdrs" in *"$h"*) ;; *) missing="$missing [$h]";; esac
done
[ -z "$missing" ] && pass "security headers present on a signed-in page" \
                  || fail "missing headers:$missing"

# ── AJAX ──────────────────────────────────────────────────────────────────────
echo "AJAX"

[ "$(code -b "$JAR" "$BASE/ajax.php?action=pkg_upgrade")" = "405" ] \
    && pass "GET to ajax.php is rejected (405)" \
    || fail "ajax.php answered a GET — CSRF check bypassable"

[ "$(code -b "$JAR" -X POST "$BASE/ajax.php" -d "action=server_info")" = "403" ] \
    && pass "POST without a CSRF token is rejected (403)" \
    || fail "ajax.php accepted a POST with no CSRF token"

atoken=$(curl -s -b "$JAR" "$BASE/index.php" | tr '\n' ' ' \
         | grep -o "CSRF_TOKEN *= *['\"][a-f0-9]*" | head -1 | sed "s/.*['\"]//")
body=$(curl -s -b "$JAR" -X POST "$BASE/ajax.php" \
       -d "action=server_info" -d "csrf_token=$atoken")
case "$body" in
    *uptime*|*memory*) pass "POST with a valid CSRF token is served" ;;
    *)                 fail "valid AJAX POST failed: ${body:0:120}" ;;
esac

# An unauthenticated caller must get JSON 401, never data.
[ "$(code -X POST "$BASE/ajax.php" -d "action=server_info")" = "401" ] \
    && pass "unauthenticated AJAX is refused (401)" \
    || fail "unauthenticated AJAX was not refused"

# ── Protected directories ─────────────────────────────────────────────────────
# buttons/buttons.json holds each button's API hash — a credential that runs a
# command with no login. The built-in server ignores .htaccess, exactly like
# Apache with AllowOverride None, so this checks the case users actually hit.
echo "Runtime data"
# This server, like Apache with AllowOverride None, ignores .htaccess — so a
# 200 here is expected and is exactly why the server-level config must ship.
# What is testable is that the shipped rules actually deny these paths.
denied=""
for f in "$ROOT/buttons/.htaccess" "$ROOT/command_logs/.htaccess"; do
    grep -qE "Deny from all|Require all denied" "$f" || denied="$denied $f"
done
for path in buttons command_logs "include" ; do
    grep -q "$path" "$ROOT/deploy/gumcp-apache.conf" || denied="$denied conf:$path"
done
[ -z "$denied" ] && pass "runtime data denied by both .htaccess and the server config" \
                 || fail "no deny rule for:$denied"

# ── Button API ────────────────────────────────────────────────────────────────
echo "Button API"
[ "$(code "$BASE/api.php?hash=deadbeefdeadbeefdeadbeefdeadbeef")" = "403" ] \
    && pass "Button API is disabled unless switched on" \
    || fail "api.php answered while the module is disabled"

# ── Recovery updater ──────────────────────────────────────────────────────────
# update.php can run git reset --hard, so it must sit behind the same rules as
# everything else: no anonymous access, throttled key guessing, expiring sessions.
echo "Recovery updater"

[ "$(code "$BASE/update.php")" = "302" ] \
    && pass "update.php refuses an anonymous request" \
    || fail "update.php served without a login ($(code "$BASE/update.php"))"

[ "$(code -b "$JAR" "$BASE/update.php")" = "200" ] \
    && pass "a signed-in session reaches the updater" \
    || fail "signed-in session was refused by update.php"

[ "$(code "$BASE/update.php?key=recovery-key-for-tests")" = "200" ] \
    && pass "the emergency key works without a session" \
    || fail "valid emergency key was refused"

# Three wrong keys → locked; the right key must then be refused too.
for k in wrong1 wrong2 wrong3; do
    curl -s -o /dev/null "$BASE/update.php?key=$k"
done
[ "$(code "$BASE/update.php?key=wrong4")" = "429" ] \
    && pass "key guessing is throttled (429 after repeated failures)" \
    || fail "update.php key guessing is not throttled"
[ "$(code "$BASE/update.php?key=recovery-key-for-tests")" = "429" ] \
    && pass "lockout applies even to the correct key" \
    || fail "lockout can be bypassed by guessing correctly"

# ── Session expiry ────────────────────────────────────────────────────────────
# SESSION_IDLE_TIMEOUT is 2s in this install, so this is a real wait, not a stub.
echo "Session lifetime"
sleep 3
# One request only: it both proves the timeout and carries the explanation.
# A second request would just look unauthenticated, with nothing left to report.
read -r c target <<<"$(curl -s -o /dev/null -b "$JAR" \
    -w '%{http_code} %{redirect_url}' "$BASE/index.php")"
[ "$c" = "302" ] && pass "idle session is signed out" \
                 || fail "idle session still served (HTTP $c)"
case "$target" in
    *session_expired*) pass "expiry is explained on the login page" ;;
    *)                 fail "expiry did not redirect to ?action=session_expired (got '$target')" ;;
esac

# ── Audit log ─────────────────────────────────────────────────────────────────
echo "Authentication log"
log="$TDIR/app/command_logs/auth.log"
if [ -f "$log" ]; then
    grep -q "login_ok" "$log"     && pass "successful sign-in recorded" || fail "no login_ok in the auth log"
    grep -q "login_failed" "$log" && pass "failed attempt recorded"     || fail "no login_failed in the auth log"
    grep -q "expired" "$log"      && pass "session expiry recorded"     || fail "no expired entry in the auth log"
    grep -q "correct-horse" "$log" && fail "the auth log contains a password" \
                                   || pass "no password written to the auth log"
else
    fail "command_logs/auth.log was never created"
fi

echo ""
echo "$PASS passed, $FAIL failed."
if [ "$FAIL" -ne 0 ]; then
    echo "--- server log ---"
    tail -30 "$TDIR/server.log"
fi
exit $([ "$FAIL" -eq 0 ] && echo 0 || echo 1)
