<?php

declare(strict_types=1);

namespace App;

require_once '../vendor/autoload.php';

const RESOURCES_INPUT_PATH = '../resources/input/';
$usedColors = [];

$colorsDictionary = getDictionaryOfColorsFromFile(RESOURCES_INPUT_PATH . 'colors.txt');
$sourceFileContent = file_get_contents(RESOURCES_INPUT_PATH . 'source.txt');

$refactoredContent = replaceColorCodesByNameFromDictionary($sourceFileContent, $colorsDictionary, $usedColors);

file_put_contents(RESOURCES_INPUT_PATH . 'target.txt', $refactoredContent);
file_put_contents(RESOURCES_INPUT_PATH . 'used_colors.txt', prepareColorsInfo($usedColors, $colorsDictionary));

