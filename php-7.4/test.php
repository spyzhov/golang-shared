<?php
require_once __DIR__ . "/extension/libimgutil.php";
$util = new ImgUtil();

var_dump($util->imgutil('icon_128.png'));
