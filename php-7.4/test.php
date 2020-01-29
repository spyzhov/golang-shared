<?php
require_once __DIR__ . "/extension/Util.php";
$util = new \PHP74\Util();

$url = "http://localhost:8080/management/health";

print "IMAGE_SIZE\n";
$util->printImageSize("example.png");

print "HTTP_SERVE\n";
$util->httpServe(8080);
usleep(100);
$content = file_get_contents($url);
print("Got from {$url}:\n{$content}");

print "JSON_PATH\n";
var_dump($util->jsonPath("$.service", $content));

$example = file_get_contents('example.json');
$examples = [
    '$..author' => 'all authors',
    '$.store..price' => 'the price of everything in the store.',
    '$..book[(@.length-1)]' => 'the last book in order.',
    '$..book[?(@.price<10)]' => 'filter all books cheapier than 10',
];
echo "For exampe: \n{$example}\n\n";
foreach ($examples as $key => $value) {
    echo "\t{$value}: {$key}\n";
    var_dump($util->jsonPath($key, $example));
}
