<?php
declare(strict_types=1);

// ── Cache headers ─────────────────────────────────────────────────────────────
$offset = 60 * 60 * 24 * 30; // 30 days
header('Content-Type: text/css; charset=UTF-8');
header('Cache-Control: max-age=' . $offset . ', must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT');

// ── Minifier ──────────────────────────────────────────────────────────────────
function compress_css(string $css): string
{
    // Strip block comments
    $css = (string)preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // Collapse whitespace characters to single spaces
    $css = str_replace(["\r\n", "\r", "\n", "\t"], ' ', $css);
    $css = (string)preg_replace('/\s{2,}/', ' ', $css);
    // Remove spaces around structural characters
    $css = (string)preg_replace('/\s*([{}:;,>~+\[\]=|])\s*/', '$1', $css);
    // Remove trailing semicolons before closing braces
    $css = str_replace(';}', '}', $css);
    // Tidy whitespace inside parentheses
    $css = str_replace(['( ', ' )'], ['(', ')'], $css);
    return trim($css);
}

// ── Bundle ────────────────────────────────────────────────────────────────────
ob_start();
include __DIR__ . '/css/animate.css';
include __DIR__ . '/css/flags.css';
include __DIR__ . '/css/bootstrap-theme.min.css';
include __DIR__ . '/css/bootstrap.min.css';
include __DIR__ . '/css/bootstrap-switch.min.css';
include __DIR__ . '/css/style.css';
$out = (string)ob_get_clean();

$out = compress_css($out);

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
