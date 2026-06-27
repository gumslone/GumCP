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

install_package() {
    local pkg=$1
    print_message "Installing $pkg..."
    if ! sudo apt-get install -y "$pkg"; then
        print_error "Failed to install $pkg"
        exit 1
    fi
}

# ── banner ────────────────────────────────────────────────────────────────────
echo ""
echo "======================================"
echo "       GumCP Installer v1.0"
echo "======================================"
echo ""

# ── pre-flight checks ─────────────────────────────────────────────────────────
if [ "$(id -u)" -eq 0 ]; then
    print_error "Do not run as root. The script calls sudo where needed."
    exit 1
fi

if ! command -v apt-get >/dev/null 2>&1; then
    print_error "This installer requires apt-get (Debian/Raspberry Pi OS)."
    exit 1
fi

# Detect Raspberry Pi model from device-tree (works on all Pi models)
PI_MODEL=$(cat /proc/device-tree/model 2>/dev/null | tr -d '\0' || echo "Unknown")
print_message "Detected hardware: $PI_MODEL"

IS_PI5=false
if echo "$PI_MODEL" | grep -q "Raspberry Pi 5"; then
    IS_PI5=true
    print_message "Raspberry Pi 5 detected — WiringPi is not supported on this model."
fi

# ── system update ─────────────────────────────────────────────────────────────
print_message "Updating system packages..."
if ! sudo apt-get update -y; then
    print_error "System update failed"
    exit 1
fi

# ── dependencies ──────────────────────────────────────────────────────────────
install_package "git"
install_package "apache2"
install_package "php"
install_package "libapache2-mod-php"
install_package "php-ssh2"
install_package "php-sqlite3"
install_package "php-curl"
install_package "php-zip"

# ── WiringPi (Pi 1–4 only) ───────────────────────────────────────────────────
if [ "$IS_PI5" = false ]; then
    print_message "Installing WiringPi (community fork)..."

    WIRING_DIR="$HOME/wiringPi"

    if [ -d "$WIRING_DIR" ]; then
        print_warning "WiringPi directory already exists at $WIRING_DIR."
        read -r -p "Remove it and reinstall? [y/N] " confirm
        if [[ "$confirm" =~ ^[Yy]$ ]]; then
            rm -rf "$WIRING_DIR"
        else
            print_message "Skipping WiringPi installation."
        fi
    fi

    if [ ! -d "$WIRING_DIR" ]; then
        # Clone as current user (no sudo) so build works without permission errors.
        # The original git.drogon.net URL is defunct; use the community fork.
        if ! git clone https://github.com/WiringPi/WiringPi.git "$WIRING_DIR"; then
            print_error "Failed to clone WiringPi"
            exit 1
        fi
        cd "$WIRING_DIR" || exit 1
        if ! ./build; then
            print_error "WiringPi build failed"
            exit 1
        fi
        cd - >/dev/null || exit 1
        print_message "WiringPi installed successfully"
    fi
else
    # raspi-gpio is included in Raspberry Pi OS Buster+ and provides pin
    # read access on Pi 5; gpio.php falls back to it automatically.
    print_message "Ensuring raspi-gpio is available for Pi 5..."
    install_package "raspi-gpio"
fi

# ── GumCP ─────────────────────────────────────────────────────────────────────
print_message "Installing GumCP..."
GUMCP_DIR="/var/www/html/GumCP"

if [ -d "$GUMCP_DIR" ]; then
    print_warning "GumCP directory already exists at $GUMCP_DIR."
    read -r -p "Remove it and reinstall? [y/N] " confirm
    if [[ "$confirm" =~ ^[Yy]$ ]]; then
        sudo rm -rf "$GUMCP_DIR"
    else
        print_message "Skipping GumCP clone — using existing installation."
    fi
fi

if [ ! -d "$GUMCP_DIR" ]; then
    if ! sudo git clone https://github.com/gumslone/GumCP.git "$GUMCP_DIR"; then
        print_error "Failed to clone GumCP"
        exit 1
    fi
fi

# ── config.php ────────────────────────────────────────────────────────────────
# config.php is NOT tracked by git so your credentials survive git pull.
# On a fresh install, copy the example template to create it.
if [ ! -f "$GUMCP_DIR/include/config.php" ]; then
    print_message "Creating include/config.php from template..."
    sudo cp "$GUMCP_DIR/include/config.example.php" "$GUMCP_DIR/include/config.php"
else
    print_message "include/config.php already exists — skipping (your settings are preserved)."
fi

# ── writable directories ──────────────────────────────────────────────────────
# Create directories that the web server writes to at runtime.
print_message "Creating writable directories..."
sudo mkdir -p "$GUMCP_DIR/buttons"
sudo mkdir -p "$GUMCP_DIR/command_logs"

# ── permissions ───────────────────────────────────────────────────────────────
print_message "Setting permissions..."
sudo chown -R www-data:www-data "$GUMCP_DIR"
sudo chmod -R 755 "$GUMCP_DIR"
sudo chmod 664 "$GUMCP_DIR/include/config.php"
print_message "Permissions set"

# ── web-server group access ─────────────────────────────────────────────────────
# Add www-data to the video group so the dashboard's Power & Throttling panel can
# run `vcgencmd get_throttled` (needs GPU access). Harmless on non-Pi hardware.
if getent group video >/dev/null 2>&1; then
    print_message "Adding www-data to the 'video' group (for vcgencmd)..."
    sudo usermod -aG video www-data
fi

# ── Apache ────────────────────────────────────────────────────────────────────
print_message "Enabling Apache modules..."
sudo a2enmod rewrite
# Enable the installed PHP module (name varies by PHP version, e.g. php8.2)
PHP_MOD=$(ls /etc/apache2/mods-available/php*.load 2>/dev/null | head -1 | xargs -I{} basename {} .load)
if [ -n "$PHP_MOD" ]; then
    sudo a2enmod "$PHP_MOD"
else
    print_warning "Could not detect PHP Apache module name — you may need to enable it manually."
fi

print_message "Restarting Apache..."
if ! sudo systemctl restart apache2; then
    print_error "Apache failed to restart — check: sudo journalctl -u apache2"
    exit 1
fi

# ── done ──────────────────────────────────────────────────────────────────────
IP=$(hostname -I | awk '{print $1}')

echo ""
echo "======================================"
echo "   Installation Complete!"
echo "======================================"
echo ""
print_message "GumCP has been successfully installed!"
echo ""
echo "Access GumCP at:"
echo -e "  ${GREEN}http://${IP}/GumCP/${NC}"
echo ""
echo "Default credentials (set in /var/www/html/GumCP/include/config.php):"
echo "  Username: pi"
echo "  Password: raspberry"
echo ""
print_warning "Change the default credentials in config.php before exposing GumCP to a network!"
echo ""
echo "For issues visit: https://github.com/gumslone/GumCP/issues"
echo ""
echo "======================================"
echo ""
