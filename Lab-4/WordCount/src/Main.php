<?php

declare(strict_types=1);

namespace App;

require_once '../vendor/autoload.php';

$resourceDir = '../resources/input/';
$filesWithWindowsEncoding = ['Начало.txt'];

$filesContent = getFilesContentFromDir($resourceDir, $filesWithWindowsEncoding);

foreach($filesWithWindowsEncoding as $file) {
    $filesContent .= readFileDataAndConvertEncoding($resourceDir.$file, "utf-8", "windows-1251");
}

print_r(countUniqueWordsInText($filesContent));
