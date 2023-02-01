<?php

declare(strict_types=1);

namespace App;

/**
 * @param string $filename
 * @return string[]
 */
function getDictionaryOfColorsFromFile(string $filename): array
{
    $colorsInfo = file($filename, FILE_IGNORE_NEW_LINES);

    return convertColorsInfoToDictionary($colorsInfo);
}

/**
 * @param string[] $colorsInfo
 * @return string[]
 */
function convertColorsInfoToDictionary(array $colorsInfo): array
{
    $result = [];
    foreach ($colorsInfo as $color) {
        $temp = explode(' ', $color);
        $result[$temp[1]] = $temp[0];
    }
    return $result;
}

/**
 * @param string $sourceText
 * @param string[] $colorsDictionary
 * @param string[] $usedColors
 * @return string
 */
function replaceColorCodesByNameFromDictionary(string $sourceText, array $colorsDictionary, array &$usedColors = []): string
{
    $resultText = convertAllRgbDictionaryColorsToHEX($sourceText, $colorsDictionary, $usedColors);
    $resultText = replaceThreeCharacterHEXCode($resultText, $colorsDictionary);
    return replaceHexByNameFromDictionary($resultText, $colorsDictionary, $usedColors);
}

/**
 * @param string $sourceText
 * @param string[] $colorsDictionary
 * @param string[] $usedColors
 * @return string
 */
function convertAllRgbDictionaryColorsToHEX(string $sourceText, array $colorsDictionary, array &$usedColors = []): string
{
    $regexRGB = "/(rgb\(\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*)\)/i";
    return preg_replace_callback(
        $regexRGB,
        static function ($match) use ($colorsDictionary, &$usedColors) {
            $rgbColor = extractPrimaryColorsFromRGB($match[0]);
            $colorInHEX = convertRgbToHEX($rgbColor[0], $rgbColor[1], $rgbColor[2]);
            if (isColorInDictionary($colorInHEX, $colorsDictionary)) {
                return getColorNameFromDictionary($colorInHEX, $colorsDictionary, $usedColors);
            }
            return $match[0];
        },
        $sourceText
    );
}

/**
 * @param string $color
 * @return int[]
 */
function extractPrimaryColorsFromRGB(string $color): array
{
    $regexRGB = "/(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})/";
    $rgb = [];
    $result = [];
    preg_match_all($regexRGB, $color, $rgb);
    for ($i = 1; $i <= 3; $i++) {
        $result[] = (int)$rgb[$i][0];
    }

    return $result;
}

function convertRgbToHEX(int $red, int $green, int $blue): string
{
    return strtoupper(sprintf("#%02x%02x%02x", $red, $green, $blue));
}

/**
 * @param string $sourceText
 * @param string[] $colorsDictionary
 * @return string
 */
function replaceThreeCharacterHEXCode(string $sourceText, array $colorsDictionary): string
{
    $hexRegex = '/#([a-f0-9])([a-f0-9])([a-f0-9])\b/i';
    return preg_replace_callback([$hexRegex],
        function ($match) use ($colorsDictionary) {
            $fullHex = strtoupper(covertAbbreviatedHexToFull($match[0]));
            if (isColorInDictionary($fullHex, $colorsDictionary)) {
                return $fullHex;
            }
            return $match[0];
        }, $sourceText);
}

/**
 * @param string $sourceText
 * @param string[] $colorsDictionary
 * @param string[] $usedColors
 * @return string
 */
function replaceHexByNameFromDictionary(string $sourceText, array $colorsDictionary, array &$usedColors = []): string
{
    $regexHEX = "/(#([a-z0-9]){6})/i";

    return preg_replace_callback(
        $regexHEX,
        static function ($match) use ($colorsDictionary, &$usedColors) {
            return getColorNameFromDictionary($match[0], $colorsDictionary, $usedColors);
        },
        $sourceText
    );
}

/**
 * @param string $colorInHEX
 * @param string[] $colorsDictionary
 * @param string[] $usedColors
 * @return string
 */
function getColorNameFromDictionary(string $colorInHEX, array $colorsDictionary, array &$usedColors = []): string
{
    if (isColorInDictionary(strtoupper($colorInHEX), $colorsDictionary)) {
        $colorInHEX = strtoupper($colorInHEX);
        if (!in_array($colorInHEX, $usedColors, true)) {
            $usedColors[] = $colorInHEX;
        }
        return $colorsDictionary[$colorInHEX];
    }
    return $colorInHEX;
}

/**
 * @param string $colorInHexFormat
 * @param string[] $colorsDictionary
 * @return bool
 */
function isColorInDictionary(string $colorInHexFormat, array $colorsDictionary): bool
{
    return array_key_exists($colorInHexFormat, $colorsDictionary);
}

/**
 * @param string[] $colors
 * @param string[] $colorsDictionary
 * @return string
 */
function prepareColorsInfo(array $colors, array $colorsDictionary): string
{
    $usedColorsInfo = '';

    asort($colors);
    foreach ($colors as $color) {
        $usedColorsInfo .= $color . ' ' . $colorsDictionary[$color] . "\n";
    }
    return $usedColorsInfo;
}

function covertAbbreviatedHexToFull(string $AbbreviatedHex): string
{
    return preg_replace('/#([a-f0-9])([a-f0-9])([a-f0-9])/i', '#\1\1\2\2\3\3', $AbbreviatedHex);
}
