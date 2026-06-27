# Changelog

## Unreleased

### Changed
- **Dashboard — Power & Throttling**: `gumcp_throttled_info()` now locates `vcgencmd` across common paths and captures stderr, so it can report *why* throttling data is unavailable (e.g. the web user not being in the `video` group) instead of always blaming non-Pi hardware. Fix for missing GPU access: `sudo usermod -aG video www-data && sudo systemctl restart apache2`.
- **installer.sh**: adds `www-data` to the `video` group so the Power & Throttling panel works out of the box on Raspberry Pi.
- **README**: documents the `video` group requirement in manual install and troubleshooting.

---

## [2.3.1] — 2026-06-27

### Fixed
- `index.php`: removed `?int` nullable type hint from `signal_quality()` — it requires PHP 7.1 and caused a 500 error on PHP 7.0. The project targets PHP 7.0.

---

## [2.3.0] — 2026-06-27

### Added
- **Dashboard — Network panel**: per-interface IPv4 address, link state, RX/TX byte counters and Wi-Fi signal strength (dBm + quality), read from `/sys/class/net` and `/proc/net/wireless`.
- **Dashboard — Power & Throttling**: Raspberry Pi under-voltage / throttling status via `vcgencmd get_throttled`, showing current and past warning flags.
- **Dashboard — Swap usage**: swap bar in the Resource Usage panel.
- **Dashboard — Service badges**: green/red status badges for a configurable list of services (`$gumcp_dashboard_services` in `config.php`), checked with `systemctl is-active`.
- **Dashboard — Connected USB Devices**: `lsusb` output panel.
- **Dashboard — Block Devices**: `lsblk` output panel.
- `include/dashboard.php` — shared collectors used by both `index.php` (initial render) and `ajax.php` (30 s refresh).

---

## [2.2.0] — 2026-06-07

### Added
- **Update from GitHub** — new button on the Actions page pulls the latest version without needing a terminal. A dropdown lets you choose between the master branch or any specific release tag; the correct `git` command is shown in the confirmation dialog before anything runs.
- **uninstall.sh** — interactive uninstall script; offers to back up `config.php`, buttons and logs to `~/gumcp_backup_<timestamp>/` before removing `/var/www/html/GumCP/`. Leaves Apache, PHP and WiringPi untouched.

### Changed
- Reboot and Update GumCP moved into a dedicated **System** panel on the Actions page, separate from the process/service actions.

---

## [2.1.1] — 2026-06-07

### Fixed
- `api.php`: removed `?array` nullable type hint and `void` return type from `api_log()` — both require PHP 7.1; the project targets PHP 7.0.
- Actions page: `.htaccess` no longer appears in the background command log list (`scandir()` now skips dot-files and non-`.log` files).
- `ajax.php` `delete_log` action: filename validation now rejects dot-files and filenames not ending in `.log`, preventing accidental deletion of `.htaccess`.

### Changed
- `static/css.php` and `static/js.php` refactored: `declare(strict_types=1)`, dead code removed, `strstr()` → `strpos()`, `ob_get_clean()`, `__DIR__`-relative includes, `ob_end_flush()` for gzip path.
- All shared JavaScript extracted from inline `<script>` blocks in `buttons.php` and `index.php` into `static/js/gumcp.js`. Each page now only sets data globals (`CSRF_TOKEN`, `BUTTON_API_ENABLED`).
- Drag-and-drop, direct-execute output, menu reorder list, and footer styles moved from inline `style=` attributes into `static/css/style.css`.

---

## [2.1.0] — 2026-05-31

### Added
- **Button API** — every button gets a unique 32-char secret hash; call `api.php?hash=<hash>` from curl, Home Assistant, or any automation tool to execute it without logging in. Controlled via `$gumcp_modules['button_api']['module_active']`. Every call logged to `command_logs/api_calls.log`.
- **Direct execution mode for buttons** — optional checkbox per button; fires immediately on click and shows output inline below the button instead of opening a confirmation modal.
- **Drag-and-drop button reorder** — drag buttons into any order on the Buttons page; order saved automatically to `buttons.json`.
- **Menu reorder** — drag navbar items into any order from any page; preference saved to `include/menu_order.json` (git-ignored).
- **HTTP Basic Auth** — `BASIC_AUTH`, `BASIC_AUTH_USER`, `BASIC_AUTH_PASS` in `config.php`; independent credentials from the login page; both methods can be active simultaneously.
- **Config forward-compatibility** — `include/config.defaults.php` provides safe defaults for any setting not present in an older `config.php`; old configs work after upgrade without modification.
- `include/init.php` — central bootstrap loaded by all pages (`config.php` + defaults).
- `include/ssh.php` — `ssh_run()` extracted to a shared include used by both `ajax.php` and `api.php`.
- `robots.txt` — blocks all search crawlers.
- `.htaccess` — passes `Authorization` header through Apache for Basic Auth; `buttons/.htaccess` and `command_logs/.htaccess` block direct web access to those directories.
- **System Check** — `check.php` web diagnostic page and `check.sh` CLI script; each failing check has a Fix button that repairs it over SSH. Accessible from the Actions page.
- **Services page async loading** — `service --status-all` moved to AJAX so the page renders instantly with a spinner.
- **CPU usage fix** — `/proc/stat` cached between 30 s polls so the dashboard never shows 0 %.

### Changed
- GPIO V column now shows HIGH/LOW instead of 1/0.
- GPIO Physical column rendered bold with spaces around the pipe (`3 | 4`); BCM column also bold.
- GPIO Physical column header no longer spans two columns (layout misalignment fixed).
- Buttons page: execute button opens a confirmation modal showing the command before running; output shown in the modal.
- TeHyBug module (`index.php`, `track.php`, `chart_data.php`) fully refactored: `strict_types`, CSRF on all POST actions, prepared statements, Bootstrap modals replacing jQuery UI dialogs, dead code removed.
- All pages use `require_once('./include/init.php')` instead of `config.php` directly.
- `installer.sh` and `check.sh` now self-re-exec with bash if invoked via `sh`, fixing `Illegal option -o pipefail` and `Illegal number` errors on some systems.
- `installer.sh` root check uses `$(id -u)` instead of `$EUID` (POSIX-compatible).

### Security
- CSRF protection on all AJAX POST actions.
- `buttons/` and `command_logs/` blocked from web access via `.htaccess`.
- `include/config.php` git-ignored; `config.example.php` is the tracked template.
- `system_fix` action in `ajax.php` uses a whitelist of pre-defined commands; no user-supplied strings reach SSH.
- Button API hashes use `hash_equals()` for timing-safe comparison.

---

## Previous releases

See [commit history](https://github.com/gumslone/GumCP/commits/master) for changes before the changelog was introduced.
