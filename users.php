<?php
declare(strict_types=1);

$active_page = 'users';

require_once('./include/init.php');

// ── Parse /etc/passwd and /etc/group (both world-readable) ────────────────────
function parse_passwd(): array {
    $users = [];
    $raw = @file_get_contents('/etc/passwd');
    if ($raw === false) return $users;
    foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        $f = explode(':', $line);
        if (count($f) < 7) continue;
        $users[] = [
            'name'    => $f[0],
            'uid'     => (int)$f[2],
            'gid'     => (int)$f[3],
            'comment' => trim($f[4]),
            'home'    => $f[5],
            'shell'   => $f[6],
        ];
    }
    usort($users, function($a, $b) { return $a['uid'] - $b['uid']; });
    return $users;
}

function parse_group(): array {
    $groups = [];
    $raw = @file_get_contents('/etc/group');
    if ($raw === false) return $groups;
    foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        $f = explode(':', $line);
        if (count($f) < 4) continue;
        $members = array_filter(array_map('trim', explode(',', $f[3])));
        $groups[] = [
            'name'    => $f[0],
            'gid'     => (int)$f[2],
            'members' => $members,
        ];
    }
    usort($groups, function($a, $b) { return $a['gid'] - $b['gid']; });
    return $groups;
}

$users  = parse_passwd();
$groups = parse_group();

// A "login" (human) account: uid 1000–59999 with a real shell.
function is_login_user(array $u): bool {
    return $u['uid'] >= 1000 && $u['uid'] < 60000
        && substr($u['shell'], -7) !== 'nologin'
        && substr($u['shell'], -5) !== 'false';
}

$login_users = array_filter($users, 'is_login_user');
$csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');

$page_title = 'Users & Groups';
require_once('./include/header.php');
?>
    <div class="page-header">
        <h1><i class="fa fa-users"></i> <?php echo htmlspecialchars(t('usr.title', 'Users & Groups'), ENT_QUOTES, 'UTF-8'); ?>
            <small><?php echo count($login_users); ?> / <?php echo count($users); ?></small>
        </h1>
    </div>

    <!-- Login (human) users -->
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-user"></i> <?php echo htmlspecialchars(t('usr.login_users', 'Login Users'), ENT_QUOTES, 'UTF-8'); ?></div>
        <table class="table table-condensed table-striped" style="margin-bottom:0">
            <thead>
                <tr><th style="padding-left:15px"><?php echo htmlspecialchars(t('usr.user', 'User'), ENT_QUOTES, 'UTF-8'); ?></th><th>UID</th><th>GID</th>
                    <th><?php echo htmlspecialchars(t('usr.home', 'Home'), ENT_QUOTES, 'UTF-8'); ?></th><th><?php echo htmlspecialchars(t('usr.shell', 'Shell'), ENT_QUOTES, 'UTF-8'); ?></th><th><?php echo htmlspecialchars(t('usr.comment', 'Comment'), ENT_QUOTES, 'UTF-8'); ?></th></tr>
            </thead>
            <tbody>
                <?php foreach ($login_users as $u): ?>
                    <tr>
                        <td style="padding-left:15px"><strong><?php echo htmlspecialchars($u['name'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                        <td><?php echo $u['uid']; ?></td>
                        <td><?php echo $u['gid']; ?></td>
                        <td><code><?php echo htmlspecialchars($u['home'], ENT_QUOTES, 'UTF-8'); ?></code></td>
                        <td><code><?php echo htmlspecialchars($u['shell'], ENT_QUOTES, 'UTF-8'); ?></code></td>
                        <td class="text-muted"><?php echo htmlspecialchars($u['comment'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($login_users)): ?>
                    <tr><td colspan="6" class="text-muted" style="padding-left:15px"><?php echo htmlspecialchars(t('usr.none', 'No login users found.'), ENT_QUOTES, 'UTF-8'); ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- All system accounts -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" href="#all-users" style="text-decoration:none; color:inherit; display:block">
                <i class="fa fa-list"></i> <?php echo htmlspecialchars(t('usr.all_accounts', 'All System Accounts'), ENT_QUOTES, 'UTF-8'); ?> (<?php echo count($users); ?>)
                <i class="fa fa-caret-down pull-right"></i>
            </a>
        </div>
        <div id="all-users" class="collapse">
            <table class="table table-condensed table-striped" style="margin-bottom:0">
                <thead>
                    <tr><th style="padding-left:15px"><?php echo htmlspecialchars(t('usr.user', 'User'), ENT_QUOTES, 'UTF-8'); ?></th><th>UID</th><th>GID</th>
                        <th><?php echo htmlspecialchars(t('usr.home', 'Home'), ENT_QUOTES, 'UTF-8'); ?></th><th><?php echo htmlspecialchars(t('usr.shell', 'Shell'), ENT_QUOTES, 'UTF-8'); ?></th></tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td style="padding-left:15px"><?php echo htmlspecialchars($u['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $u['uid']; ?></td>
                            <td><?php echo $u['gid']; ?></td>
                            <td><code><?php echo htmlspecialchars($u['home'], ENT_QUOTES, 'UTF-8'); ?></code></td>
                            <td><code><?php echo htmlspecialchars($u['shell'], ENT_QUOTES, 'UTF-8'); ?></code></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Groups -->
    <div class="panel panel-info">
        <div class="panel-heading"><i class="fa fa-users"></i> <?php echo htmlspecialchars(t('usr.groups', 'Groups'), ENT_QUOTES, 'UTF-8'); ?> (<?php echo count($groups); ?>)</div>
        <table class="table table-condensed table-striped" style="margin-bottom:0">
            <thead>
                <tr><th style="padding-left:15px"><?php echo htmlspecialchars(t('usr.groups', 'Group'), ENT_QUOTES, 'UTF-8'); ?></th><th>GID</th><th><?php echo htmlspecialchars(t('usr.members', 'Members'), ENT_QUOTES, 'UTF-8'); ?></th></tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $g): ?>
                    <tr>
                        <td style="padding-left:15px"><strong><?php echo htmlspecialchars($g['name'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                        <td><?php echo $g['gid']; ?></td>
                        <td class="text-muted">
                            <?php echo $g['members']
                                ? htmlspecialchars(implode(', ', $g['members']), ENT_QUOTES, 'UTF-8')
                                : '<span class="text-muted">—</span>'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <p class="text-muted" style="font-size:12px">
        <i class="fa fa-info-circle"></i> Read-only view of <code>/etc/passwd</code> and <code>/etc/group</code>.
    </p>

</div>

<?php require_once('./include/footer.php'); ?>
