<?php

declare(strict_types=1);

namespace App\Utils;

class StringUtils
{
    public static function camelToUnderscore(string $string): string
    {
        return strtolower(
            preg_replace(
                '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/',
                '_',
                $string
            )
        );
    }

}
