<a href="https://www.buymeacoffee.com/gumslone" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="41" width="174"></a>

# GumCP — Web Control Panel for Raspberry Pi

If you find GumCP useful, please **⭐️ star** the repo to help others find it!

![Web Control Panel for Raspberry Pi](https://github.com/gumslone/GumCP/blob/master/screenshots/dashboard.png)

More screenshots in the [screenshots folder](https://github.com/gumslone/GumCP/blob/master/screenshots/).

[![Web Control Panel for Raspberry Pi](https://github.com/gumslone/GumCP/blob/master/screenshots/video.png)](https://youtu.be/rCi9OGLOstU)

---

## Features

- **Dashboard** — live CPU usage, temperature, memory & disk, uptime, load averages, active users (auto-refreshes every 30 s without reloading the page)
- **Services** — list all system services with their status; start or stop any service with one click (loads asynchronously so the page appears instantly)
- **Processes** — browse running processes sorted by memory usage; kill by PID or name
- **GPIO control** — view and toggle pin mode (IN/OUT), voltage (HIGH/LOW) and pull-up/down for all header pins; auto-detects WiringPi (Pi 1–4) or raspi-gpio (Pi 5)
- **Command Buttons** — create custom one-click buttons for any shell command (restart a service, run a script, toggle a GPIO pin, etc.); output shown inline in a modal
- **Actions** — execute arbitrary shell commands over SSH; run commands in the background with output saved to a log file; reboot
- **phpinfo** — view PHP configuration directly from the browser
- **System Check** — built-in diagnostic page (`check.php`) that verifies PHP extensions, directory permissions, SSH connectivity and GPIO tools; Fix buttons repair common issues over SSH without touching the terminal
- **Optional modules** — File Manager, Database Manager, TeHyBug sensor support (temperature, humidity, barometric pressure)

## Compatibility

| Raspberry Pi model | GPIO tool |
|---|---|
| Pi 1 / Pi 2 / Pi 3 / Pi 4 | WiringPi (community fork) |
| Pi 5 | raspi-gpio (automatic fallback) |

**PHP 7.0, 7.4, 8.0, 8.1, 8.2, 8.3** are all supported.

---

## Quick Install

Run these two commands on your Raspberry Pi (via SSH or a terminal):

```bash
sudo apt-get update && sudo apt-get install -y wget
wget https://raw.githubusercontent.com/gumslone/GumCP/master/installer.sh && bash ./installer.sh
```

The installer will:
- Install Apache, PHP and all required extensions (`php-ssh2`, `php-sqlite3`, `php-curl`, `php-zip`)
- Install WiringPi (Pi 1–4) or `raspi-gpio` (Pi 5) automatically
- Clone GumCP into `/var/www/html/GumCP/`
- Create `include/config.php` from the bundled template
- Create writable directories (`buttons/`, `command_logs/`) with correct ownership
- Set file permissions for the `www-data` web-server user

Once complete, open GumCP in a browser:

```
http://<your-pi-ip>/GumCP/
```

> **Default credentials** (set in `include/config.php`):
> - Username: `pi`
> - Password: `raspberry`
>
> **Change these before exposing GumCP to any network.**

---

## Manual Install

### 1. Install Apache and PHP

```bash
sudo apt-get update
sudo apt-get install -y apache2 php libapache2-mod-php php-ssh2 php-sqlite3 php-curl php-zip
sudo systemctl restart apache2
```

### 2. Install GPIO tool

**Pi 1, 2, 3, 4** — WiringPi community fork (the original `git.drogon.net` URL is no longer available):

```bash
git clone https://github.com/WiringPi/WiringPi.git ~/wiringPi
cd ~/wiringPi && ./build
```

**Pi 5** — WiringPi does not support the RP1 GPIO chip; use `raspi-gpio` instead:

```bash
sudo apt-get install -y raspi-gpio
```

GumCP's GPIO page detects the available tool automatically.

### 3. Clone and configure

```bash
sudo git clone https://github.com/gumslone/GumCP.git /var/www/html/GumCP
cd /var/www/html/GumCP

# Create your local config from the template
sudo cp include/config.example.php include/config.php

# Create runtime directories
sudo mkdir -p buttons command_logs

# Set ownership and permissions
sudo chown -R www-data:www-data /var/www/html/GumCP
sudo chmod -R 755 /var/www/html/GumCP
sudo chmod 664 /var/www/html/GumCP/include/config.php
```

### 4. Configure

Edit `include/config.php` to set your credentials and SSH settings:

```bash
sudo nano /var/www/html/GumCP/include/config.php
```

Key settings:

```php
define('SSH_PORT', '22');        // SSH port
define('SSH_USER', 'pi');        // SSH username
define('SSH_PASS', 'raspberry'); // SSH password

define('LOGIN_REQUIRED', false); // set true to enable the login page
define('LOGIN_USER', 'pi');
define('LOGIN_PASS', 'raspberry');
```

---

## Upgrade

`include/config.php` is **not tracked by git** — your credentials and settings are preserved across upgrades automatically.

```bash
cd /var/www/html/GumCP
sudo git pull origin master
```

---

## System Check

GumCP includes a built-in diagnostic tool. Open it in your browser:

```
http://<your-pi-ip>/GumCP/check.php
```

Or run the CLI version on the Pi:

```bash
# Check only
bash /var/www/html/GumCP/check.sh

# Check and auto-fix permissions/missing directories
sudo bash /var/www/html/GumCP/check.sh --fix
```

The check covers PHP extensions, directory writability, SSH connectivity, GPIO tools and required system commands. Each failing item shows a **Fix** button that applies the repair over SSH without needing a terminal.

---

## Troubleshooting

### Actions or Buttons page returns an SSH error

These pages require the `php-ssh2` extension and a running SSH server:

```bash
sudo apt-get install -y php-ssh2
sudo systemctl enable ssh && sudo systemctl start ssh
sudo systemctl restart apache2
```

### "Failed to save button — check that the buttons directory is writable"

The `buttons/` directory is missing or not owned by `www-data`:

```bash
sudo mkdir -p /var/www/html/GumCP/buttons
sudo chown www-data:www-data /var/www/html/GumCP/buttons
```

Or use the System Check page's Fix button.

### GPIO page shows no data

- **Pi 1–4:** Install WiringPi (see above) and verify with `gpio readall`
- **Pi 5:** Install `raspi-gpio`: `sudo apt-get install -y raspi-gpio` and verify with `raspi-gpio get`

### TeHyBug module

TeHyBug is a low-power temperature/humidity/pressure Wi-Fi tracker available at [Tindie](https://www.tindie.com/stores/gumslone/).

Enable it in `config.php` (`module_active => 1`). Requires SQLite:

```bash
sudo apt-get install -y php-sqlite3
```

---

## Security Notes

- **Change default credentials** in `include/config.php` before putting GumCP on any network
- Enable `LOGIN_REQUIRED` in `config.php` for password-protected access
- GumCP executes commands as the SSH user — use a dedicated user with only the permissions it needs
- If your Pi is reachable from the internet, block GumCP from search crawlers (`/var/www/html/robots.txt`):

```
User-agent: *
Disallow: /GumCP/
```

---

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/donate/?hosted_button_id=VCWHQPACTXV5N)
