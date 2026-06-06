<?php
declare(strict_types=1);

require_once('./include/config.php');

// Set JSON response header
header('Content-Type: application/json');

// Initialize response
$response = [
    'success' => false,
    'message' => '',
    'log_file' => ''
];

try {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        throw new Exception('Invalid CSRF token');
    }

    // Get and validate command
    $cmd = $_POST['cmd'] ?? '';
    
    if (empty($cmd)) {
        throw new Exception('No command provided');
    }

    // Sanitize command (basic validation)
    $cmd = trim($cmd);
    
    if (strlen($cmd) > 5000) {
        throw new Exception('Command too long (max 5000 characters)');
    }

    // Ensure command_logs directory exists with proper permissions
    $command_logs_dir = __DIR__ . '/command_logs';
    
    if (!file_exists($command_logs_dir)) {
        if (!mkdir($command_logs_dir, 0755, true)) {
            throw new Exception('Failed to create command_logs directory');
        }
    }

    if (!is_writable($command_logs_dir)) {
        if (!chmod($command_logs_dir, 0755)) {
            throw new Exception('command_logs directory is not writable');
        }
    }

    // Generate unique log filename
    $log_filename = date('Y-m-d_H-i-s') . '_' . substr(md5($cmd . microtime()), 0, 8) . '.txt';
    $log_path = $command_logs_dir . '/' . $log_filename;
    $relative_log_path = './command_logs/' . $log_filename;

    // Connect via SSH
    $connection = @ssh2_connect('localhost', (int)SSH_PORT);
    
    if ($connection === false) {
        throw new Exception('Failed to connect to SSH server');
    }

    // Authenticate
    if (!@ssh2_auth_password($connection, SSH_USER, SSH_PASS)) {
        throw new Exception('SSH authentication failed');
    }

    // Prepare command with output redirection
    $full_command = sprintf(
        '%s > %s 2>&1 &',
        $cmd,
        escapeshellarg($log_path)
    );

    // Execute command
    $stream = @ssh2_exec($connection, $full_command);
    
    if ($stream === false) {
        throw new Exception('Failed to execute command');
    }

    // Set stream to blocking mode to get immediate output
    stream_set_blocking($stream, true);
    
    // Get STDIO stream
    $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
    
    // Read any immediate output
    $immediate_output = stream_get_contents($stream_out);
    
    // Close stream
    fclose($stream_out);
    
    // Close SSH connection
    @ssh2_exec($connection, 'exit');
    unset($connection);

    // Wait a moment for log file to be created
    usleep(100000); // 100ms

    // Verify log file was created
    if (!file_exists($log_path)) {
        // Create empty log file if it doesn't exist
        file_put_contents($log_path, "Command executed: " . date('Y-m-d H:i:s') . "\n");
    }

    $response['success'] = true;
    $response['message'] = 'Command executed successfully in background';
    $response['log_file'] = $relative_log_path;
    
    if (!empty($immediate_output)) {
        $response['immediate_output'] = trim($immediate_output);
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Error: ' . $e->getMessage();
    
    // Log error for debugging
    error_log('execute_command.php error: ' . $e->getMessage());
}

// Output JSON response
echo json_encode($response, JSON_PRETTY_PRINT);
exit;