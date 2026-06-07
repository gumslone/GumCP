<?php
declare(strict_types=1);

// ── SSH helper ────────────────────────────────────────────────────────────────
// Connects, authenticates, runs $cmd, captures stdout+stderr, disconnects.
// Returns ['success'=>true,'output'=>string] or ['success'=>false,'error'=>string].
function ssh_run(string $cmd, bool $capture = true): array {
    if (!function_exists('ssh2_connect')) {
        return ['success' => false, 'error' => 'php-ssh2 extension is not installed'];
    }

    $conn = null;
    try {
        $conn = @ssh2_connect('localhost', (int)SSH_PORT);
        if ($conn === false) {
            throw new Exception('Could not connect to SSH on port ' . SSH_PORT);
        }
        if (!@ssh2_auth_password($conn, SSH_USER, SSH_PASS)) {
            throw new Exception('SSH authentication failed — check SSH_USER / SSH_PASS in config.php');
        }

        $stream = ssh2_exec($conn, $cmd);
        if ($stream === false) {
            throw new Exception('ssh2_exec failed');
        }

        $output = '';
        if ($capture) {
            stream_set_blocking($stream, true);
            $stdout = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
            $stderr = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
            $out_s  = (string)stream_get_contents($stdout);
            $err_s  = (string)stream_get_contents($stderr);
            fclose($stdout);
            fclose($stderr);
            $output = trim($out_s . ($err_s !== '' ? "\n[stderr]\n" . $err_s : ''));
        }

        @ssh2_exec($conn, 'exit');
        return ['success' => true, 'output' => $output];

    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    } finally {
        unset($conn);
    }
}
