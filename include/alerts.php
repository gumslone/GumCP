<?php
declare(strict_types=1);

// ── Alerts ────────────────────────────────────────────────────────────────────
// Push a short message to the administrator's phone when something needs
// attention: the CPU running hot, under-voltage, a full disk, or someone being
// locked out after repeated failed logins. Two channels, both optional:
//
//   ntfy      — define('ALERT_NTFY_URL', 'https://ntfy.sh/your-secret-topic');
//   Telegram  — ALERT_TELEGRAM_TOKEN (from @BotFather) + ALERT_TELEGRAM_CHAT
//
// Nothing is sent anywhere unless one of them is configured.

function gumcp_alert_configured(): bool {
    return (defined('ALERT_NTFY_URL') && ALERT_NTFY_URL !== '')
        || (defined('ALERT_TELEGRAM_TOKEN') && ALERT_TELEGRAM_TOKEN !== ''
            && defined('ALERT_TELEGRAM_CHAT') && ALERT_TELEGRAM_CHAT !== '');
}

/** POST with a short timeout so a dead endpoint can never stall a page. */
function gumcp_alert_post(string $url, string $body, array $headers): bool {
    if (!preg_match('#^https?://#i', $url)) return false;

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (PHP_VERSION_ID < 80000) curl_close($ch);
        return $code >= 200 && $code < 300;
    }

    $ctx = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => implode("\r\n", $headers),
        'content' => $body,
        'timeout' => 5,
        'ignore_errors' => true,
    ]]);
    $res = @file_get_contents($url, false, $ctx);
    return $res !== false;
}

/**
 * Send to every configured channel. Returns ['ntfy' => bool, 'telegram' => bool]
 * for the channels that were attempted.
 */
function gumcp_alert_send(string $title, string $message): array {
    $host    = (string)(php_uname('n') ?: 'raspberrypi');
    $results = [];

    if (defined('ALERT_NTFY_URL') && ALERT_NTFY_URL !== '') {
        // Header values must be single-line ASCII; the body carries the detail.
        $safe_title = preg_replace('/[^\x20-\x7E]/', '', 'GumCP ' . $host . ': ' . $title);
        $results['ntfy'] = gumcp_alert_post(
            (string)ALERT_NTFY_URL,
            $message,
            ['Title: ' . $safe_title, 'Content-Type: text/plain; charset=utf-8']
        );
    }

    if (defined('ALERT_TELEGRAM_TOKEN') && ALERT_TELEGRAM_TOKEN !== ''
        && defined('ALERT_TELEGRAM_CHAT') && ALERT_TELEGRAM_CHAT !== '') {
        $results['telegram'] = gumcp_alert_post(
            'https://api.telegram.org/bot' . rawurlencode((string)ALERT_TELEGRAM_TOKEN) . '/sendMessage',
            http_build_query([
                'chat_id' => (string)ALERT_TELEGRAM_CHAT,
                'text'    => 'GumCP ' . $host . ' — ' . $title . "\n" . $message,
            ]),
            ['Content-Type: application/x-www-form-urlencoded']
        );
    }
    return $results;
}

function gumcp_alert_state_file(): string {
    // The periodic check runs from cron as the SSH user, who usually cannot
    // write to command_logs/ (owned by the web server) — fall back to /tmp.
    $dir = dirname(__DIR__) . '/command_logs';
    if (is_dir($dir) && is_writable($dir)) return $dir . '/.alert_state.json';
    return sys_get_temp_dir() . '/gumcp_alert_state_' . md5(__DIR__) . '.json';
}

/**
 * Send an alert at most once per $cooldown seconds for the same $key, so a Pi
 * that stays hot for an hour sends one message rather than twelve.
 */
function gumcp_alert_once(string $key, string $title, string $message, int $cooldown = 3600): bool {
    if (!gumcp_alert_configured()) return false;

    $file  = gumcp_alert_state_file();
    $state = json_decode((string)@file_get_contents($file), true);
    if (!is_array($state)) $state = [];

    if (isset($state[$key]) && time() - (int)$state[$key] < $cooldown) return false;

    $state[$key] = time();
    foreach ($state as $k => $t) {                       // forget stale entries
        if (time() - (int)$t > 7 * 86400) unset($state[$k]);
    }
    @file_put_contents($file, json_encode($state), LOCK_EX);

    gumcp_alert_send($title, $message);
    return true;
}
