# Proof-of-concept

Using Golang shared libraries in other languages. 

Results for [library](library/main.go):
 * [php-7.3/Dockerfile](php-7.3/Dockerfile);
 * [php-7.4/Dockerfile](php-7.4/Dockerfile);
 * [python/Dockerfile](python/Dockerfile);
 * [java/Dockerfile](java/Dockerfile);

Based on:
* ["Creating shared libraries in Go"](http://snowsyn.net/2016/09/11/creating-shared-libraries-in-go/) article;
* [SWIG](http://www.swig.org)v3 tool for [php-7.3](php-7.3) version;
* [FFI](https://www.php.net/manual/class.ffi.php) for [php-7.4](php-7.4) version;
* ["A foreign function library for Python"](https://docs.python.org/3/library/ctypes.html) article for Python;
* ["Call a function in a shared library"](https://rosettacode.org/wiki/Call_a_function_in_a_shared_library#Java) article for JAVA;
 