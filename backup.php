<?php
declare(strict_types=1);

// ── Backup & restore ──────────────────────────────────────────────────────────
// Everything GumCP keeps that is NOT in git — config, buttons, menu order, the
// user's scripts and dashboard pins — as one JSON file. An SD card failure
// otherwise loses all of it.
//
// The bundle is plain JSON with base64 file bodies: no zip/phar extension is
// needed (PHP 7.0 installs often lack them), and every entry can be validated
// against a fixed whitelist on the way back in.

$active_page = 'actions';

require_once('./include/init.php');

/** The only relative paths a bundle may contain. */
function gumcp_backup_allowed(string $rel): bool {
    if (in_array($rel, [
        'include/config.php',
        'include/menu_order.json',
        'buttons/buttons.json',
        'user_scripts/.pins.json',
    ], true)) {
        return true;
    }
    // user_scripts/<name>: same rule the Script Editor enforces.
    if (strpos($rel, 'user_scripts/') === 0) {
        $name = substr($rel, strlen('user_scripts/'));
        return strlen($name) <= 64
            && (bool)preg_match('/^[A-Za-z0-9][A-Za-z0-9._-]*\.(sh|py|txt)$/', $name);
    }
    return false;
}

function gumcp_backup_collect(): array {
    $files = [];
    $root  = __DIR__;
    $candidates = ['include/config.php', 'include/menu_order.json',
                   'buttons/buttons.json', 'user_scripts/.pins.json'];
    foreach (glob($root . '/user_scripts/*') ?: [] as $p) {
        $candidates[] = 'user_scripts/' . basename($p);
    }
    foreach ($candidates as $rel) {
        $path = $root . '/' . $rel;
        if (!gumcp_backup_allowed($rel) || !is_file($path) || is_link($path)) continue;
        $body = @file_get_contents($path);
        if ($body === false) continue;
        $files[$rel] = base64_encode($body);
    }
    return $files;
}

$csrf_ok = $_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], (string)($_POST['csrf_token'] ?? ''));

$messages = [];
$errors   = [];

// ── Download ──────────────────────────────────────────────────────────────────
if ($csrf_ok && ($_POST['action'] ?? '') === 'download') {
    $bundle = json_encode([
        'gumcp_backup' => 1,
        'created'      => date('c'),
        'files'        => gumcp_backup_collect(),
    ]);
    gumcp_auth_log('backup', 'backup downloaded');
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="gumcp-backup-' . date('Y-m-d') . '.json"');
    header('Content-Length: ' . strlen((string)$bundle));
    header('Cache-Control: no-store');
    echo $bundle;
    exit();
}

// ── Restore ───────────────────────────────────────────────────────────────────
if ($csrf_ok && ($_POST['action'] ?? '') === 'restore') {
    $up = $_FILES['bundle'] ?? null;
    if (!is_array($up) || (int)$up['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($up['tmp_name'])) {
        $errors[] = 'No backup file was uploaded.';
    } elseif ((int)$up['size'] > 8 * 1024 * 1024) {
        $errors[] = 'Backup file is too large (max 8 MB).';
    } else {
        $data = json_decode((string)file_get_contents($up['tmp_name']), true);
        if (!is_array($data) || empty($data['gumcp_backup']) || !isset($data['files']) || !is_array($data['files'])) {
            $errors[] = 'That file is not a GumCP backup.';
        } else {
            $with_config = !empty($_POST['restore_config']);
            $restored = 0;
            $skipped  = [];
            foreach ($data['files'] as $rel => $b64) {
                $rel = (string)$rel;
                // Never trust the bundle: it is an uploaded file, and a path in
                // it is exactly what a traversal attack would look like.
                if (!gumcp_backup_allowed($rel)) { $skipped[] = $rel . ' (not an allowed path)'; continue; }
                $body = base64_decode((string)$b64, true);
                if ($body === false) { $skipped[] = $rel . ' (corrupt)'; continue; }

                if ($rel === 'include/config.php') {
                    if (!$with_config) { $skipped[] = $rel . ' (tick the box to restore it)'; continue; }
                    if (strpos(ltrim($body), '<?php') !== 0) { $skipped[] = $rel . ' (not PHP)'; continue; }
                    @copy(__DIR__ . '/' . $rel, __DIR__ . '/' . $rel . '.restore.bak');
                }

                $path = __DIR__ . '/' . $rel;
                if (is_link($path)) { $skipped[] = $rel . ' (target is a symlink)'; continue; }
                if (!is_dir(dirname($path))) @mkdir(dirname($path), 0755, true);
                if (@file_put_contents($path, $body, LOCK_EX) === false) {
                    $skipped[] = $rel . ' (not writable)';
                    continue;
                }
                $restored++;
            }
            gumcp_auth_log('restore', $restored . ' file(s) restored' . ($with_config ? ', including config.php' : ''));
            $messages[] = $restored . ' file(s) restored.';
            foreach ($skipped as $sk) $errors[] = 'Skipped: ' . $sk;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !$csrf_ok) {
    $errors[] = 'Session expired — reload the page and try again.';
}

$csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
$page_title = 'Backup & Restore';
require_once('./include/header.php');
?>

<div class="page-header">
    <h1><i class="fa fa-life-ring"></i> <?php echo htmlspecialchars(t('backup.title', 'Backup & Restore'), ENT_QUOTES, 'UTF-8'); ?></h1>
</div>

<?php foreach ($messages as $m): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($m, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endforeach; ?>
<?php foreach ($errors as $e): ?>
    <div class="alert alert-warning"><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endforeach; ?>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-download"></i> <?php echo htmlspecialchars(t('backup.download', 'Download a backup'), ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="panel-body">
                <p>One file containing <code>include/config.php</code>, your command buttons,
                   the menu order, and everything in <code>user_scripts/</code>.</p>
                <p class="text-danger"><i class="fa fa-exclamation-triangle"></i>
                   The backup contains your passwords and button API keys. Store it like a password.</p>
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                    <input type="hidden" name="action" value="download">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i> <?php echo htmlspecialchars(t('backup.download_btn', 'Download backup'), ENT_QUOTES, 'UTF-8'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-warning">
            <div class="panel-heading"><i class="fa fa-upload"></i> <?php echo htmlspecialchars(t('backup.restore', 'Restore from a backup'), ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="panel-body">
                <p>Files in the backup overwrite the current ones. Scripts and buttons that are
                   not in the backup are left alone.</p>
                <form method="post" enctype="multipart/form-data"
                      onsubmit="return confirm('Restore from this backup? Existing files with the same names are overwritten.');">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                    <input type="hidden" name="action" value="restore">
                    <div class="form-group">
                        <input type="file" name="bundle" accept=".json,application/json" required>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="restore_config" value="1">
                            Also restore <code>include/config.php</code>
                            <span class="text-muted">— replaces the current login and SSH credentials;
                            the old file is kept as <code>config.php.restore.bak</code></span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-upload"></i> <?php echo htmlspecialchars(t('backup.restore_btn', 'Restore'), ENT_QUOTES, 'UTF-8'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('./include/footer.php'); ?>
