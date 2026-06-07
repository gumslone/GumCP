<?php
declare(strict_types=1);

// ── Cache headers ─────────────────────────────────────────────────────────────
$offset = 60 * 60 * 24 * 30; // 30 days
header('Content-Type: text/javascript; charset=UTF-8');
header('Cache-Control: max-age=' . $offset . ', must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT');

// ── Light compressor ──────────────────────────────────────────────────────────
// The bundled files are already minified; this pass only trims line comments
// and collapses blank lines that may appear at file boundaries.
function compress_js(string $js): string
{
    // Strip standalone // line comments (whole lines only — avoids touching
    // protocol strings like "https://" inside code or minified expressions).
    $js = (string)preg_replace('/^\s*\/\/[^\n]*$/m', '', $js);
    // Remove leftover bare "//" on their own line (from comment-only lines)
    $js = str_replace(["//\r\n", "//\n"], "\n", $js);
    // Collapse consecutive blank lines to one
    $js = (string)preg_replace('/\n{3,}/', "\n\n", $js);
    return trim($js);
}

// ── Bundle ────────────────────────────────────────────────────────────────────
ob_start();
include __DIR__ . '/js/wow.min.js';
include __DIR__ . '/js/jquery-2.2.4.min.js';
include __DIR__ . '/js/bootstrap.min.js';
include __DIR__ . '/js/bootstrap-switch.js';
include __DIR__ . '/js/jquery.easing.min.js';
include __DIR__ . '/js/jquery.easypiechart.min.js';
include __DIR__ . '/js/gumcp.js';
$out = (string)ob_get_clean();

$out = compress_js($out);

// ── Output (with optional gzip) ───────────────────────────────────────────────
$accept = (string)($_SERVER['HTTP_ACCEPT_ENCODING'] ?? '');
if (strpos($accept, 'gzip') !== false) {
    header('Content-Encoding: gzip');
    header('Vary: Accept-Encoding');
    ob_start('ob_gzhandler');
    echo $out;
    ob_end_flush();
} else {
    echo $out;
}
