<?php

declare(strict_types=1);

namespace Scene2d\Figures;

use Scene2d\ImageBuilder;
use Scene2d\Models\ScenePoint;
use Scene2d\Models\SceneRectangle;

interface IFigure
{
    public function calculateCircumscribingRectangle(): SceneRectangle;

    public function move(ScenePoint $vector): void;

    public function rotate(float $angle): void;

    public function reflect(string $orientation): void;

    public function draw(ScenePoint $origin, ImageBuilder $imageBuilder): void;

    public function clone(): IFigure;
}
