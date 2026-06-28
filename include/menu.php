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

<?php
// Resolve a module's link (iframe wrapper or direct page).
function gumcp_module_href($key, array $module): string {
    if (!empty($module['module_show_in_iframe']) && $module['module_show_in_iframe'] == 1) {
        return './iframe.php?module=' . urlencode((string)$key);
    }
    return htmlspecialchars($module['module_index_file_relative_path'] ?? '#', ENT_QUOTES, 'UTF-8');
}

// First pass: split modules into ungrouped (inline) and grouped (dropdowns),
// preserving order. Grouped modules carry a 'module_group' label.
$gumcp_groups = [];
foreach ($gumcp_modules as $key => $module):
    if (($module['module_active'] ?? 0) != 1) continue;
    if (!empty($module['module_no_nav'])) continue;

    $group = trim((string)($module['module_group'] ?? ''));
    if ($group !== '') {
        $gumcp_groups[$group][$key] = $module;
        continue;
    }

    $title     = htmlspecialchars($module['module_title'] ?? '', ENT_QUOTES, 'UTF-8');
    $is_active = $active_page === $key ? 'active' : '';
    ?>
    <li class="<?php echo $is_active; ?>">
        <a href="<?php echo gumcp_module_href($key, $module); ?>"><?php echo $title; ?></a>
    </li>
<?php endforeach; ?>

<?php foreach ($gumcp_groups as $group_name => $members): ?>
    <?php
    $group_active = '';
    foreach ($members as $mkey => $m) {
        if ($active_page === $mkey) { $group_active = 'active'; break; }
    }
    ?>
    <li class="dropdown <?php echo $group_active; ?>">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
           aria-haspopup="true" aria-expanded="false">
            <?php echo htmlspecialchars($group_name, ENT_QUOTES, 'UTF-8'); ?>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($members as $mkey => $m):
                $mtitle  = htmlspecialchars($m['module_title'] ?? '', ENT_QUOTES, 'UTF-8');
                $mactive = $active_page === $mkey ? 'active' : '';
            ?>
                <li class="<?php echo $mactive; ?>">
                    <a href="<?php echo gumcp_module_href($mkey, $m); ?>"><?php echo $mtitle; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </li>
<?php endforeach; ?>

<?php if (defined('LOGIN_REQUIRED') && LOGIN_REQUIRED === true): ?>
    <li><a href="./logout.php">Logout</a></li>
<?php endif; ?>
