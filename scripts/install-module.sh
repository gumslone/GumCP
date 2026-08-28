#!/bin/bash
# Install an optional third-party GumCP module from its upstream project.
#
# These are NOT bundled with GumCP: shipping a copy means shipping whatever
# vulnerabilities that copy had on the day it was vendored, and it silently goes
# stale. Installing from upstream lets you pick — and later update — the version.
#
#   ./scripts/install-module.sh adminer            # default pinned version
#   ./scripts/install-module.sh adminer 4.8.1      # explicit version
#   ./scripts/install-module.sh tinyfilemanager 2.6
#   ./scripts/install-module.sh --list
#
# The upstream file is placed in modules/<name>/vendor/ (blocked from direct web
# access) and reached through a generated entry file that enforces GumCP's login
# before any third-party code runs.

if [ -z "${BASH_VERSION:-}" ]; then exec bash "$0" "$@"; fi
set -u

RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; NC='\033[0m'
info()  { echo -e "${GREEN}[INFO]${NC} $1"; }
warn()  { echo -e "${YELLOW}[WARN]${NC} $1"; }
fail()  { echo -e "${RED}[ERROR]${NC} $1"; exit 1; }

GUMCP_DIR="$(cd "$(dirname "$0")/.." && pwd)"

# Defaults are pinned to a known-good release; override with the version argument.
ADMINER_DEFAULT="5.5.1"
TFM_DEFAULT="2.6"

usage() {
    cat <<USAGE
Usage: $(basename "$0") <module> [version]

Modules:
  adminer           Database manager      (upstream: vrana/adminer, default $ADMINER_DEFAULT)
  tinyfilemanager   Web file manager      (upstream: prasathmani/tinyfilemanager, default $TFM_DEFAULT)

Pick versions from the upstream releases pages:
  https://github.com/vrana/adminer/releases
  https://github.com/prasathmani/tinyfilemanager/releases

After installing, enable the module in include/config.php:
  \$gumcp_modules['adminer']['module_active'] = 1;
USAGE
}

[ $# -lt 1 ] && { usage; exit 1; }
case "$1" in -h|--help|--list) usage; exit 0;; esac

MODULE="$1"
VERSION="${2:-}"

case "$MODULE" in
    adminer)
        VERSION="${VERSION:-$ADMINER_DEFAULT}"
        URL="https://github.com/vrana/adminer/releases/download/v${VERSION}/adminer-${VERSION}.php"
        VENDOR_FILE="adminer-${VERSION}.modulesrc"
        ENTRY="adminer.php"
        ;;
    tinyfilemanager)
        VERSION="${VERSION:-$TFM_DEFAULT}"
        URL="https://raw.githubusercontent.com/prasathmani/tinyfilemanager/${VERSION}/tinyfilemanager.php"
        VENDOR_FILE="tinyfilemanager-${VERSION}.modulesrc"
        ENTRY="tinyfilemanager.php"
        ;;
    *)
        fail "Unknown module '$MODULE'. Run with --list to see the options."
        ;;
esac

DEST="$GUMCP_DIR/modules/$MODULE"
info "Installing $MODULE $VERSION"
info "Source: $URL"

command -v curl >/dev/null 2>&1 || fail "curl is required (sudo apt-get install -y curl)"

mkdir -p "$DEST/vendor" || fail "Could not create $DEST/vendor"

TMP="$(mktemp)"
# -f makes curl fail on 404 so a bad version number is reported, not saved.
if ! curl -fsSL "$URL" -o "$TMP"; then
    rm -f "$TMP"
    fail "Download failed. Does version '$VERSION' exist? See the releases page (--list)."
fi

# Guard against a redirect/error page being saved as if it were the module.
head -c 5 "$TMP" | grep -q '<?php' || { rm -f "$TMP"; fail "Downloaded file is not PHP — aborting."; }

# The upstream file is stored WITHOUT a .php extension, so the web server has no
# handler for it and cannot execute it however it is requested. PHP's require()
# ignores the extension, so the guarded entry point loads it normally.
#
# The file is deliberately left byte-for-byte as upstream published it: injecting
# a guard would break modules that open with a namespace declaration (Adminer 5.x
# does), which PHP requires to be the first statement in the file.

mv "$TMP" "$DEST/vendor/$VENDOR_FILE" || fail "Could not write $DEST/vendor/$VENDOR_FILE"
chmod 644 "$DEST/vendor/$VENDOR_FILE"

# Installs made by older GumCP versions stored the upstream file WITH its .php
# extension — directly executable, which is exactly what the layout above
# prevents. Left in place they fail verification forever, even after a
# reinstall, so clean them out. (They are unmodified upstream copies; deleting
# them loses nothing.)
find "$DEST/vendor" -maxdepth 1 -type f -name '*.php' -delete 2>/dev/null || true

# Block direct web access to the raw upstream file: it must only ever be reached
# through the guarded entry file below.
#
# NOTE: these are defence in depth only. Debian and Raspberry Pi OS ship Apache
# with "AllowOverride None" for /var/www, which makes .htaccess inert — the
# non-.php extension above is what actually stops direct execution.
cat > "$DEST/vendor/.htaccess" <<'HT'
# The upstream module file is included by the guarded entry point in the parent
# directory. It must never be served directly — that would bypass the login.
Options -Indexes
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
<IfModule !mod_authz_core.c>
    Order allow,deny
    Deny from all
</IfModule>
HT

# Module directory: no listing, and nothing directly requestable except the
# guarded entry point (upstream archives often drop READMEs, configs and assets
# in here, which should not be browsable either).
cat > "$DEST/.htaccess" <<HT
# Managed by scripts/install-module.sh
Options -Indexes

# Deny everything by default, except the guarded entry point that enforces the
# GumCP login. Written for both Apache 2.4 and 2.2 — "Require all denied" is not
# understood by 2.2 and would return a 500 there.
<IfModule mod_authz_core.c>
    <Files "*">
        Require all denied
    </Files>
    <Files "$ENTRY">
        Require all granted
    </Files>
</IfModule>
<IfModule !mod_authz_core.c>
    <Files "*">
        Order allow,deny
        Deny from all
    </Files>
    <Files "$ENTRY">
        Order allow,deny
        Allow from all
    </Files>
</IfModule>
HT

# Generated entry point: enforces GumCP's login before the third-party code runs.
cat > "$DEST/$ENTRY" <<ENTRYPHP
<?php
// Generated by scripts/install-module.sh — do not edit.
// Enforces GumCP authentication before loading the third-party module.
declare(strict_types=1);

define('GUMCP_MODULE_KEY', '$MODULE');
require_once __DIR__ . '/../../include/module_guard.php';

require __DIR__ . '/vendor/$VENDOR_FILE';
ENTRYPHP
chmod 644 "$DEST/$ENTRY"

# Match the web-server ownership the installer sets, when we can.
if id -u www-data >/dev/null 2>&1 && [ "$(id -u)" -eq 0 ]; then
    chown -R www-data:www-data "$DEST"
fi

# Verify what we just wrote, rather than assuming it landed.
MISSING=""
[ -f "$DEST/$ENTRY" ]                || MISSING="$MISSING entry-file"
[ -f "$DEST/vendor/$VENDOR_FILE" ]   || MISSING="$MISSING vendor-file"
[ -f "$DEST/.htaccess" ]             || MISSING="$MISSING module-htaccess"
[ -f "$DEST/vendor/.htaccess" ]      || MISSING="$MISSING vendor-htaccess"
case "$VENDOR_FILE" in *.php) MISSING="$MISSING vendor-file-is-executable";; esac
grep -q 'module_guard.php' "$DEST/$ENTRY" 2>/dev/null              || MISSING="$MISSING entry-guard"

if [ -n "$MISSING" ]; then
    fail "Install incomplete — missing:$MISSING. The module may not be protected; remove $DEST and try again."
fi
info "Verified: guarded entry point, non-executable vendor file, and .htaccess files in place"

info "Installed to $DEST"
echo ""
echo "Next: enable it in include/config.php"
echo "    \$gumcp_modules['$MODULE']['module_active'] = 1;"
echo ""
warn "$MODULE is third-party software with its own security history."
warn "Re-run this script with a newer version to update it, and only enable"
warn "modules you actually use."
