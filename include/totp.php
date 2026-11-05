<?php
declare(strict_types=1);

// ── TOTP (RFC 6238) ───────────────────────────────────────────────────────────
// Six-digit codes from any authenticator app (Aegis, Google Authenticator,
// 1Password, …). Self-contained: HMAC-SHA1 over a 30-second counter, no
// library needed, works on PHP 7.0.

function gumcp_totp_enabled(): bool {
    return defined('LOGIN_TOTP_SECRET') && LOGIN_TOTP_SECRET !== '';
}

function gumcp_base32_decode(string $b32): string {
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $b32 = strtoupper(preg_replace('/[^A-Za-z2-7]/', '', $b32));
    $bits = '';
    $len = strlen($b32);
    for ($i = 0; $i < $len; $i++) {
        $bits .= str_pad(decbin((int)strpos($alphabet, $b32[$i])), 5, '0', STR_PAD_LEFT);
    }
    $out = '';
    foreach (str_split($bits, 8) as $byte) {
        if (strlen($byte) === 8) $out .= chr((int)bindec($byte));
    }
    return $out;
}

function gumcp_base32_encode(string $bin): string {
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $bits = '';
    $len = strlen($bin);
    for ($i = 0; $i < $len; $i++) {
        $bits .= str_pad(decbin(ord($bin[$i])), 8, '0', STR_PAD_LEFT);
    }
    $out = '';
    foreach (str_split($bits, 5) as $chunk) {
        $out .= $alphabet[(int)bindec(str_pad($chunk, 5, '0', STR_PAD_RIGHT))];
    }
    return $out;
}

/** A fresh 160-bit secret, base32 — the size authenticator apps expect. */
function gumcp_totp_new_secret(): string {
    return gumcp_base32_encode(random_bytes(20));
}

function gumcp_totp_code(string $secret_b32, int $counter): string {
    $key = gumcp_base32_decode($secret_b32);
    // 8-byte big-endian counter (pack 'J' needs 64-bit PHP; build it by hand).
    $msg  = pack('N2', ($counter >> 32) & 0xFFFFFFFF, $counter & 0xFFFFFFFF);
    $hash = hash_hmac('sha1', $msg, $key, true);
    $off  = ord($hash[19]) & 0x0F;
    $num  = ((ord($hash[$off]) & 0x7F) << 24)
          | (ord($hash[$off + 1]) << 16)
          | (ord($hash[$off + 2]) << 8)
          |  ord($hash[$off + 3]);
    return str_pad((string)($num % 1000000), 6, '0', STR_PAD_LEFT);
}

/**
 * Check a submitted code against the current 30 s step and one step either
 * side (clock drift). Returns the matching counter, or 0 when nothing matches.
 */
function gumcp_totp_match(string $secret_b32, string $code, $now = null): int {
    $code = preg_replace('/\s+/', '', $code);
    if (!preg_match('/^[0-9]{6}$/', $code)) return 0;
    $step = (int)floor(($now === null ? time() : (int)$now) / 30);
    foreach ([0, -1, 1] as $drift) {
        if (hash_equals(gumcp_totp_code($secret_b32, $step + $drift), $code)) {
            return $step + $drift;
        }
    }
    return 0;
}

/**
 * Verify a login code, refusing one that was already used. Without this a code
 * glimpsed over a shoulder (or captured on plain HTTP) stays valid for up to
 * 90 seconds.
 */
function gumcp_totp_verify_login(string $code): bool {
    if (!gumcp_totp_enabled()) return true;
    $counter = gumcp_totp_match((string)LOGIN_TOTP_SECRET, $code);
    if ($counter === 0) return false;

    $file = dirname(__DIR__) . '/command_logs/.totp_last';
    $last = (int)@file_get_contents($file);
    if ($counter <= $last) return false;
    @file_put_contents($file, (string)$counter, LOCK_EX);
    return true;
}
