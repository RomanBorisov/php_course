<?php

declare(strict_types=1);

namespace App;

function countUniqueWordsInText(string $sourceString): int
{
    return count(getUniqueWordsInText($sourceString));
}

/**
 * @return string[]
 */
function getUniqueWordsInText(string $sourceString): array
{
    $allWords = convertWordsInTextToArray($sourceString);
    return array_unique($allWords);
}

/**
 * @return string[]
 */
function convertWordsInTextToArray(string $text): array
{
    $arr = preg_split("/[\s,:\"&!();?.\-\d]+/", $text, -1, PREG_SPLIT_NO_EMPTY);
    return array_map('mb_strtolower', $arr);
}

/**
 * @param string[] $ignoredFiles
 */
function getFilesContentFromDir(string $folderForReading, array $ignoredFiles = []): string
{
    $result = '';
    $files = array_diff(getFileNamesFromDirectory($folderForReading), $ignoredFiles);
    foreach($files as $file) {
        $separateFileContent = file_get_contents($folderForReading.$file);
        $result .= $separateFileContent;
    }
    return $result;
}

/**
 * @return string[]
 */
function getFileNamesFromDirectory(string $dir): array
{
    $files = [];
    $handle = scandir($dir);
    foreach($handle as $item) {
        if($item !== "." && $item !== "..") {
            $files[] = $item;
        }
    }
    return $files;
}

function readFileDataAndConvertEncoding(string $sourceFile, string $fromEncoding, string $toEncoding): string
{
    $fileContent = file_get_contents($sourceFile);
    return mb_convert_encoding($fileContent, $fromEncoding, $toEncoding);
}
