<?php
declare(strict_types=1);

// Cache-busting version for the static/css.php and static/js.php bundles.
// They are served with a 30-day cache lifetime, so without a changing query
// string every user keeps running month-old JS/CSS after a GumCP update —
// which surfaces as pages that "half work" until a hard refresh.
function gumcp_asset_version(): string {
    static $v = null;
    if ($v !== null) return $v;
    $latest = 0;
    foreach (['/../static/js.php', '/../static/css.php'] as $bundle) {
        $latest = max($latest, (int)@filemtime(__DIR__ . $bundle));
    }
    foreach (['/../static/js/*.js', '/../static/css/*.css'] as $glob) {
        foreach (glob(__DIR__ . $glob) ?: [] as $f) {
            $latest = max($latest, (int)@filemtime($f));
        }
    }
    $v = (string)$latest;
    return $v;
}
