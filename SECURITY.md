# Security Policy

## Reporting a vulnerability

**Please report privately — do not open a public issue.**

Use GitHub's [Private Vulnerability Reporting](https://github.com/gumslone/GumCP/security/advisories/new)
(Security → Advisories → Report a vulnerability). It's the fastest route and keeps
the report private until a fix ships.

Helpful things to include: affected version or commit, the endpoint or file
involved, what an attacker gains, and the minimum steps to reproduce.

You'll normally get an acknowledgement within a few days. GumCP is maintained by
one person in their spare time, so please allow reasonable time for a fix before
disclosing publicly. Reporters are credited in the advisory and CHANGELOG unless
you'd rather stay anonymous.

## Supported versions

| Version | Supported |
|---|---|
| 2.5.x   | ✅ |
| < 2.5.2 | ❌ — contains a critical unauthenticated RCE ([GHSA / 2.5.2 release notes](https://github.com/gumslone/GumCP/releases/tag/2.5.2)) |

Only the latest release receives security fixes. Upgrade with:

```bash
cd /var/www/html/GumCP && sudo git pull origin master
```

## Threat model — please read before reporting

GumCP is a **privileged administration panel**. By design it:

- executes arbitrary shell commands over SSH (Actions page, command buttons)
- manages packages, services, cron jobs, GPIO and Raspberry Pi boot configuration
- expects its SSH user to have `sudo` access

So the following are **working as intended**, not vulnerabilities:

- An authenticated administrator can run arbitrary commands, including as root.
  That is the product's purpose. See
  [Limiting what GumCP can run](README.md#limiting-what-gumcp-can-run) to reduce
  the blast radius with a scoped `sudoers` allow-list.
- The **Button API** (`api.php`) executes a button without a login when given that
  button's 32-hex secret hash. The hash *is* the credential. New installs get it
  **off** (`config.example.php` ships `module_active => 0`) and it can be
  restricted with `$gumcp_api_allow_ips`. Note that a `config.php` with **no**
  `button_api` entry — one written before the module flag existed, or trimmed by
  hand — is backfilled as **enabled**, so that upgrades do not silently break
  existing automations. System Check reports when it is on without an IP
  allow-list; pin `module_active` in your `config.php` to choose explicitly.
- Running with `GUMCP_ALLOW_UNAUTHENTICATED = true` disables authentication. That
  is a deliberate, documented opt-in that shows a red banner on every page.

Reports we very much **do** want:

- any way to reach a privileged endpoint **without** valid credentials
- authentication or session bypass, privilege escalation, CSRF
- command or SQL injection reachable by an unauthenticated or lower-privileged caller
- path traversal, arbitrary file read/write, or secret disclosure (config values,
  session tokens, button hashes)
- insecure defaults that expose a fresh install

## Hardening recommendations

- **Never expose GumCP directly to the internet.** Use it on a trusted LAN, or
  reach it over a VPN / SSH tunnel.
- Set a strong `LOGIN_PASS`; never keep a shipped default password.
- Serve it over HTTPS — GumCP sends credentials and command output in plain HTTP otherwise.
- Give the SSH user only the `sudo` rights it needs (see the README section above).
- Keep the Button API disabled unless you use it; restrict it by IP and send keys
  via the `X-GumCP-Key` header rather than a query string.
- Sessions end after `SESSION_IDLE_TIMEOUT` (1 hour) and
  `SESSION_ABSOLUTE_TIMEOUT` (12 hours); shorten them if the panel is used from
  shared machines.
- Review `command_logs/auth.log` — every sign-in, failed attempt, lockout and
  timeout is recorded there, and the last ten appear on the System Check page.
- Run the built-in **System Check** page — it reports whether authentication is
  configured and whether default passwords are still in use.

## Credits

| Reporter | Issue |
|---|---|
| Dhaiwat Mehta | Unauthenticated remote command execution via auth-disabled-by-default (fixed in 2.5.2) |
