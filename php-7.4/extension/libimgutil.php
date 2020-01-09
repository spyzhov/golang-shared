<?php

class ImgUtil
{
    private static $ffi = null;

    public function __construct()
    {
        if (is_null(self::$ffi)) {
            self::$ffi = \FFI::cdef("
typedef long GoInt;
extern char* ImgutilGetImageSize(char* p0, GoInt* p1, GoInt* p2);
", __DIR__ . "/libimgutil.so");
        }
    }

    public function imgutil(string $path): int
    {
        $h = \FFI::new("long");
        $w = \FFI::new("long");
        $err = self::$ffi->ImgutilGetImageSize($path, \FFI::addr($w), \FFI::addr($h));
        if ($err) {
            printf("ERROR: %s", (string)$err);
            return 100;
        }
        return (int)printf("%s: %lux%lu\n", $path, $w->cdata, $h->cdata);
    }
}
