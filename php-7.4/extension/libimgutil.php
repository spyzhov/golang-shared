<?php

class ImgUtil
{
    private static $ffi = null;

    public function __construct()
    {
        if (is_null(self::$ffi)) {
            self::$ffi = \FFI::cdef("
typedef unsigned long long GoUint;
extern char* ImgutilGetImageSize(char* p0, GoUint* p1, GoUint* p2);
", __DIR__ . "/libimgutil.so");
        }
    }

    public function imgutil(string $path): int
    {
        $h = \FFI::new("unsigned long long");
        $w = \FFI::new("unsigned long long");
        $err = self::$ffi->ImgutilGetImageSize($path, \FFI::addr($w), \FFI::addr($h));
        if ($err) {
            printf("ERROR: %s", (string)$err);
            return 1;
        }

        printf("%s: %lux%lu\n", $path, $w->cdata, $h->cdata);

        return 0;
    }
}
