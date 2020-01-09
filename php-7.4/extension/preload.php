<?php
if (function_exists('opcache_compile_file')) {
    // for PHP-FPM:
    opcache_compile_file(__DIR__ . "/libimgutil.php");
} else {
    require_once __DIR__ . "/libimgutil.php";
}
