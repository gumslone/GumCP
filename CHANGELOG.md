# Changelog

## Unreleased

### Hardening — the login password no longer has to sit in cleartext
`include/config.php` is readable on the SD card next to the code, so anyone who
pulls the card (or finds any file-disclosure bug) got the web password itself.

- `LOGIN_PASS` and `BASIC_AUTH_PASS` may now hold a `password_hash()` value;
  cleartext keeps working unchanged, so no existing config breaks. Generate one
  with `php -r "echo password_hash('your-password', PASSWORD_DEFAULT), PHP_EOL;"`.
- **setup.php now writes a hash automatically** — fresh installs configured
  through the browser never store the password in cleartext at all.
- The integration suite's test install now uses a hashed password, so the full
  login flow is exercised through `password_verify()` on every CI run.

Note the boundary honestly: `SSH_PASS` must remain recoverable (GumCP has to
present it to SSH), so this protects the *web* credential — most valuable when
the two are different, e.g. with `LOGIN_CHECK_SYSTEM_USER` or a dedicated
login user.

### Hardening — the recovery updater now follows the same rules as everything else
`update.php` can run `git reset --hard` yet sat outside every protection added
recently: the emergency `?key=` could be guessed with no rate limit, a session
accepted there never expired (it compared the session stamps by hand instead of
using the shared check), Basic Auth attempts against it were unthrottled, and
none of it reached the auth log.

- Key and Basic Auth guessing are throttled under their own counter — hammering
  the updater cannot lock you out of the normal login, and vice versa. Once
  locked, even the correct key is refused until the lockout passes.
- Sessions used on the updater honour the idle/absolute timeouts, and a
  system-account session (`LOGIN_CHECK_SYSTEM_USER`) can now use the updater at
  all — the hand-rolled check silently didn't accept those.
- Key successes and failures are recorded in `command_logs/auth.log`.
- Five new integration checks cover the anonymous refusal, session access, the
  emergency key, the throttle, and that lockout applies to the correct key too.

### Fixed — background command output was invisible
`execute_command.php` wrote each background command's output to
`command_logs/*.txt`, but the Actions page lists only `*.log` and the Delete
button accepts only `*.log`. So every background command's log was unreachable
from the panel and could never be cleaned up — it just accumulated on the SD
card. Output is now written as `.log`, and the Actions page also lists existing
`.txt` files so nothing already on disk is orphaned.

`command_logs/auth.log` and `api_calls.log` are excluded from that list and
refused by `delete_log`: they are the audit trail, not command output, and a
Delete button next to them would quietly discard the record of who signed in.

### Button API exposure is now visible, and documented accurately
A `config.php` with no `button_api` entry is backfilled as **enabled** — a
deliberate choice so upgrades do not break existing automations, since the API
predates the module flag. The consequence was invisible: a hand-written or
trimmed config quietly gained an endpoint that runs a command with no login.

- **System Check** now reports the Button API as a problem when it is enabled
  without `$gumcp_api_allow_ips`, and shows the allow-list when there is one.
- `SECURITY.md` said only that the API is "disabled by default for new
  installs". True of `config.example.php`, but it omitted the backfill — the
  case where a user is exposed without having chosen anything. Now stated.
- `SECURITY.md` also documents the session timeouts and `command_logs/auth.log`.

### Integration tests
`scripts/selftest.sh` calls functions directly; the new `scripts/inttest.sh`
drives a real HTTP server with real cookies. That distinction matters, because
every vulnerability that reached users was a **wiring** bug rather than a logic
bug — an access gate that was never invoked, session hardening placed after
something had already started the session, a CSRF check that a GET walked
around. None of those are visible from a unit test.

21 checks against a throwaway install: the gate on every page, the full login
flow (wrong password, missing CSRF token, session-ID regeneration), the AJAX
method and token guards, security headers, the Button API staying off until
enabled, a real 2-second session timeout, and the auth log recording events
without recording the password. Runs in CI on PHP 7.0 alongside the self-tests.

### Button API — the log was a working credential
`api.php` runs a shell command with no login: the button hash *is* the
credential. Every call wrote that hash in full to
`command_logs/api_calls.log`, so anyone who could read the log — a backup, a
copied SD card, another local account — could execute buttons. The log now
stores only an 8-character prefix, enough to tell calls apart.

- Unknown keys are now **rate limited** per client address. The hash is 128 bits
  of `random_bytes`, so guessing was never realistic, but an unauthenticated
  endpoint that runs commands should not be an unbounded oracle. Counted under a
  separate key, so hammering the API can never lock that address out of the web
  login.
- `api_calls.log` is capped at 1000 lines instead of growing until the SD card
  fills.

### Authentication log
GumCP runs every command as a single system user, so the web server's own logs
cannot tell an intruder's session apart from the owner's — a compromise left no
trace. Sign-ins, failed attempts, lockouts, timeouts and sign-outs are now
written to `command_logs/auth.log` (denied to the web server, capped at 500
lines). Passwords are never recorded, and tabs/newlines in a username or
user-agent are flattened so a crafted login cannot forge log rows.

**System Check** gained a *Recent sign-in activity* panel showing the last ten
events with time, address and outcome.

### Hardening — sessions now expire
A signed-in session is shell access, but the cookie lasted until the browser was
closed — on a desktop that can be weeks. A tab left open on a shared or stolen
machine kept full control of the Pi.

- Sessions end after `SESSION_IDLE_TIMEOUT` seconds of inactivity (default 1
  hour) and after `SESSION_ABSOLUTE_TIMEOUT` seconds regardless (default 12
  hours). Set either to `0` in `include/config.php` to switch it off.
- The dashboard's auto-refresh does **not** count as activity — otherwise an
  unattended browser on the dashboard would poll its own session alive forever,
  which is precisely the case this protects against.
- Expiry sends you to the login page with "Your session has expired", rather
  than a bare form.
- Sessions that predate the upgrade are not signed out on deploy; their clock
  starts on the first request after it.

### Hardening — security response headers, and SameSite on PHP 7.0
A GumCP session can run shell commands, so framing matters as much as data
theft: an attacker who frames the panel can trick a signed-in admin into
clicking a button that executes something.

- Every page now sends `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options:
  nosniff`, `Referrer-Policy: same-origin`, and a `Content-Security-Policy`
  limiting resources to this origin (`frame-ancestors 'self'`, `object-src
  'none'`, `form-action 'self'`). Everything GumCP loads is bundled, so nothing
  external is needed. Third-party modules get only the framing rule, since some
  builds legitimately load assets from a CDN.
- The session cookie now carries `SameSite=Lax` on **PHP 7.0–7.2** too. The
  attribute was previously set only on 7.3+, where `session_set_cookie_params()`
  accepts it as an option — but Raspberry Pi OS ships PHP 7.0, so the installs
  most likely to be exposed were the ones missing it.
- `scripts/selftest.sh` asserts all of this against a real HTTP response rather
  than by reading the source.

### Security — AJAX actions were reachable by GET without a CSRF token
`ajax.php` verified the CSRF token only on `POST`, but read its action from
`$_REQUEST` — so any action that needed no `$_POST` parameter could be triggered
by a plain `GET` from a malicious page while an administrator was logged in.
Fifteen actions qualified, including `pkg_upgrade` (`sudo apt-get -y upgrade`),
`pkg_check`, `git_tags`, and `edit_button`, which returns a button's API hash.

- `ajax.php` now rejects any non-`POST` request with `405` and reads the action
  and its parameters from `$_POST` only, so the token check covers every action.
- The dashboard poller (`static/js/gumcp.js`) posts instead of getting.
- `scripts/selftest.sh` pins the invariant: no `$_REQUEST` in `ajax.php`, the
  POST guard is present, and no frontend `GET` call remains.

### Security — runtime data could be served over HTTP
`buttons/` and `command_logs/` were protected only by `.htaccess`, but Debian and
Raspberry Pi OS configure Apache with `AllowOverride None` for `/var/www`, which
makes those files inert. On a default install the directories were therefore
web-readable — `buttons/buttons.json` stores each button's **API hash**, a
credential that triggers a command with no login, and `command_logs/` holds
whatever executed commands printed.

- New `deploy/gumcp-apache.conf` denies `buttons/`, `command_logs/`,
  `include/` and `modules/*/vendor/` in the **server** configuration, so the rules
  apply regardless of `AllowOverride`. `installer.sh` installs and enables it.
- The shipped `.htaccess` files now work on **Apache 2.2 as well as 2.4**. They contained only `Require all denied`, which 2.2 does not understand — it returns a 500 rather than denying. Both syntaxes are now emitted behind `<IfModule mod_authz_core.c>`, in `buttons/`, `command_logs/` and the files the module installer writes.
- **System Check now proves it** — it requests the paths over HTTP and reports
  what the server actually does, instead of assuming an `.htaccess` file works.
- Existing installs: `sudo cp deploy/gumcp-apache.conf /etc/apache2/conf-available/gumcp.conf`
  (substituting `@GUMCP_DIR@`), then `sudo a2enconf gumcp && sudo systemctl reload apache2`.

### Added
- **`LOGIN_CHECK_SYSTEM_USER`** (default `false`) — when enabled, the login form is verified against the Pi's real system account over SSH rather than against `LOGIN_PASS`, so the password is checked by the OS and cannot drift out of sync with the system one. `LOGIN_USER` still decides who may sign in (the username must match it); only the password is delegated, so `LOGIN_PASS` becomes unused, may be left empty, still counts as configured, and the default-password warning is suppressed. `LOGIN_USER` defaults to `SSH_USER`, so by default this is the account GumCP runs commands as. Left off by default, so the login stays an ordinary config credential unless you opt in.
- **`uninstall.sh` removes the Apache hardening config** it installed (`a2disconf gumcp` and deleting `/etc/apache2/conf-available/gumcp.conf`), instead of leaving an enabled config pointing at a deleted directory. It deliberately leaves `www-data`'s `video` group membership and the Apache modules alone, since other software may depend on them.
- **Upgrade-safety checks in `scripts/selftest.sh`** — `include/config.php` is user-owned and never overwritten, so a setting added to `config.example.php` without a matching fallback in `config.defaults.php` would leave every existing install hitting an undefined constant on upgrade. CI now fails if that happens, and also if `config.defaults.php` ever gains an unguarded `define()` that would clobber a value the user set.
- **`scripts/selftest.sh`** — runs without a web server or a Pi, and covers the logic that breaks silently: the access gate (fail-closed, open mode, session validity, the `api.php` bypass), `LOGIN_*` inheriting from `SSH_*`, the API IP allow-list, cron validation, and PHP 7.0/shell syntax. Wired into CI, and verified to fail when fail-closed behaviour is deliberately broken.

### Security — login throttling
There was no rate limiting on the login form, so anyone who could reach the panel
could guess passwords indefinitely — and a correct guess is shell access as a
sudo-capable user. That matters more given GumCP ships with a published default
password.

- After `LOGIN_MAX_FAILURES` (5) failures within `LOGIN_FAILURE_WINDOW` (15 min),
  that client address is refused for `LOGIN_LOCKOUT_TIME` (15 min). All three are
  configurable in `config.php`.
- Counting is **per client address**, so someone hammering the login cannot lock
  the administrator out from a different address, and the check runs before any
  credential comparison. A successful login clears the counter.
- State lives in `command_logs/.login_attempts.json` (denied to the web server),
  and stale entries are pruned so it cannot grow without bound.
- **HTTP Basic Auth shares the same throttle**, since it was otherwise an
  unlimited guessing channel to the same privileges. A request carrying no
  credentials — the normal first request from a browser — is not counted as a
  failure, so ordinary visits never trigger a lockout. While locked, GumCP
  answers `429` with `Retry-After` instead of re-issuing the Basic Auth
  challenge, which would loop the browser's password prompt with no explanation.

### Security — session cookie hardening
A GumCP session grants shell access as a sudo-capable user, but the session
cookie used PHP's defaults: readable by JavaScript, sent on cross-site requests,
and with client-supplied session IDs accepted.

- New `include/session.php` sets `HttpOnly`, `SameSite=Lax`, `Secure` (when the
  request is over HTTPS), `session.use_strict_mode` (rejects session IDs the
  client invented, closing session fixation) and `session.use_only_cookies`
  (keeps the ID out of URLs, where it would leak via `Referer` and logs).
- Loaded before `config.php` in every entry point, since cookie parameters have
  no effect once a session has started. `login.php`, `setup.php` and `update.php`
  use it too. `SameSite` needs PHP 7.3+; the other flags apply from 7.0.
- Covered by `selftest.sh`, including a check that the hardening still runs
  *before* `config.php` — get that ordering wrong and the flags silently do nothing.

### Fixed
- **`iframe.php` honours `module_active`** — a module switched off in `config.php` was hidden from the navbar but still rendered if its `iframe.php?module=…` URL was requested directly. Disabling a module now actually makes it unreachable. (The `module` parameter was never a traversal risk: it is only ever used as a key into `$gumcp_modules`, so the config is the whitelist.)

### Changed
- **The login credentials are the Pi's system account.** `LOGIN_USER` / `LOGIN_PASS` now fall back to `SSH_USER` / `SSH_PASS` when a `config.php` doesn't set them, so there is one password to keep current rather than two that can drift apart — changing the Pi's password already requires updating `SSH_PASS` or commands stop working. Setting them explicitly still overrides, for anyone who wants a separate web password.
- **Login processing moved into `include/auth.php`** (from the user-owned `config.php`, so it can be fixed by an upgrade) and now regenerates the session ID on success, preventing session fixation. The form posts `gumcp_login_*` field names so the legacy login block in older `config.php` files stays dormant instead of conflicting.
- **A fresh install signs in with `pi` / `raspberry` again.** 2.6.0 shipped an empty `LOGIN_PASS` so new installs had to complete a first-run setup form; the defaults are back so the panel is usable immediately with no extra step. The warning banner and the System Check *"Credentials changed from defaults"* item still flag it until the password is changed. `setup.php` remains for installs that have no login configured (e.g. upgrades from before 2.5.2 that had `LOGIN_REQUIRED = false`).

### Added
- **Install optional modules from the Actions page** — a new *Optional modules* panel shows whether Adminer / TinyFileManager are installed, which version, and whether they're enabled in `config.php`, with buttons to install, update or remove them. **Versions are listed in a dropdown**, read from the upstream repository with `git ls-remote --tags` — the same mechanism the GumCP update dropdown uses, so there is no API rate limit; the list is cached for an hour and falls back to a free-text box when offline. The module name is whitelisted and the version pattern-checked before reaching the shell.
- **Installing a module now enables it.** Previously the panel downloaded the files and left you to edit `config.php` by hand, so the module still didn't appear. Install/Enable/Disable now write a marked block at the end of `config.php` (`// BEGIN GumCP managed module state`), which is rewritten in place each time and is safe to edit or delete yourself. Removing a module disables it too, so the navbar never links to a missing file. If `config.php` isn't writable the install still succeeds and the exact line to add is shown.
- Pinned default for Adminer moved from 4.8.1 (2021) to **5.5.1**; both download URLs verified against upstream.

---

## [2.6.0] — 2026-07-30

### Security — unauthenticated access to bundled modules (high)
`modules/adminer/adminer.php` contained no authentication code at all, so the
bundled **Adminer database manager was reachable directly at
`/GumCP/modules/adminer/adminer.php` even with `LOGIN_REQUIRED = true`**. Modules
are shown in an iframe, so the browser fetches their URL directly and the parent
page's login protects nothing. TinyFileManager checked only its `module_active`
flag.

- New `include/module_guard.php` — module entry points now enforce the full GumCP
  access gate server-side before any third-party code runs.
- **Adminer and TinyFileManager are no longer bundled.** The vendored copies were
  old (Adminer 4.6.1, from 2018) and carried known advisories. Install the version
  you want with `./scripts/install-module.sh <module> [version]`, then enable it in
  `config.php`; re-run with a newer version to update.
- Upstream files live in `modules/<name>/vendor/`, blocked from direct web access
  by `.htaccess`, and are reached only through the generated guarded entry file.

### Added
- **First-run setup (`setup.php`)** — configure the login from the browser instead
  of hand-editing `config.php`, then the page deletes itself. It runs only while no
  usable credential exists (so it can never reset an existing password), and only
  answers requests from loopback/private addresses.
- GumCP now ships with **no usable default password**: `config.example.php` sets an
  empty `LOGIN_PASS`, so a fresh install goes to first-run setup rather than being
  reachable with credentials that are public knowledge.

### Changed
- The legacy inline auth gate was removed from `config.example.php` — access
  control lives in `include/auth.php` for new installs. Existing `config.php`
  files keep their copy harmlessly.

---

## [2.5.3] — 2026-07-30

### Security hardening (follow-up to 2.5.2)
- **Button API off by default for new installs** — `api.php` is the one endpoint that executes commands without a login, so `config.example.php` now ships it disabled. Existing installs are deliberately left untouched (`config.defaults.php` still backfills it enabled) so upgrades don't silently break live automations; pin `button_api` in your `config.php` to choose explicitly.
- **Button API accepts an `X-GumCP-Key` header** as well as `?hash=`. Query strings are written to web-server access logs, browser history and `Referer` headers, so the header keeps the key off disk. The query parameter still works.
- **Button API IP allow-list** — new `$gumcp_api_allow_ips` in `config.php` limits which addresses may call `api.php` (plain IPs and IPv4 CIDR ranges). Non-matching callers get a `403` before the hash is examined, and the attempt is logged. Empty by default, so existing setups are unaffected. Matching uses `REMOTE_ADDR`, never the caller-supplied `X-Forwarded-For`.
- **README: "Limiting what GumCP can run"** — a worked `sudoers.d` allow-list for deployments that don't need the free-text Actions box or arbitrary buttons, so the SSH user no longer needs blanket `NOPASSWD: ALL`, plus an explicit note on what stops working.

---

## [2.5.2] — 2026-07-30

### Security — unauthenticated remote command execution (critical)

GumCP shipped with authentication **disabled by default** (`LOGIN_REQUIRED` and
`BASIC_AUTH` both `false`), so a default install exposed the whole panel —
including `execute_command.php` and the button execute action — to anyone who
could reach it. Those endpoints were guarded only by a CSRF token, which is not
an access control: `init.php` mints a token for every session, authenticated or
not, and it is embedded in the page HTML. Commands run over SSH as `SSH_USER`,
which the install guide gives passwordless `sudo` — so this was unauthenticated
root command execution. (CWE-306 / CWE-1188, CVSS 3.1 9.8.)

Reported by **Dhaiwat Mehta**.

- **Fail closed** — new `include/auth.php` holds the access gate and is consulted
  by `include/init.php` on every page and endpoint. When no authentication is
  configured, GumCP now refuses to serve and shows setup instructions instead of
  serving the panel.
- **Gate moved into shipped code** — it previously lived in the user-owned
  `include/config.php`, which is git-ignored and never updated on upgrade, so no
  fix shipped there could reach existing installs. It is now in `include/auth.php`.
- `LOGIN_REQUIRED` **defaults to `true`** (`config.defaults.php` and
  `config.example.php`).
- Running an open panel now requires explicitly setting the new
  `GUMCP_ALLOW_UNAUTHENTICATED` to `true`; a red banner is then shown on every page.
- A warning banner also appears while a shipped default password is still in use.
- **System Check** gained a Security section: authentication configured,
  open-access disabled, credentials changed from defaults.

**Action required after upgrading:** installs that had `LOGIN_REQUIRED = false`
will show a setup page until a login is configured in `include/config.php`.

### Changed
- **Refactor: shared page chrome** — the duplicated `<head>`/navbar and footer boilerplate (~45 lines × 14 pages) now lives in `include/header.php` and `include/footer.php`. Pages set `$page_title` and include the partials; per-page styles/scripts are unchanged. `update.php` and `login.php` deliberately stay standalone for recovery isolation.
- **Refactor: shared system readers** — `read_cpu_usage()`, `read_uptime()`, `read_meminfo()`, `read_cpu_temp()` and `gumcp_fmt_bytes()` moved to `include/dashboard.php` and are used by both `index.php` and `ajax.php` (previously two diverging copies). The dashboard's initial render now uses the same snapshot-based CPU reader as the 30 s refresh, so the first paint shows a real value instead of a 100 ms sample.
- Net −689 lines with no functional change.
- **Refactor: centralised CSRF-token bootstrap** — the per-page `$_SESSION['csrf_token']` generation (13 pages) moved into `include/init.php`. `login.php` and `update.php` keep their own copies (they don't load the bootstrap, by design).

---

## [2.5.1] — 2026-07-02

### Fixed
- **PHP 7.0 compatibility** — removed `: void` return type from `gumcp_init_lang()` (i18n) and replaced `[]` array destructuring with `list()` in the Basic Auth block of `config.example.php`. Both are PHP 7.1+ syntax and caused HTTP 500s on PHP 7.0.
- **Language persistence** — the navbar language choice now persists across pages. It's processed early in `include/init.php` (before output) and stored in a 1-year cookie plus the session, instead of being set mid-page.

### Added
- **`update.php`** — a standalone recovery updater that depends only on `config.php` (never the full bootstrap) and runs `git` locally without SSH, so GumCP can be updated/recovered from the browser even when a bad deploy breaks every other page.
- **PHP 7.0 CI** — `.github/workflows/php-compat.yml` lints all first-party PHP against a real PHP 7.0 runtime and rejects 7.1+ syntax; `scripts/check-php70.sh` runs the same check locally.

---

## [2.5.0] — 2026-06-28

### Added
- **Multilanguage (i18n)** — English (base), German, Ukrainian, Spanish and French. Default set via `GUMCP_LANG` in `config.php`; a navbar language switcher persists the choice in the session. New `include/i18n.php` engine with `t()` and per-language files in `include/lang/`; missing keys fall back to English. Translated: navbar, Dashboard, Services, Processes, Packages, Logs, Cron, Users, Actions, GPIO, Buttons, Docker and Raspberry Pi (titles, panel headings and primary controls). Deep modal/help text and the cron schedule descriptions remain English and fall back gracefully.
- **Docker** (`docker.php`): list containers and start/stop/restart/pause/remove them, view container logs in a modal, and browse images. Disabled by default — enable `$gumcp_modules['docker']['module_active'] = 1`. Commands run via `sudo docker` over SSH; the page reports clearly when Docker is not installed or the daemon is down.

---

## [2.4.0] — 2026-06-28

### Added — Webmin-style modules
- **Package Updates** (`packages.php`): lists upgradable apt packages with a count, refreshes the index (`apt-get update`) and upgrades all (`apt-get upgrade`) over SSH.
- **System Logs** (`logs.php`): views the systemd journal, `dmesg` and `/var/log` files over SSH with adjustable line count and text filter (path-validated).
- **Cron Jobs** (`cron.php`): view, add and remove user crontab entries over SSH; read-only `/etc/crontab`.
- **Users & Groups** (`users.php`): read-only listing of `/etc/passwd` and `/etc/group` (pure PHP, no SSH).

### Added — Raspberry Pi tools (`rpi.php`)
- `vcgencmd` metrics: firmware, ARM/core/V3D clocks, core/SDRAM voltages, memory split, codec licences.
- Interface toggles for I2C, SPI, 1-Wire, SSH, VNC and camera via `raspi-config nonint`, with current state.
- `config.txt` / `cmdline.txt` editor with an automatic `.gumcp.bak` backup before each save (Bookworm `/boot/firmware` path aware).
- Live temperature & CPU-frequency history chart sampled into a local ring buffer.

### Changed
- New modules are backfilled in `include/config.defaults.php`, so they appear in the navbar after upgrading without editing `config.php`.
- `gumcp_vcgencmd_path()` helper added to `include/dashboard.php` and reused by the throttling and Raspberry Pi features.
- **Navbar grouping**: modules with a `module_group` render under a single dropdown. Packages, Logs, Cron and Users now live under a **System** dropdown to keep the navbar tidy.
- **Cron page**: friendlier scheduling — a "When" preset dropdown (every minute/5 min/hour/day/week/month, at boot) fills the expression, plus a live plain-English description of the chosen schedule. Cron schedule expressions are now validated per-field (ranges, lists, steps, names) on both client and server.
- **Packages page**: shows when the apt index was last refreshed and flags a stale cache, and surfaces apt repository errors (EOL/unreachable repos) instead of falsely reporting success.
- **Actions — Update GumCP**: a refresh button fetches all release tags from GitHub so the version dropdown isn't limited to tags the Pi already had.
- **Boot config editor**: prominent warning, a detailed save-confirm dialog naming the file, and an inline success/error notice.

### Fixed
- **GPIO**: power (3.3V/5V) and ground (0V) pins no longer show non-functional toggles; a pin is controllable only when its BCM number is numeric. `0v` is labelled **GND**; power/ground pins render as enlarged badges; table cells are vertically centered.

---

## [2.3.2] — 2026-06-27

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
