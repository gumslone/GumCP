<?php
declare(strict_types=1);

// ── Shared dashboard collectors ───────────────────────────────────────────────
// Used by both index.php (initial render) and ajax.php (30 s refresh) so the two
// stay in sync. These are intentionally lightweight: mostly /proc and /sys reads
// with a couple of small shell calls that degrade gracefully when unavailable.

if (!function_exists('gumcp_swap_info')) {

    /**
     * Swap usage from /proc/meminfo. All values in kB.
     */
    function gumcp_swap_info(): array {
        $def = ['total' => 0, 'used' => 0, 'free' => 0, 'percent' => 0];
        $raw = @file_get_contents('/proc/meminfo');
        if ($raw === false) return $def;

        $get = static function(string $k) use ($raw): int {
            return preg_match('/^' . $k . ':\s+(\d+)/m', $raw, $m) ? (int)$m[1] : 0;
        };
        $total = $get('SwapTotal');
        $free  = $get('SwapFree');
        $used  = $total - $free;
        return [
            'total'   => $total,
            'used'    => $used,
            'free'    => $free,
            'percent' => $total > 0 ? (int)round($used / $total * 100) : 0,
        ];
    }

    /**
     * Per-interface network stats from /sys/class/net and /proc/net/wireless,
     * with IPv4 addresses resolved via a single `ip` call (falls back to none).
     * Returns a list of [iface, ip, state, rx, tx, wireless, signal].
     */
    function gumcp_network_info(): array {
        $interfaces = [];
        $net_dir    = '/sys/class/net';
        if (!is_dir($net_dir)) return $interfaces;

        // Build iface => IPv4 map from a single shell call (cheap, optional).
        $ip_map = [];
        $ip_raw = @shell_exec('ip -o -4 addr show 2>/dev/null');
        if (is_string($ip_raw) && $ip_raw !== '') {
            foreach (explode("\n", trim($ip_raw)) as $line) {
                // Format: "2: eth0    inet 192.168.1.10/24 brd ..."
                if (preg_match('/^\d+:\s+(\S+)\s+inet\s+([\d.]+)/', $line, $m)) {
                    $ip_map[$m[1]] = $m[2];
                }
            }
        }

        // Wi-Fi signal levels from /proc/net/wireless (dBm).
        $wifi_map = [];
        $wifi_raw = @file_get_contents('/proc/net/wireless');
        if (is_string($wifi_raw)) {
            foreach (explode("\n", $wifi_raw) as $line) {
                // "wlan0: 0000   70.  -40.  -256        0 ..."
                if (preg_match('/^\s*(\w+):\s+\S+\s+[\d.-]+\s+([\d.-]+)/', $line, $m)) {
                    $wifi_map[$m[1]] = (int)$m[2];
                }
            }
        }

        $entries = @scandir($net_dir) ?: [];
        foreach ($entries as $iface) {
            if ($iface === '.' || $iface === '..' || $iface === 'lo') continue;
            if ($iface[0] === '.') continue;

            $state = trim((string)@file_get_contents("$net_dir/$iface/operstate")) ?: 'unknown';
            $rx    = (int)trim((string)@file_get_contents("$net_dir/$iface/statistics/rx_bytes"));
            $tx    = (int)trim((string)@file_get_contents("$net_dir/$iface/statistics/tx_bytes"));
            $is_wireless = is_dir("$net_dir/$iface/wireless");

            $interfaces[] = [
                'iface'    => $iface,
                'ip'       => $ip_map[$iface] ?? '',
                'state'    => $state,
                'rx'       => $rx,
                'tx'       => $tx,
                'wireless' => $is_wireless,
                'signal'   => $wifi_map[$iface] ?? null, // dBm or null
            ];
        }

        // Stable order: up interfaces first, then by name.
        usort($interfaces, static function($a, $b) {
            $au = $a['state'] === 'up' ? 0 : 1;
            $bu = $b['state'] === 'up' ? 0 : 1;
            return $au === $bu ? strcmp($a['iface'], $b['iface']) : $au - $bu;
        });

        return $interfaces;
    }

    /**
     * Raspberry Pi throttling / under-voltage status via `vcgencmd get_throttled`.
     * Returns [available, healthy, messages]. messages is a list of human strings.
     */
    function gumcp_throttled_info(): array {
        $raw = @shell_exec('vcgencmd get_throttled 2>/dev/null');
        if (!is_string($raw) || !preg_match('/throttled=0x([0-9a-fA-F]+)/', $raw, $m)) {
            return ['available' => false, 'healthy' => true, 'messages' => []];
        }

        $bits = hexdec($m[1]);
        // bit => [label, is_current]
        $flags = [
            0  => ['Under-voltage detected',          true],
            1  => ['ARM frequency capped',            true],
            2  => ['Currently throttled',             true],
            3  => ['Soft temperature limit active',   true],
            16 => ['Under-voltage has occurred',      false],
            17 => ['ARM frequency capping occurred',  false],
            18 => ['Throttling has occurred',         false],
            19 => ['Soft temp limit has occurred',    false],
        ];

        $messages = [];
        $current  = false;
        foreach ($flags as $bit => $info) {
            if ($bits & (1 << $bit)) {
                $messages[] = $info[0];
                if ($info[1]) $current = true;
            }
        }

        return [
            'available' => true,
            'healthy'   => $messages === [],
            'current'   => $current,
            'messages'  => $messages,
        ];
    }

    /**
     * systemd status for a list of service names via `systemctl is-active`.
     * Returns a list of [name, state] where state is active/inactive/failed/unknown.
     */
    function gumcp_service_status(array $names): array {
        $result = [];
        foreach ($names as $name) {
            $name = trim((string)$name);
            if ($name === '' || !preg_match('/^[a-zA-Z0-9_@.\-]+$/', $name)) continue;

            $state = @shell_exec('systemctl is-active ' . escapeshellarg($name) . ' 2>/dev/null');
            $state = is_string($state) ? trim($state) : '';
            if ($state === '') $state = 'unknown';

            $result[] = ['name' => $name, 'state' => $state];
        }
        return $result;
    }

    /**
     * Format a byte count to a human string (matches dashboard fmtKB style).
     */
    function gumcp_fmt_bytes(float $bytes): string {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = $bytes > 0 ? min((int)log($bytes, 1024), count($units) - 1) : 0;
        return sprintf('%.2f %s', $bytes / (1024 ** $i), $units[$i]);
    }
}
