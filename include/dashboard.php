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
    /**
     * Locate the vcgencmd binary (often not on the web user's PATH). '' if absent.
     */
    function gumcp_vcgencmd_path(): string {
        static $cached = null;
        if ($cached !== null) return $cached;
        $cached = '';
        foreach (['/usr/bin/vcgencmd', '/opt/vc/bin/vcgencmd', 'vcgencmd'] as $cand) {
            $found = @shell_exec('command -v ' . escapeshellarg($cand) . ' 2>/dev/null');
            if (is_string($found) && trim($found) !== '') { $cached = trim($found); break; }
        }
        return $cached;
    }

    function gumcp_throttled_info(): array {
        $bin = gumcp_vcgencmd_path();
        if ($bin === '') {
            return ['available' => false, 'healthy' => true, 'messages' => [],
                    'reason' => 'vcgencmd not found (non-Pi hardware, or usbutils/raspi tools not installed)'];
        }

        // Capture stderr too — when www-data lacks GPU access vcgencmd writes the
        // error there and nothing parseable to stdout.
        $raw = @shell_exec(escapeshellarg($bin) . ' get_throttled 2>&1');
        if (!is_string($raw) || !preg_match('/throttled=0x([0-9a-fA-F]+)/', $raw, $m)) {
            $hint = (is_string($raw) && stripos($raw, 'permission') !== false || (is_string($raw) && stripos($raw, 'vchi') !== false))
                ? 'web user cannot access the GPU — run: sudo usermod -aG video www-data && sudo systemctl restart apache2'
                : 'vcgencmd returned no throttling data';
            return ['available' => false, 'healthy' => true, 'messages' => [], 'reason' => $hint];
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
            'reason'    => '',
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

    /**
     * CPU temperature in °C from the thermal zone (0.0 when unreadable).
     */
    function read_cpu_temp(): float {
        $raw = @file_get_contents('/sys/class/thermal/thermal_zone0/temp');
        return $raw !== false ? round((float)$raw / 1000, 1) : 0.0;
    }

    /**
     * CPU usage percentage measured against the previous /proc/stat snapshot.
     *
     * The snapshot persists in the temp dir between calls so the delta covers
     * the full polling interval instead of a tiny in-process window — this is
     * what prevents the "always 0 %" problem on lightly-loaded Pis. On the very
     * first call (no baseline) it falls back to a 300 ms in-process sample.
     */
    function read_cpu_usage(): int {
        $cache = sys_get_temp_dir() . '/gumcp_cpu_stat';

        $parse = function($raw) {
            return explode(' ', preg_replace('/\s+/', ' ', trim(explode("\n", $raw)[0])));
        };

        $current = @file_get_contents('/proc/stat');
        if ($current === false) return 0;

        $b    = $parse($current);
        $prev = @file_get_contents($cache);

        // Save current snapshot for the next call before any early return.
        @file_put_contents($cache, $current, LOCK_EX);

        if ($prev === false || $prev === '') {
            usleep(300000);
            $s2 = @file_get_contents('/proc/stat');
            if ($s2 === false) return 0;
            $b = $parse($s2);
            @file_put_contents($cache, $s2, LOCK_EX);
            $a = $parse($current);
        } else {
            $a = $parse($prev);
        }

        $idle  = (int)$b[4] - (int)$a[4];
        $total = 0;
        for ($i = 1; $i <= 8; $i++) {
            $total += ((int)($b[$i] ?? 0)) - ((int)($a[$i] ?? 0));
        }
        return $total > 0 ? (int)round(100 - ($idle * 100 / $total)) : 0;
    }

    /**
     * Human uptime from /proc/uptime, e.g. "3 days, 4 hours, 12 minutes".
     */
    function read_uptime(): string {
        $raw = @file_get_contents('/proc/uptime');
        if ($raw === false) return 'Unknown';

        $sec = (int)explode(' ', $raw)[0];
        $d   = (int)floor($sec / 86400);
        $h   = (int)floor(($sec % 86400) / 3600);
        $m   = (int)floor(($sec % 3600) / 60);
        return sprintf('%d day%s, %d hour%s, %d minute%s',
            $d, $d !== 1 ? 's' : '',
            $h, $h !== 1 ? 's' : '',
            $m, $m !== 1 ? 's' : '');
    }

    /**
     * Memory figures from /proc/meminfo. All values in kB.
     */
    function read_meminfo(): array {
        $defaults = ['total' => 0, 'free' => 0, 'available' => 0, 'buffers' => 0, 'cached' => 0, 'shared' => 0];
        $raw = @file_get_contents('/proc/meminfo');
        if ($raw === false) return $defaults;

        $get = function($key) use ($raw) {
            return preg_match('/^' . $key . ':\s+(\d+)/m', $raw, $m) ? (int)$m[1] : 0;
        };
        $total = $get('MemTotal');
        $free  = $get('MemFree');
        return [
            'total'     => $total,
            'free'      => $free,
            'available' => $get('MemAvailable') ?: $free,
            'buffers'   => $get('Buffers'),
            'cached'    => $get('Cached'),
            'shared'    => $get('Shmem'),
        ];
    }
}
