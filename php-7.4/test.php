<?php
if (!class_exists('ImgUtil', false)) {
    require_once __DIR__. '/extension/preload.php';
}
$util = new ImgUtil();
echo str_repeat("=", 20) . "\n";
var_dump($util->imgutil('icon_128.png'));
echo str_repeat("=", 20) . "\n";
