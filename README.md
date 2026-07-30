<p align="center">
  <img src="docs/logo.svg" alt="GumCP — Raspberry Pi Web Control Panel" width="720">
</p>

<p align="center">
  <a href="https://www.buymeacoffee.com/gumslone" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="41" width="174"></a>
</p>

# GumCP — Web Control Panel & Dashboard for Raspberry Pi

**GumCP** is a lightweight, self-hosted **web control panel for Raspberry Pi** — a simple open-source alternative to Webmin and Cockpit. Monitor your Pi from any browser (system dashboard with CPU, memory, temperature, disk, swap and network stats), control **GPIO** pins, manage **systemd services** and processes, run shell commands over **SSH**, and trigger custom **command buttons** via a REST-style **HTTP API**. Built with PHP and Apache, it runs on every model from the Pi 1 to the Pi 5 and is ideal for homelab and home-automation setups.

If you find GumCP useful, please **⭐️ star** the repo to help others find it!

![GumCP dashboard for Raspberry Pi showing live CPU, memory, temperature, network and service status](screenshots/dashboard.png)

More screenshots in the [screenshots folder](screenshots/).

[![Watch the GumCP Raspberry Pi control panel demo video](screenshots/video.png)](https://youtu.be/rCi9OGLOstU)

---

## Features

- **Dashboard** — live CPU usage, temperature, memory, swap & disk, uptime, load averages, active users, per-interface network stats (IP, RX/TX, Wi-Fi signal), Raspberry Pi power/throttling status, configurable service status badges, and connected USB & block devices (auto-refreshes every 30 s without reloading the page)
- **Services** — list all system services with their status; start or stop any service with one click (loads asynchronously so the page appears instantly)
- **Processes** — browse running processes sorted by memory usage; kill by PID or name
- **GPIO control** — view and toggle pin mode (IN/OUT), voltage (HIGH/LOW) and pull-up/down for all header pins; auto-detects WiringPi (Pi 1–4) or raspi-gpio (Pi 5)
- **Raspberry Pi tools** — `vcgencmd` firmware, clock speeds, voltages, memory split and codec licences; enable/disable I2C, SPI, 1-Wire, SSH, VNC and camera via `raspi-config`; edit `config.txt` / `cmdline.txt` with automatic backup; live temperature & CPU-frequency history chart
- **Package Updates** — list upgradable apt packages with a count, refresh the index (`apt update`) and upgrade everything (`apt upgrade`) from the browser
- **System Logs** — browse the systemd journal, `dmesg` and `/var/log` files with adjustable line count and text filtering
- **Cron Jobs** — view, add and remove scheduled tasks in the user crontab; read-only view of `/etc/crontab`
- **Users & Groups** — read-only listing of system users and groups from `/etc/passwd` and `/etc/group`
- **Docker** — list containers, start/stop/restart/pause/remove them, view container logs, and browse images (disabled by default; enable in `config.php` if you run Docker)
- **Command Buttons** — create custom one-click buttons for any shell command; choose between a confirmation modal or direct execution with inline output; drag to reorder
- **Button API** — optional (off by default): every button gets a unique secret key so curl, Home Assistant or any automation tool can trigger it without a login; restrictable by IP
- **Actions** — execute arbitrary shell commands over SSH; run commands in the background with output saved to a log file; reboot; pull the latest GumCP version from GitHub with one click
- **phpinfo** — view PHP configuration directly from the browser
- **System Check** — built-in diagnostic page (`check.php`) that verifies PHP extensions, directory permissions, SSH connectivity and GPIO tools; Fix buttons repair common issues over SSH without touching the terminal
- **Menu reorder** — drag and drop navbar items into any order; preference saved automatically
- **Multilanguage** — English, German, Ukrainian, Spanish and French; set the default in `config.php` and switch from the navbar (remembered per session). Untranslated strings fall back to English; add a language by dropping a file into `include/lang/`
- **Authentication** — optional login page, HTTP Basic Auth, or both simultaneously with separate credentials
- **Optional modules** — File Manager and Database Manager (installed on demand from upstream, see [Optional third-party modules](#optional-third-party-modules)), TeHyBug sensor support (temperature, humidity, barometric pressure)

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
> You can sign in immediately — no extra setup step. **These are published here, so
> change the password as soon as you are in:** until you do, anyone who can reach
> the panel can sign in and run commands on this host. GumCP shows a warning banner
> on every page, and flags it in System Check, while the default is still in use.
>
> Change it in `include/config.php` (`LOGIN_PASS`), or from the browser at
> `setup.php` if no login is configured yet.

---

## Uninstall

```bash
wget https://raw.githubusercontent.com/gumslone/GumCP/master/uninstall.sh && bash ./uninstall.sh
```

The uninstaller will:
- Ask whether to **back up** your `config.php`, buttons and logs to `~/gumcp_backup_<timestamp>/` before removing anything
- Remove `/var/www/html/GumCP/`
- Leave Apache, PHP, WiringPi and all other system packages untouched

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

# Stop the web server serving runtime data (button API hashes, command output).
# .htaccess alone is ignored under Debian's default AllowOverride None.
sudo sed "s|@GUMCP_DIR@|/var/www/html/GumCP|g" deploy/gumcp-apache.conf \
    | sudo tee /etc/apache2/conf-available/gumcp.conf > /dev/null
sudo a2enconf gumcp

# Allow the web server to read GPU throttling status (dashboard Power & Throttling panel)
sudo usermod -aG video www-data
sudo systemctl restart apache2
```

### 4. Configure

Edit `include/config.php` to set your credentials and SSH settings:

```bash
sudo nano /var/www/html/GumCP/include/config.php
```

Key settings:

```php
define('SSH_PORT', '22');        // SSH port
define('SSH_USER', 'pi');        // the Pi account GumCP runs commands as
define('SSH_PASS', 'raspberry'); // its REAL system password — commands fail if wrong

// Web login. If you omit these they inherit SSH_USER / SSH_PASS above, so there
// is one password to keep current. Set them explicitly only if you want the web
// login to be a different account or password from the system one.
define('LOGIN_REQUIRED', true);  // false does NOT open the panel — see below
define('LOGIN_USER', 'pi');
define('LOGIN_PASS', 'raspberry'); // CHANGE THIS (and SSH_PASS above)

define('BASIC_AUTH', false);     // true = also accept HTTP Basic Auth
define('BASIC_AUTH_USER', 'api');
define('BASIC_AUTH_PASS', 'secret');
```

---

## Upgrade

`include/config.php`, `buttons/` and `command_logs/` are **not tracked by git** — your credentials, buttons and logs are preserved across upgrades automatically.

```bash
cd /var/www/html/GumCP
sudo git pull origin master
```

Or use the **Update GumCP** button on the Actions page — no terminal needed.

---

## Authentication

GumCP supports three modes, configurable independently:

| Mode | Config | Description |
|---|---|---|
| Login page *(default)* | `LOGIN_REQUIRED=true` | Browser redirected to the login form |
| Basic Auth | `BASIC_AUTH=true` | Browser shows the native credentials dialog; curl/API clients send an `Authorization` header |
| Both | both `true` | Either method grants access, with independent credentials |
| Refuses to serve | both `false` | **Not an open panel.** With no authentication configured GumCP shows setup instructions instead of the panel |
| Open *(dangerous)* | `GUMCP_ALLOW_UNAUTHENTICATED=true` | Deliberate opt-out. Anyone who can reach the panel can run commands as `SSH_USER`; a red banner is shown on every page |

**The login credentials are the Pi's own account.** `LOGIN_USER` / `LOGIN_PASS`
default to `SSH_USER` / `SSH_PASS`, because GumCP needs the real system password
for SSH anyway — changing the Pi's password means updating `SSH_PASS` or every
command stops working, and the login follows automatically. Set `LOGIN_USER` /
`LOGIN_PASS` explicitly if you would rather the web login be a separate account
or password; Basic Auth always uses its own credentials.

```php
// Login page
define('LOGIN_REQUIRED', true);
define('LOGIN_USER', 'admin');
define('LOGIN_PASS', 'changeme');

// HTTP Basic Auth (separate credentials — useful for API/curl access)
define('BASIC_AUTH', true);
define('BASIC_AUTH_USER', 'api');
define('BASIC_AUTH_PASS', 'secret');
```

---

## Command Buttons

Create one-click buttons for any shell command from the **Buttons** page.

### Execution modes

| Mode | Behaviour |
|---|---|
| Modal (default) | Click opens a dialog showing the command; press Execute to run; output shown in the dialog |
| Direct | Click runs immediately; output appears inline below the button |

Toggle between modes with the **Direct execution** checkbox when creating or editing a button.

### Button API

**Off by default** for new installs — it is the one endpoint that runs a command
without a login, so you opt in. Enable it in `config.php`:

```php
$gumcp_modules['button_api']['module_active'] = 1;
```

Every button then gets a unique secret hash. That hash **is** the credential, so
treat it like a password — no session or Basic Auth is required to use it:

```bash
curl -H 'X-GumCP-Key: <32-char-hash>' http://<your-pi-ip>/GumCP/api.php
```

Response:

```json
{"success": true, "button": "Restart Apache", "output": ""}
```

The API URL is shown in the button's **Edit** dialog. Use **Regenerate hash** to invalidate an old URL and get a new one instantly.

Every API call is logged to `command_logs/api_calls.log` (JSON lines) with timestamp, IP, user-agent, and command output — including rejected ones. Log files are not accessible via the browser.

**Keep the key out of logs.** A `?hash=` query string is recorded in web-server access logs, browser history and `Referer` headers. Send it as a header instead:

```bash
curl -H 'X-GumCP-Key: <32-char-hash>' http://<your-pi-ip>/GumCP/api.php
```

**Restrict who can call it.** Optionally limit the API to specific addresses in `config.php` — anything else gets a `403` before the hash is even examined:

```php
$gumcp_api_allow_ips = ['192.168.1.50', '192.168.1.0/24'];  // empty = no IP restriction
```

Matching uses the real peer address, so a spoofed `X-Forwarded-For` header cannot bypass it. If GumCP sits behind a reverse proxy, the allowed address is the proxy's.

**Example: trigger from Home Assistant**

```yaml
rest_command:
  restart_apache:
    url: "http://192.168.1.10/GumCP/api.php?hash=a3f8c2d1e4b79056..."
    method: GET
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

### Basic Auth not working (login page still shown)

Apache strips the `Authorization` header by default. The included `.htaccess` passes it through via `RewriteRule`. Make sure `mod_rewrite` is enabled:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Dashboard "Power & Throttling" shows "not available"

`vcgencmd` needs GPU access, which the `www-data` web user lacks by default. Add it to the `video` group:

```bash
sudo usermod -aG video www-data
sudo systemctl restart apache2
```

(The installer does this automatically on Raspberry Pi hardware.) On non-Pi hardware the panel is expected to stay unavailable.

### TeHyBug module

TeHyBug is a low-power temperature/humidity/pressure Wi-Fi tracker available at [Tindie](https://www.tindie.com/stores/gumslone/).

Enable it in `config.php` (`module_active => 1`). Requires SQLite:

```bash
sudo apt-get install -y php-sqlite3
```

---

## Security Notes

> ### ⚠️ GumCP requires authentication
> GumCP executes shell commands as the SSH user (which the install guide gives
> passwordless `sudo`). **Anyone who can reach an unauthenticated panel can take over
> the host.** Since 2.5.2 GumCP therefore **fails closed**: if neither
> `LOGIN_REQUIRED` nor `BASIC_AUTH` is enabled, it refuses to serve and shows setup
> instructions instead. Never expose GumCP directly to the internet.

- **Change default credentials** in `include/config.php` before putting GumCP on any network — the shipped defaults are public
- `LOGIN_REQUIRED` is **enabled by default**. Disabling it does not open the panel; GumCP refuses to serve until some authentication is configured
- Running an open panel requires deliberately setting `GUMCP_ALLOW_UNAUTHENTICATED` to `true`, which disables all authentication. Only consider this on a fully isolated network; a red warning banner is shown on every page while it is active
- The **System Check** page reports whether authentication is configured and whether default passwords are still in use
- Button API is enabled by default — set `$gumcp_modules['button_api']['module_active'] = 0` in `config.php` to disable it
- Button API hashes are secret URLs — treat them like passwords; use **Regenerate hash** if a hash is compromised
- `command_logs/` and `buttons/` are blocked from direct web access by the Apache config the installer adds (`deploy/gumcp-apache.conf`). This matters: `buttons/buttons.json` stores each button's API hash, which triggers a command with no login, and `command_logs/` holds whatever your commands printed. **`.htaccess` alone is not enough** — Debian and Raspberry Pi OS set `AllowOverride None` for `/var/www`, which silently ignores it. If you installed before this was added, or set GumCP up by hand:

```bash
sudo cp deploy/gumcp-apache.conf /etc/apache2/conf-available/gumcp.conf
sudo sed -i "s|@GUMCP_DIR@|/var/www/html/GumCP|g" /etc/apache2/conf-available/gumcp.conf
sudo a2enconf gumcp && sudo systemctl reload apache2
```

  **System Check verifies this by actually requesting the files over HTTP**, so it reports what your server really does rather than assuming.
- GumCP executes commands as the SSH user — use a dedicated user with only the permissions it needs
- The Packages, Logs, Cron and Raspberry Pi pages run privileged commands (`apt`, `journalctl`, `raspi-config`, writing boot files) via `sudo` over SSH, which requires the SSH user to have passwordless `sudo` — the same assumption as the Actions page. See [Limiting what GumCP can run](#limiting-what-gumcp-can-run) below.
- The **Button API** (`api.php`) executes a button's command with **no login** — the per-button hash is the only credential. It is **off by default** for new installs; enable it with `$gumcp_modules['button_api']['module_active'] = 1` only if you need it, and treat the URLs like passwords. Prefer sending the key as a header so it stays out of access logs and browser history:

```bash
curl -H 'X-GumCP-Key: <32-char-hash>' http://<your-pi-ip>/GumCP/api.php
```

### Optional third-party modules

Adminer (database manager) and TinyFileManager (web file manager) are **not
bundled**. A vendored copy ships whatever vulnerabilities it had on the day it was
copied in and then quietly goes stale — both projects have had security advisories.
Install the version you choose from upstream instead. The easiest way is the
**Optional modules** panel on the **Actions** page — it shows what's installed,
installs or updates a chosen version, and removes it again. Or from a shell:

```bash
cd /var/www/html/GumCP
./scripts/install-module.sh adminer                # pinned default version
./scripts/install-module.sh adminer 4.8.1          # or pick any released version
./scripts/install-module.sh tinyfilemanager
```

Installing from the Actions panel also enables the module. From the shell, enable it afterwards in `include/config.php`:

```php
$gumcp_modules['adminer']['module_active'] = 1;
```

Update later by re-running the script with a newer version. The upstream file is
stored in `modules/<name>/vendor/` and blocked from direct web access; requests go
through a generated entry file that **requires your GumCP login first**, so the
module is never reachable by an unauthenticated visitor. Only enable what you use —
these are powerful tools with their own security history.

### Limiting what GumCP can run

By default GumCP's SSH user needs blanket passwordless `sudo`, which means a
compromise of the panel is a compromise of the host. If you don't need the
free-text **Execute command** box or arbitrary command buttons, create a
dedicated user and grant only the commands the built-in pages actually call:

```sh
# /etc/sudoers.d/gumcp   (edit with: sudo visudo -f /etc/sudoers.d/gumcp)
Cmnd_Alias GUMCP_PKG  = /usr/bin/apt-get update, /usr/bin/apt-get -y upgrade
Cmnd_Alias GUMCP_LOG  = /bin/journalctl *, /bin/dmesg, /usr/bin/tail -n * /var/log/*
Cmnd_Alias GUMCP_SVC  = /usr/sbin/service * start, /usr/sbin/service * stop, \
                        /bin/systemctl start *, /bin/systemctl restart *, \
                        /bin/systemctl enable *
Cmnd_Alias GUMCP_SYS  = /sbin/reboot, /usr/bin/raspi-config nonint *
Cmnd_Alias GUMCP_PROC = /bin/kill -9 *, /usr/bin/killall *

gumcp ALL=(root) NOPASSWD: GUMCP_PKG, GUMCP_LOG, GUMCP_SVC, GUMCP_SYS, GUMCP_PROC
```

Then point `SSH_USER` / `SSH_PASS` at that account. **Trade-off:** anything not
listed — the Actions command box, arbitrary buttons, Docker control, the boot-file
editor, and the in-app updater — will fail with a sudo error. Add the specific
commands you need (paths vary by OS; check with `command -v`), and prefer widening
the list over falling back to `NOPASSWD: ALL`.
- `robots.txt` is included and blocks all search crawlers from indexing GumCP

---

## FAQ

**Is GumCP a Webmin or Cockpit alternative for Raspberry Pi?**
Yes — it's a lightweight, single-purpose web control panel focused on Raspberry Pi: system monitoring, GPIO, services, processes and one-click command buttons. It installs in minutes on Raspberry Pi OS with no database required.

**Which Raspberry Pi models are supported?**
All of them — Pi 1, 2, 3, 4 and Pi 5. GPIO uses WiringPi on Pi 1–4 and `raspi-gpio` on Pi 5 automatically.

**Can I monitor my Raspberry Pi remotely from a browser?**
Yes. The dashboard shows live CPU, memory, swap, disk, temperature, throttling and per-interface network stats, auto-refreshing without a page reload. Protect remote access with the built-in login page or HTTP Basic Auth.

**Can I trigger commands from Home Assistant or scripts?**
Yes — every command button has a secret HTTP API URL you can call from Home Assistant, curl, or any automation tool.

---

## Keywords

Raspberry Pi web control panel · Raspberry Pi dashboard · Raspberry Pi system monitor · Raspberry Pi GPIO web interface · Webmin alternative · Cockpit alternative · self-hosted Pi monitoring · homelab control panel · PHP Raspberry Pi admin panel · remote Raspberry Pi management.

---

## Disclaimer

GumCP is provided **"as is", without warranty of any kind**, express or implied. It
executes shell commands, edits system and boot configuration files, manages packages
and services, and controls GPIO pins — all of which can, if misused or misconfigured,
**render your system unbootable, cause data loss, or damage your Raspberry Pi and any
connected hardware**.

You use GumCP entirely at your own risk. The authors and contributors accept **no
liability** for any damage, data loss, downtime, or other harm arising from its use.
Always keep backups, change the default credentials, restrict network access, and only
run commands you understand. See the [LICENSE](LICENSE) for the full terms.

---

## License

Released under the [MIT License](LICENSE).

---

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/donate/?hosted_button_id=VCWHQPACTXV5N)
