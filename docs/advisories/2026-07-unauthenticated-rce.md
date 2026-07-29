<!--
Draft text for the GitHub Security Advisory covering the 2.5.2 fix.
Paste the sections below into Security → Advisories → New draft advisory,
then "Request CVE" from the draft. Kept in the repo as a public record.

Form fields
-----------
Title            : Unauthenticated remote command execution in GumCP (authentication disabled by default)
Ecosystem        : Other  (GumCP is installed via git clone, not a package registry)
Package name     : gumslone/GumCP
Affected versions: < 2.5.2
Patched versions : 2.5.2
Severity         : Critical — CVSS 3.1 9.8
CVSS vector      : CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:H/I:H/A:H
CWEs             : CWE-306 (Missing Authentication for Critical Function)
                   CWE-1188 (Insecure Default Initialization of Resource)
                   CWE-77 (Command Injection) — impact
Credit           : Dhaiwat Mehta (Reporter)
-->

## Summary

GumCP shipped with authentication **disabled by default**, leaving every page and
endpoint — including arbitrary command execution — reachable without credentials.
An attacker who could reach the panel over the network could execute commands as
the SSH user, which the installation guide gives passwordless `sudo`, resulting in
**full compromise of the host**.

## Severity

**Critical — CVSS 3.1 9.8**
`CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:H/I:H/A:H`

## Affected versions

All releases before **2.5.2** (2.0.0 – 2.5.1), and any earlier commit whose
`include/config.php` was created from the shipped template.

An installation is affected if `include/config.php` has **both**:

```php
define('LOGIN_REQUIRED', false);
define('BASIC_AUTH', false);   // or the constant is absent entirely
```

Those were the shipped defaults, so a default installation was affected.

## Details

Three factors combined:

1. **Authentication was opt-in.** `LOGIN_REQUIRED` and `BASIC_AUTH` both defaulted
   to `false` in `include/config.defaults.php` and `include/config.example.php`.
   The gate was conditional on them:

   ```php
   $_gumcp_need_auth = !defined('GUMCP_API_REQUEST')
                    && ((LOGIN_REQUIRED === true) || (defined('BASIC_AUTH') && BASIC_AUTH === true));
   if ($_gumcp_need_auth) { /* redirect to login / 401 */ }
   ```

   With the defaults, the condition was false and the gate never ran.

2. **A CSRF token was mistaken for an access control.** The command endpoints were
   guarded only by a CSRF token check. CSRF tokens defend against *cross-site*
   requests; they are not authentication. `include/init.php` issues a token to
   every session, authenticated or not, and it is rendered into the page HTML, so a
   direct (non-cross-site) attacker just reads it from a normal page request.

3. **Command execution ran as a privileged user.** With the token in hand,
   `execute_command.php` passed a caller-supplied string to `ssh2_exec()`
   unmodified (by design — it is a command runner), authenticating to SSH as
   `SSH_USER`. The README instructs giving that user passwordless `sudo`, so
   commands effectively ran as root. The Buttons feature offered an equivalent path
   via `ajax.php` (`submit_button` stored an arbitrary command, `execute_button` ran it).

No exploit code is published here; the mechanism above is sufficient for
administrators to assess exposure.

## Impact

An unauthenticated attacker with network access to a default GumCP installation
could run arbitrary commands as a passwordless-`sudo` user — full host compromise
(confidentiality, integrity and availability). GumCP is typically deployed on
Raspberry Pi / home-server systems on a LAN, and sometimes port-forwarded to the
internet, which widens exposure.

## Patches

Fixed in **[2.5.2](https://github.com/gumslone/GumCP/releases/tag/2.5.2)**. Upgrade with:

```bash
cd /var/www/html/GumCP && sudo git pull origin master
```

The fix:

- **Fails closed.** A new shipped `include/auth.php` holds the access gate,
  consulted by `include/init.php` on every page and endpoint. When no
  authentication is configured, GumCP refuses to serve and shows setup
  instructions instead of the panel.
- **Moves the gate into shipped code.** It previously lived in the user-owned
  `include/config.php`, which is git-ignored and never overwritten on upgrade — so
  no fix shipped there could have reached existing installations.
- `LOGIN_REQUIRED` now **defaults to `true`**.
- Serving an open panel now requires explicitly setting
  `GUMCP_ALLOW_UNAUTHENTICATED = true`, which displays a red warning banner on
  every page.
- A warning banner also appears while a shipped default password is in use, and
  **System Check** gained a Security section (authentication configured /
  open access disabled / credentials changed from defaults).

**After upgrading**, installations that had `LOGIN_REQUIRED = false` will show a
setup page until a login is configured in `include/config.php`:

```php
define('LOGIN_REQUIRED', true);
define('LOGIN_USER', 'your-username');
define('LOGIN_PASS', 'a-long-unique-password');
```

[2.5.3](https://github.com/gumslone/GumCP/releases/tag/2.5.3) adds follow-up
hardening: the Button API is disabled by default for new installs, accepts its key
via an `X-GumCP-Key` header instead of a query string, and supports an IP
allow-list.

## Workarounds

If you cannot upgrade immediately, do **any** of the following:

1. Enable authentication in `include/config.php` and restart nothing else:
   ```php
   define('LOGIN_REQUIRED', true);
   define('LOGIN_USER', 'your-username');
   define('LOGIN_PASS', 'a-long-unique-password');
   ```
2. Block the panel at the web server (e.g. Apache `Require ip 192.168.1.0/24`) or
   at the firewall, and remove any port-forward exposing it to the internet.
3. Stop serving GumCP until it is patched.

## Indicators of compromise

Command execution is logged locally — check for entries you did not initiate:

- `command_logs/*.log` — output of backgrounded commands
- `command_logs/api_calls.log` — Button API calls (JSON lines, includes source IP)
- `buttons/buttons.json` — unexpected or unfamiliar buttons
- web-server access logs — `POST` requests to `execute_command.php` or `ajax.php`
  from unfamiliar addresses

If you find evidence of exploitation, treat the host as compromised: rotate the
SSH and login credentials, regenerate button API hashes, and rebuild if practical.

## Credit

Reported by **Dhaiwat Mehta**, who identified the issue by code review and
confirmed it against a default installation. Thank you for the clear, well-scoped
report.

## References

- Fix release: https://github.com/gumslone/GumCP/releases/tag/2.5.2
- Hardening release: https://github.com/gumslone/GumCP/releases/tag/2.5.3
- Security policy: https://github.com/gumslone/GumCP/blob/master/SECURITY.md
- CWE-306: https://cwe.mitre.org/data/definitions/306.html
- CWE-1188: https://cwe.mitre.org/data/definitions/1188.html
