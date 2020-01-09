<?php
require_once __DIR__ . "/extension/libimgutil.php";
$util = new ImgUtil();
echo str_repeat("=", 20) . "\n";
var_dump($util->imgutil('icon_128.png'));
echo str_repeat("=", 20) . "\n";
