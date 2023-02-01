<?php

use PHPUnit\Framework\TestCase;
use function App\convertAllRgbDictionaryColorsToHEX;
use function App\convertRgbToHEX;
use function App\replaceColorCodesByNameFromDictionary;
use function App\replaceThreeCharacterHEXCode;

class UtilsTest extends TestCase
{
    public function test_convertRgbToHex_RGB_HEX()
    {
        self::assertEquals(convertRgbToHEX(0, 0, 0), '#000000');
        self::assertEquals(convertRgbToHEX(222, 3, 13), '#DE030D');
        self::assertEquals(convertRgbToHEX(3, 221, 210), '#03DDD2');
    }

    public function test_covertAbbreviatedHexToFull_abbreviatedHex_fullHEX()
    {
        $colorsDictionary = [
            "#FA2" => 'some_color',
        ];
        self::assertEquals(replaceThreeCharacterHEXCode('#A21', $colorsDictionary), '#A21');
        self::assertEquals(replaceThreeCharacterHEXCode('#FA2', $colorsDictionary), '#FA2');
    }

    public function test_convertAllRgbDictionaryColorsToHEX_rgbInText_textWithHex()
    {
        $colorsDictionary = [
            "#FFFAFA" => 'Snow',
            '#F5F5F5' => 'WhiteSmoke',
            '#FDF5E6' => 'OldLace'
        ];
        self::assertEquals(convertAllRgbDictionaryColorsToHEX('rgb(255,250,250);', $colorsDictionary), 'Snow;');
        self::assertEquals(convertAllRgbDictionaryColorsToHEX('rgb(253,    	245,230);', $colorsDictionary), 'OldLace;');
        self::assertEquals(convertAllRgbDictionaryColorsToHEX('rgb(1213,    	21313,3232);', $colorsDictionary), 'rgb(1213,    	21313,3232);');
        self::assertEquals(convertAllRgbDictionaryColorsToHEX('rgb(222,    	222,222);', $colorsDictionary), 'rgb(222,    	222,222);');
    }

    public function test_replaceColorCodesToNameFromDictionary_textWithHex_textWithColorsName()
    {
        $colorsDictionary = [
            '#000000' => 'Black',
            "#FFFAFA" => 'Snow',
            '#F5F5F5' => 'WhiteSmoke',
            '#FDF5E6' => 'OldLace'
        ];

        self::assertEquals(
            replaceColorCodesByNameFromDictionary('rgb(0,0,0)Hello #FFFAFA; #sadads #FDF5E6 #fff rgb(123321, 123132,123312)', $colorsDictionary),
            'BlackHello Snow; #sadads OldLace #fff rgb(123321, 123132,123312)'
        );
    }


}
