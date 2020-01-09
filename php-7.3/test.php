<?php
if (!extension_loaded('example')) {
    throw new RuntimeException('extension "example" was not loaded');
}
echo str_repeat("=", 20) . "\n";
var_dump(imgutil('icon_128.png'));
echo str_repeat("=", 20) . "\n";
