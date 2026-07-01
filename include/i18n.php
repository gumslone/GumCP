<?php
declare(strict_types=1);

// ── Minimal i18n ──────────────────────────────────────────────────────────────
// Language files live in include/lang/<code>.php and return an associative
// array of key => translated string. Missing keys fall back to English, then to
// the supplied default, so partial translations degrade gracefully.

function gumcp_supported_langs(): array {
    return [
        'en' => 'English',
        'de' => 'Deutsch',
        'uk' => 'Українська',
        'es' => 'Español',
        'fr' => 'Français',
    ];
}

function gumcp_current_lang(): string {
    static $lang = null;
    if ($lang !== null) return $lang;

    $supported = gumcp_supported_langs();

    // Switch via ?lang=xx — wins for this request, and is persisted in the session.
    if (isset($_GET['lang']) && isset($supported[$_GET['lang']])) {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['gumcp_lang'] = $_GET['lang'];
        }
        $lang = $_GET['lang'];
        return $lang;
    }

    if (isset($_SESSION['gumcp_lang']) && isset($supported[$_SESSION['gumcp_lang']])) {
        $lang = $_SESSION['gumcp_lang'];
    } else {
        $def  = defined('GUMCP_LANG') ? (string)GUMCP_LANG : 'en';
        $lang = isset($supported[$def]) ? $def : 'en';
    }
    return $lang;
}

function gumcp_translations(): array {
    static $cache = [];
    $lang = gumcp_current_lang();
    if (isset($cache[$lang])) return $cache[$lang];

    $strings = [];
    $base = __DIR__ . '/lang/en.php';
    if (is_readable($base)) {
        $en = include $base;
        if (is_array($en)) $strings = $en;
    }
    if ($lang !== 'en') {
        $file = __DIR__ . '/lang/' . $lang . '.php';
        if (is_readable($file)) {
            $over = include $file;
            if (is_array($over)) $strings = array_merge($strings, $over);
        }
    }
    $cache[$lang] = $strings;
    return $strings;
}

// Translate a key. $default is used when the key is absent from every file.
function t(string $key, $default = null): string {
    $s = gumcp_translations();
    if (isset($s[$key]) && $s[$key] !== '') return (string)$s[$key];
    return $default !== null ? (string)$default : $key;
}
