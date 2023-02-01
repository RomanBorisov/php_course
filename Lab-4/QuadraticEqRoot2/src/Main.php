<?php

declare(strict_types=1);

namespace App;

include '../vendor/autoload.php';

$outputPath = '../resources/output/output.txt';

if (file_exists($outputPath)) {
    unlink($outputPath);
}

$inputFile = fopen('../resources/input/input.txt', 'r');
$outputFile = fopen($outputPath, 'w');

while (($line = fgets($inputFile)) !== false) {
    $a = 1; // todo: get from line
    $b = 2; // todo: get from line
    $c = 3; // todo: get from line

    $roots = solveEquation($a, $b, $c);

    $outputLine = 'todo';

    fputs($outputFile, $outputLine);
}

fclose($inputFile);
fclose($outputFile);
