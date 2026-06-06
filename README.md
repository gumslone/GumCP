<a href="https://www.buymeacoffee.com/gumslone" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="41" width="174"></a>

# GumCP — Web Control Panel for Raspberry Pi

If you find GumCP useful, please **⭐️ star** the repo to help others find it!

![Web Control Panel for Raspberry Pi](https://github.com/gumslone/GumCP/blob/master/screenshots/dashboard.png)

More screenshots in the [screenshots folder](https://github.com/gumslone/GumCP/blob/master/screenshots/).

[![Web Control Panel for Raspberry Pi](https://github.com/gumslone/GumCP/blob/master/screenshots/video.png)](https://youtu.be/rCi9OGLOstU)

---

## Features

- System dashboard — CPU load, temperature, memory & disk usage, uptime, active users
- Start / stop system services
- Kill processes by PID or name
- GPIO pin control — read mode, value and pull-up/down for all pins (requires WiringPi on Pi 1–4, or raspi-gpio on Pi 5)
- System reboot
- Execute arbitrary commands over SSH (advanced users)
- Custom buttons — one-click execution of saved commands (set GPIO, run Python/Bash scripts, etc.)
- Optional third-party modules: File Manager, Database Manager (activate in `config.php`)
- TeHyBug sensor module support (temperature, humidity, barometric pressure)

## Compatibility

| Raspberry Pi model | Tested | GPIO support |
|---|---|---|
| Pi 1 / Pi 2 / Pi 3 | ✅ | WiringPi |
| Pi 4 | ✅ | WiringPi (community fork) |
| Pi 5 | ✅ | raspi-gpio (automatic fallback) |

**PHP 7.4, 8.0, 8.1, 8.2, 8.3** are all supported.

---

## Quick Install

Run these two commands on your Raspberry Pi (via SSH or a terminal):

```bash
sudo apt-get update && sudo apt-get install -y wget
wget https://raw.githubusercontent.com/gumslone/GumCP/master/installer.sh && bash ./installer.sh
```

The installer will:
- Install Apache, PHP and required extensions
- Install WiringPi (Pi 1–4) or raspi-gpio (Pi 5) automatically
- Clone GumCP into `/var/www/html/GumCP/`
- Set correct permissions

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

### 2. Install WiringPi

**Pi 1, 2, 3, 4** — use the community fork (the original `git.drogon.net` URL is no longer available):

```bash
git clone https://github.com/WiringPi/WiringPi.git ~/wiringPi
cd ~/wiringPi
./build
```

**Pi 5** — WiringPi does not support the RP1 GPIO chip. Use `raspi-gpio` instead (included in Raspberry Pi OS Buster and later):

```bash
sudo apt-get install -y raspi-gpio
```

GumCP's GPIO page detects the available tool automatically.

### 3. Install GumCP

```bash
sudo git clone https://github.com/gumslone/GumCP.git /var/www/html/GumCP
sudo chown -R www-data:www-data /var/www/html/GumCP
sudo chmod -R 755 /var/www/html/GumCP
sudo chmod 664 /var/www/html/GumCP/include/config.php
```

### 4. Configure

Edit `include/config.php` to set your SSH credentials and enable/disable modules:

```bash
sudo nano /var/www/html/GumCP/include/config.php
```

Key settings:

```php
define('SSH_PORT', '22');       // SSH port
define('SSH_USER', 'pi');       // SSH username
define('SSH_PASS', 'raspberry');// SSH password

define('LOGIN_REQUIRED', false);// set true to enable the login page
define('LOGIN_USER', 'pi');
define('LOGIN_PASS', 'raspberry');
```

---

## Upgrade

```bash
cd /var/www/html/GumCP
sudo git pull origin master
```

After upgrading, review `include/config.php` — new config options may have been added.

---

## Troubleshooting

### `actions.php` or `buttons.php` return an error

These pages require the `php-ssh2` extension:

```bash
sudo apt-get install -y php-ssh2
sudo systemctl restart apache2
```

### GPIO page shows no data

- **Pi 1–4:** Install WiringPi (see Manual Install above) and verify with `gpio readall`
- **Pi 5:** Install raspi-gpio: `sudo apt-get install -y raspi-gpio` and verify with `raspi-gpio get`

### TeHyBug module

TeHyBug is a low-power temperature/humidity/pressure Wi-Fi tracker available at [Tindie](https://www.tindie.com/stores/gumslone/).

Enable it in `config.php` (`module_active => 1`). Requires SQLite:

```bash
sudo apt-get install -y sqlite3 php-sqlite3
```

---

## Security Notes

- **Change default credentials** in `config.php` before putting GumCP on any network
- Enable `LOGIN_REQUIRED` in `config.php` for password-protected access
- If your Pi is reachable from the internet, block GumCP from search crawlers by placing a `robots.txt` in your web root (`/var/www/html/`):

```
User-agent: *
Disallow: /GumCP/
```

---

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/donate/?hosted_button_id=VCWHQPACTXV5N)
