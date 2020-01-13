<?php
if (!extension_loaded('example')) {
    throw new RuntimeException('extension "example" was not loaded');
}

var_dump(imgutil('icon_128.png'));
