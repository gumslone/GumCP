#!/bin/bash
# Re-exec with bash if invoked via sh or another shell
if [ -z "${BASH_VERSION:-}" ]; then
    exec bash "$0" "$@"
fi

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

print_message() { echo -e "${GREEN}[INFO]${NC} $1"; }
print_error()   { echo -e "${RED}[ERROR]${NC} $1"; }
print_warning() { echo -e "${YELLOW}[WARNING]${NC} $1"; }

# ── banner ────────────────────────────────────────────────────────────────────
echo ""
echo "======================================"
echo "       GumCP Uninstaller"
echo "======================================"
echo ""

# ── pre-flight checks ─────────────────────────────────────────────────────────
if [ "$(id -u)" -eq 0 ]; then
    print_error "Do not run as root. The script calls sudo where needed."
    exit 1
fi

GUMCP_DIR="/var/www/html/GumCP"

if [ ! -d "$GUMCP_DIR" ]; then
    print_warning "GumCP directory not found at $GUMCP_DIR — nothing to remove."
    exit 0
fi

# ── confirmation ──────────────────────────────────────────────────────────────
echo "This will remove:"
echo "  - GumCP files:  $GUMCP_DIR"
echo ""
echo "This will NOT remove:"
echo "  - Apache, PHP, or php-ssh2 (shared system packages)"
echo "  - WiringPi"
echo ""

read -r -p "Are you sure you want to uninstall GumCP? [y/N] " confirm
if [[ ! "$confirm" =~ ^[Yy]$ ]]; then
    print_message "Uninstall cancelled."
    exit 0
fi

# ── optional: keep user data ──────────────────────────────────────────────────
KEEP_DATA=false
read -r -p "Keep your config.php, buttons and command logs? [Y/n] " keep
if [[ ! "$keep" =~ ^[Nn]$ ]]; then
    KEEP_DATA=true
fi

# ── back up user data if requested ───────────────────────────────────────────
BACKUP_DIR=""
if [ "$KEEP_DATA" = true ]; then
    BACKUP_DIR="$HOME/gumcp_backup_$(date +%Y%m%d_%H%M%S)"
    print_message "Backing up user data to $BACKUP_DIR ..."
    mkdir -p "$BACKUP_DIR"

    [ -f "$GUMCP_DIR/include/config.php" ] && \
        cp "$GUMCP_DIR/include/config.php" "$BACKUP_DIR/"

    [ -d "$GUMCP_DIR/buttons" ] && \
        cp -r "$GUMCP_DIR/buttons" "$BACKUP_DIR/"

    [ -d "$GUMCP_DIR/command_logs" ] && \
        cp -r "$GUMCP_DIR/command_logs" "$BACKUP_DIR/"

    [ -f "$GUMCP_DIR/include/menu_order.json" ] && \
        cp "$GUMCP_DIR/include/menu_order.json" "$BACKUP_DIR/"

    print_message "Backup saved to $BACKUP_DIR"
fi

# ── remove GumCP ─────────────────────────────────────────────────────────────
print_message "Removing GumCP from $GUMCP_DIR ..."
if ! sudo rm -rf "$GUMCP_DIR"; then
    print_error "Failed to remove $GUMCP_DIR — check permissions."
    exit 1
fi
print_message "GumCP removed."

# ── remove the Apache hardening config ────────────────────────────────────────
# installer.sh writes this outside GUMCP_DIR, so deleting the directory alone
# would leave an enabled config referencing a path that no longer exists.
if [ -f /etc/apache2/conf-available/gumcp.conf ]; then
    print_message "Removing the Apache hardening config..."
    sudo a2disconf gumcp >/dev/null 2>&1
    sudo rm -f /etc/apache2/conf-available/gumcp.conf
    if sudo systemctl reload apache2 >/dev/null 2>&1; then
        print_message "Apache config removed and reloaded"
    else
        print_warning "Removed the config, but Apache did not reload — run: sudo systemctl reload apache2"
    fi
fi

# Deliberately NOT undone, because other software may rely on them:
#   • www-data's membership of the 'video' group
#   • the Apache 'rewrite' and PHP modules
# Remove those by hand if GumCP was the only thing using them.

# ── done ──────────────────────────────────────────────────────────────────────
echo ""
echo "======================================"
echo "   Uninstall Complete!"
echo "======================================"
echo ""
if [ "$KEEP_DATA" = true ] && [ -n "$BACKUP_DIR" ]; then
    print_message "Your data is saved at: $BACKUP_DIR"
    echo ""
    echo "To restore later, copy the backed-up files into a fresh GumCP install:"
    echo "  cp $BACKUP_DIR/config.php /var/www/html/GumCP/include/"
    echo "  cp -r $BACKUP_DIR/buttons /var/www/html/GumCP/"
    echo "  cp -r $BACKUP_DIR/command_logs /var/www/html/GumCP/"
    echo ""
fi
echo "To reinstall GumCP, run:"
echo "  bash <(curl -s https://raw.githubusercontent.com/gumslone/GumCP/master/installer.sh)"
echo ""
echo "======================================"
echo ""
