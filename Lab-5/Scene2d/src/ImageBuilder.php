<?php

declare(strict_types=1);

namespace Scene2d;

use Scene2d\Models\Color;
use Scene2d\Models\ScenePoint;

class ImageBuilder
{
    /** @var resource */
    private $image;

    public function __construct(int $width, int $height, Color $backgroundColor)
    {
        $image = imagecreatetruecolor($width, $height);
        $backgroundColorId = $this->getColorId($backgroundColor, $image);
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColorId);

        $this->image = $image;
    }

    public function drawEllipse(ScenePoint $origin, int $centerX, int $centerY, int $radius, Color $color): void
    {
        imageellipse(
            $this->image,
            (int)($centerX - $origin->getX()),
            (int)($centerY - $origin->getY()),
            $radius * 2,
            $radius * 2,
            $this->getColorId($color)
        );
    }

    public function create(string $path): bool
    {
        return imagepng($this->image, $path);
    }

    public function drawLine(float $x1, float $y1, float $x2, float $y2, Color $color): void
    {
        imageline(
            $this->image,
            (int)$x1,
            (int)$y1,
            (int)$x2,
            (int)$y2,
            $this->getColorId($color)
        );
    }

    /**
     * @param Color $color
     * @param resource|null $image
     * @return int
     */
    private function getColorId(Color $color, $image = null): int
    {
        return imagecolorallocate($image ?? $this->image, $color->red, $color->green,$color->blue);
    }
}
