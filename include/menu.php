<?php
$gumcp_modules = $gumcp_modules ?? [];
$active_page   = $active_page   ?? '';

// Apply saved menu order if it exists
$order_file = __DIR__ . '/menu_order.json';
if (is_readable($order_file)) {
    $saved_order = json_decode(file_get_contents($order_file), true);
    if (is_array($saved_order) && count($saved_order) > 0) {
        $ordered = [];
        foreach ($saved_order as $key) {
            if (isset($gumcp_modules[$key])) {
                $ordered[$key] = $gumcp_modules[$key];
            }
        }
        // Append any modules not yet in the saved order
        foreach ($gumcp_modules as $key => $mod) {
            if (!isset($ordered[$key])) {
                $ordered[$key] = $mod;
            }
        }
        $gumcp_modules = $ordered;
    }
}
?>
<li class="<?php echo $active_page === 'index' ? 'active' : ''; ?>">
    <a href="./index.php">Dashboard</a>
</li>

<?php foreach ($gumcp_modules as $key => $module): ?>
    <?php if (($module['module_active'] ?? 0) != 1) continue; ?>
    <?php
    $title     = htmlspecialchars($module['module_title'] ?? '', ENT_QUOTES, 'UTF-8');
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
