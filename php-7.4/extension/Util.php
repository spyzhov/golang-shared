<?php

namespace PHP74;

use \FFI;
use RuntimeException;

class Util
{
    /** @var FFI */
    private static $ffi;

    public function __construct()
    {
        if (is_null(self::$ffi)) {
            self::$ffi = FFI::cdef("
typedef unsigned long long GoUint;
typedef long long GoInt;

extern char* GetImageSize(char* p0, GoUint* p1, GoUint* p2);
extern void HttpServe(GoInt p0);
extern char* JSONPath(char* p0, char* p1, char** p2);
", __DIR__ . "/libgolangutil.so");
        }
    }

    public function printImageSize(string $path): int
    {
        $h = FFI::new("unsigned long long");
        $w = FFI::new("unsigned long long");
        $err = self::$ffi->GetImageSize($path, FFI::addr($w), FFI::addr($h));
        if ($err) {
            printf("ERROR: %s", (string)$err);
            FFI::free($err);
            return 1;
        }

        printf("%s: %lux%lu\n", $path, $w->cdata, $h->cdata);

        return 0;
    }

    public function httpServe(int $port): void
    {
        self::$ffi->HttpServe($port);
    }

    public function jsonPath(string $path, string $json): array
    {
        $error = FFI::new("char*");
        $result = self::$ffi->JSONPath($path, $json, FFI::addr($error));

        $msg = "";
        try {
            $msg = "JSONPath error: {$error->cdata}";
            FFI::free($error);
        } catch (FFI\Exception $e) {
            $msg = "";
        }

        if (!empty($msg)) {
            throw new RuntimeException($msg);
        }
        $str = FFI::string($result);
        FFI::free($result);
        return json_decode($str, true, 512, JSON_THROW_ON_ERROR);
    }
}
