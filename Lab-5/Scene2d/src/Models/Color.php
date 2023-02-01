<?php

declare(strict_types=1);

namespace Scene2d\Models;

class Color
{
    public int $red;
    public int $green;
    public int $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public static function darkGrey(): self
    {
        return new self(128, 128, 128);
    }

    public static function green(): self
    {
        return new self(0, 255, 0);
    }

    public static function darkOrchid(): self
    {
        return new self(153, 50, 204);
    }

    public static function blue(): self
    {
        return new self(0, 0, 255);
    }
}
