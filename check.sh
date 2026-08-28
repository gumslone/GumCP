#!/bin/bash
# GumCP diagnostic and repair script
# Usage: bash check.sh          — check only
#        sudo bash check.sh --fix — check and apply fixes automatically
if [ -z "${BASH_VERSION:-}" ]; then
    exec bash "$0" "$@"
fi

set -euo pipefail

RED='\033[0;31m'
GRN='\033[0;32m'
YEL='\033[1;33m'
BLU='\033[0;34m'
NC='\033[0m'

GUMCP_DIR="${GUMCP_DIR:-/var/www/html/GumCP}"
WEB_USER="www-data"
AUTO_FIX=false
FAIL=0
FIXED=0

[ "${1:-}" = "--fix" ] && AUTO_FIX=true

# ── output helpers ─────────────────────────────────────────────────────────────
pass() { echo -e "  ${GRN}✓${NC} $1"; }
fail() { echo -e "  ${RED}✗${NC} $1"; FAIL=$((FAIL + 1)); }
warn() { echo -e "  ${YEL}!${NC} $1"; }
info() { echo -e "    ${BLU}→${NC} $1"; }

section() {
    echo ""
    echo -e "${BLU}── $1${NC}"
}

# Try to apply a fix. $1 = description, $2 = shell command.
# If not in --fix mode, just print the command.
try_fix() {
    local desc="$1" cmd="$2"
    if [ "$AUTO_FIX" = true ]; then
        if eval "$cmd"; then
            echo -e "    ${GRN}Fixed: $desc${NC}"
            FIXED=$((FIXED + 1))
        else
            echo -e "    ${RED}Could not fix: $desc${NC}"
        fi
    else
        info "Fix: $cmd"
    fi
}

# ── banner ─────────────────────────────────────────────────────────────────────
echo ""
echo "======================================================"
echo "  GumCP System Check"
echo "======================================================"
if [ "$AUTO_FIX" = true ]; then
    echo -e "  ${YEL}Mode: AUTO-FIX (running fixes automatically)${NC}"
else
    echo "  Mode: check-only (re-run with --fix to apply fixes)"
fi
echo "======================================================"

# ── hardware ───────────────────────────────────────────────────────────────────
section "Hardware"
PI_MODEL=$(cat /proc/device-tree/model 2>/dev/null | tr -d '\0' || echo "Unknown")
info "Model: $PI_MODEL"

IS_PI5=false
if echo "$PI_MODEL" | grep -q "Raspberry Pi 5"; then
    IS_PI5=true
fi

# ── PHP ────────────────────────────────────────────────────────────────────────
section "PHP"

if ! command -v php &>/dev/null; then
    fail "PHP is not installed"
    try_fix "install PHP" "sudo apt-get install -y php libapache2-mod-php"
else
    PHP_VER=$(php -r 'echo PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION;')
    PHP_MAJOR=$(php -r 'echo PHP_MAJOR_VERSION;')
    if [ "$PHP_MAJOR" -lt 7 ]; then
        fail "PHP $PHP_VER detected — minimum 7.0 required"
    else
        pass "PHP $PHP_VER"
    fi

    check_ext() {
        local ext="$1" pkg="$2" optional="${3:-}"
        if php -m 2>/dev/null | grep -qi "^$ext$"; then
            pass "php-$ext extension"
        else
            if [ -n "$optional" ]; then
                warn "php-$ext extension not loaded (optional)"
            else
                fail "php-$ext extension not loaded"
                try_fix "install php-$ext" "sudo apt-get install -y $pkg && sudo systemctl restart apache2"
            fi
        fi
    }

    check_ext "ssh2"    "php-ssh2"
    check_ext "json"    "php-json"
    check_ext "session" "php8*-common"
    check_ext "sqlite3" "php-sqlite3"    ""
    check_ext "curl"    "php-curl"       "optional"
fi

# ── Apache ─────────────────────────────────────────────────────────────────────
section "Apache"

if ! command -v apache2 &>/dev/null && ! command -v apache2ctl &>/dev/null; then
    fail "Apache2 not installed"
    try_fix "install apache2" "sudo apt-get install -y apache2"
else
    pass "apache2 installed"
    if systemctl is-active --quiet apache2 2>/dev/null; then
        pass "apache2 is running"
    else
        fail "apache2 is not running"
        try_fix "start apache2" "sudo systemctl enable apache2 && sudo systemctl start apache2"
    fi
fi

# ── SSH ────────────────────────────────────────────────────────────────────────
section "SSH"

if ! command -v sshd &>/dev/null && ! dpkg -l openssh-server &>/dev/null 2>&1; then
    fail "openssh-server not installed"
    try_fix "install openssh-server" "sudo apt-get install -y openssh-server && sudo systemctl enable ssh && sudo systemctl start ssh"
else
    pass "openssh-server installed"
    if systemctl is-active --quiet ssh 2>/dev/null || systemctl is-active --quiet sshd 2>/dev/null; then
        pass "SSH is running"
    else
        fail "SSH is not running"
        try_fix "start SSH" "sudo systemctl enable ssh && sudo systemctl start ssh"
    fi
fi

# ── GPIO tools ─────────────────────────────────────────────────────────────────
section "GPIO"

if [ "$IS_PI5" = false ]; then
    if command -v gpio &>/dev/null; then
        pass "WiringPi (gpio) installed"
    else
        fail "WiringPi (gpio) not found — required for Pi 1–4 GPIO"
        info "Fix: git clone https://github.com/WiringPi/WiringPi.git ~/wiringPi && cd ~/wiringPi && ./build"
    fi
else
    pass "WiringPi not required on Pi 5"
    if command -v raspi-gpio &>/dev/null; then
        pass "raspi-gpio installed"
    else
        fail "raspi-gpio not found — required for Pi 5 GPIO"
        try_fix "install raspi-gpio" "sudo apt-get install -y raspi-gpio"
    fi
fi

# ── GumCP directory ────────────────────────────────────────────────────────────
section "GumCP Directory ($GUMCP_DIR)"

if [ ! -d "$GUMCP_DIR" ]; then
    fail "GumCP directory not found: $GUMCP_DIR"
    info "Run installer.sh to install, or set GUMCP_DIR=/path/to/GumCP bash check.sh"
else
    pass "GumCP directory exists"

    # Ownership
    DIR_OWNER=$(stat -c '%U' "$GUMCP_DIR" 2>/dev/null || stat -f '%Su' "$GUMCP_DIR" 2>/dev/null || echo "unknown")
    if [ "$DIR_OWNER" = "$WEB_USER" ]; then
        pass "GumCP owned by $WEB_USER"
    else
        fail "GumCP owned by '$DIR_OWNER', expected '$WEB_USER'"
        try_fix "chown GumCP directory" "sudo chown -R $WEB_USER:$WEB_USER $GUMCP_DIR"
    fi

    # user_scripts/ directory (Script Editor)
    USCRIPTS_DIR="$GUMCP_DIR/user_scripts"
    if [ ! -d "$USCRIPTS_DIR" ]; then
        fail "user_scripts/ directory missing"
        try_fix "create user_scripts/" "sudo mkdir -p $USCRIPTS_DIR && sudo chown $WEB_USER:$WEB_USER $USCRIPTS_DIR && sudo chmod 755 $USCRIPTS_DIR"
    else
        pass "user_scripts/ directory exists"
    fi

    # Apache deny rules: the conf under /etc/apache2 is a copy made at install
    # time, so a git pull that adds a protected directory leaves it stale and
    # the new directory web-readable. Compare against the shipped conf.
    HARDEN_SRC="$GUMCP_DIR/deploy/gumcp-apache.conf"
    HARDEN_DST="/etc/apache2/conf-available/gumcp.conf"
    if [ -f "$HARDEN_SRC" ] && [ -d /etc/apache2/conf-available ]; then
        if [ -f "$HARDEN_DST" ] && sed "s|@GUMCP_DIR@|$GUMCP_DIR|g" "$HARDEN_SRC" | cmp -s - "$HARDEN_DST"; then
            pass "Apache deny rules are current"
        else
            fail "Apache deny rules missing or outdated — protected directories may be web-readable"
            try_fix "re-install gumcp-apache.conf" \
                "sudo sed 's|@GUMCP_DIR@|$GUMCP_DIR|g' $HARDEN_SRC | sudo tee $HARDEN_DST >/dev/null && sudo a2enconf gumcp && sudo systemctl reload apache2"
        fi
    fi

    # buttons/ directory
    BUTTONS_DIR="$GUMCP_DIR/buttons"
    if [ ! -d "$BUTTONS_DIR" ]; then
        fail "buttons/ directory missing"
        try_fix "create buttons/" "sudo mkdir -p $BUTTONS_DIR && sudo chown $WEB_USER:$WEB_USER $BUTTONS_DIR && sudo chmod 755 $BUTTONS_DIR"
    else
        pass "buttons/ directory exists"
        BDIR_OWNER=$(stat -c '%U' "$BUTTONS_DIR" 2>/dev/null || stat -f '%Su' "$BUTTONS_DIR" 2>/dev/null || echo "unknown")
        if [ "$BDIR_OWNER" = "$WEB_USER" ]; then
            pass "buttons/ owned by $WEB_USER"
        else
            fail "buttons/ owned by '$BDIR_OWNER', should be '$WEB_USER'"
            try_fix "chown buttons/" "sudo chown -R $WEB_USER:$WEB_USER $BUTTONS_DIR"
        fi
        # Write test
        TEST_FILE="$BUTTONS_DIR/.write_test_$$"
        if sudo -u "$WEB_USER" touch "$TEST_FILE" 2>/dev/null; then
            sudo rm -f "$TEST_FILE"
            pass "buttons/ is writable by $WEB_USER"
        else
            fail "buttons/ is not writable by $WEB_USER"
            try_fix "fix buttons/ permissions" "sudo chown $WEB_USER:$WEB_USER $BUTTONS_DIR && sudo chmod 755 $BUTTONS_DIR"
        fi
    fi

    # command_logs/ directory
    LOGS_DIR="$GUMCP_DIR/command_logs"
    if [ ! -d "$LOGS_DIR" ]; then
        fail "command_logs/ directory missing"
        try_fix "create command_logs/" "sudo mkdir -p $LOGS_DIR && sudo chown $WEB_USER:$WEB_USER $LOGS_DIR && sudo chmod 755 $LOGS_DIR"
    else
        pass "command_logs/ directory exists"
        LDIR_OWNER=$(stat -c '%U' "$LOGS_DIR" 2>/dev/null || stat -f '%Su' "$LOGS_DIR" 2>/dev/null || echo "unknown")
        if [ "$LDIR_OWNER" = "$WEB_USER" ]; then
            pass "command_logs/ owned by $WEB_USER"
        else
            fail "command_logs/ owned by '$LDIR_OWNER', should be '$WEB_USER'"
            try_fix "chown command_logs/" "sudo chown -R $WEB_USER:$WEB_USER $LOGS_DIR"
        fi
        TEST_FILE="$LOGS_DIR/.write_test_$$"
        if sudo -u "$WEB_USER" touch "$TEST_FILE" 2>/dev/null; then
            sudo rm -f "$TEST_FILE"
            pass "command_logs/ is writable by $WEB_USER"
        else
            fail "command_logs/ is not writable by $WEB_USER"
            try_fix "fix command_logs/ permissions" "sudo chown $WEB_USER:$WEB_USER $LOGS_DIR && sudo chmod 755 $LOGS_DIR"
        fi
    fi

    # config.php — not tracked by git; created from config.example.php on install
    CONFIG="$GUMCP_DIR/include/config.php"
    EXAMPLE="$GUMCP_DIR/include/config.example.php"
    if [ ! -f "$CONFIG" ]; then
        fail "include/config.php not found"
        if [ -f "$EXAMPLE" ]; then
            try_fix "copy config.example.php → config.php" \
                "sudo cp $EXAMPLE $CONFIG && sudo chown $WEB_USER:$WEB_USER $CONFIG && sudo chmod 664 $CONFIG"
        else
            info "Neither config.php nor config.example.php found — re-run installer.sh"
        fi
    else
        pass "include/config.php exists"
    fi
fi

# ── System commands ────────────────────────────────────────────────────────────
section "System Commands"

for cmd in ps who df service; do
    if command -v "$cmd" &>/dev/null; then
        pass "$cmd"
    else
        fail "$cmd not found"
        if [ "$cmd" = "service" ]; then
            try_fix "install sysvinit-utils" "sudo apt-get install -y sysvinit-utils"
        fi
    fi
done

# ── Summary ────────────────────────────────────────────────────────────────────
echo ""
echo "======================================================"
if [ "$FAIL" -eq 0 ]; then
    echo -e "${GRN}  All checks passed — GumCP should be fully functional.${NC}"
else
    echo -e "${RED}  $FAIL check(s) failed.${NC}"
    if [ "$AUTO_FIX" = true ]; then
        echo -e "  $FIXED fix(es) applied."
        if [ "$FIXED" -lt "$FAIL" ]; then
            echo -e "${YEL}  Some issues could not be fixed automatically.${NC}"
            echo    "  See messages above for manual steps."
        fi
    else
        echo    "  Re-run with --fix to apply fixes automatically:"
        echo    "  sudo bash $GUMCP_DIR/check.sh --fix"
        echo    ""
        echo    "  Or open in the browser for a visual report:"
        IP=$(hostname -I 2>/dev/null | awk '{print $1}')
        echo    "  http://${IP}/GumCP/check.php"
    fi
fi
echo "======================================================"
echo ""
