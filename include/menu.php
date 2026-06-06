<?php
$gumcp_modules = $gumcp_modules ?? [];
$active_page   = $active_page   ?? '';
?>
<li class="<?php echo $active_page === 'index' ? 'active' : ''; ?>">
    <a href="./index.php">Dashboard</a>
</li>

<?php foreach ($gumcp_modules as $key => $module): ?>
    <?php if (($module['module_active'] ?? 0) != 1) continue; ?>
    <?php
    $title  = htmlspecialchars($module['module_title']  ?? '', ENT_QUOTES, 'UTF-8');
    $is_active = $active_page === $key ? 'active' : '';

    if (!empty($module['module_show_in_iframe']) && $module['module_show_in_iframe'] == 1):
        $href = './iframe.php?module=' . urlencode((string)$key);
    else:
        $href = htmlspecialchars($module['module_index_file_relative_path'] ?? '#', ENT_QUOTES, 'UTF-8');
    endif;
    ?>
    <li class="<?php echo $is_active; ?>">
        <a href="<?php echo $href; ?>"><?php echo $title; ?></a>
    </li>
<?php endforeach; ?>

<?php if (defined('LOGIN_REQUIRED') && LOGIN_REQUIRED === true): ?>
    <li><a href="./logout.php">Logout</a></li>
<?php endif; ?>
