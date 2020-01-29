<?php
namespace PHP73;

class Util
{
    public function __construct()
    {
        if (!extension_loaded('example')) {
            throw new RuntimeException('extension "example" was not loaded');
        }
    }

    public function printImageSize(string $path): int
    {
        return print_image_size($path);
    }

    public function httpServe(int $port): void
    {
        http_serve($port);
    }

    public function jsonPath(string $path, string $json): array
    {
        $error = "";
        $result = json_path($path, $json, $error);
        if (!empty($error)) {
            throw new RuntimeException("JSONPath error: {$error}");
        }
        return json_decode($result, true, 512, JSON_THROW_ON_ERROR);
    }
}
