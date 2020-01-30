<?php
require_once __DIR__ . "/../extension/Util.php";
require_once __DIR__ . "/jsonpath-0.8.1.php";

$example = file_get_contents('example.json');
$examples = [
    '$..author',
    '$.store..price',
    "$..book[:2]",
];

function test_Golang($count)
{
    global $example, $examples;
    $util = null;
    if (class_exists('\PHP73\Util')) {
        $util = new \PHP73\Util();
    } else {
        $util = new \PHP74\Util();
    }
    $time_start = microtime(true);
    for ($i = 0; $i < $count; ++$i) {
        foreach ($examples as $path) {
            $util->jsonPath($path, $example);
        }
    }
    return number_format(microtime(true) - $time_start, 3);
}

function test_PHP($count)
{
    global $example, $examples;
    $time_start = microtime(true);
    for ($i = 0; $i < $count; ++$i) {
        foreach ($examples as $path) {
            jsonPath(json_decode($example, true), $path);
        }
    }
    return number_format(microtime(true) - $time_start, 3);
}

// ****************************************************************************************************************** //
$total = 0;
$count = 10000;
$functions = get_defined_functions();
$line = str_pad("-", 38, "-");
echo "$line\n" .
    "|" . str_pad("PHP BENCHMARK SCRIPT", 36, " ", STR_PAD_BOTH) . "|\n" .
    "$line\n" .
    "Start : " . date("Y-m-d H:i:s") . "\n" .
    "PHP version : " . PHP_VERSION . "\n" .
    "Platform : " . PHP_OS . "\n$line\n";
foreach ($functions['user'] as $user) {
    if (preg_match('/^test_/', $user)) {
        $total += $result = $user($count);
        echo str_pad($user, 25) . " : " . $result . " sec.\n";
    }
}
echo str_pad("-", 38, "-") . "\n" . str_pad("Total time:", 25) . " : " . $total . " sec.\n";
