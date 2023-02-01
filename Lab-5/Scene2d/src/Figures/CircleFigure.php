<?php

declare(strict_types=1);

namespace Scene2d\Figures;

use Scene2d\Exceptions\NotImplementedException;
use Scene2d\ImageBuilder;
use Scene2d\Models\Color;
use Scene2d\Models\ScenePoint;
use Scene2d\Models\SceneRectangle;

class CircleFigure implements IFigure
{
    private ScenePoint $center;
    private float $radius;

    public function __construct(ScenePoint $center, float $radius)
    {
        $this->center = $center;
        $this->radius = $radius;
    }

    public function draw(ScenePoint $origin, ImageBuilder $imageBuilder): void
    {
        $imageBuilder->drawEllipse(
            $origin,
            (int)$this->center->getX(),
            (int)$this->center->getY(),
            (int)$this->radius,
            Color::green()
        );
    }

    public function calculateCircumscribingRectangle(): SceneRectangle
    {
        $p1 = new ScenePoint(-$this->radius, -$this->radius);
        $p2 = new ScenePoint($this->radius, $this->radius);

        return new SceneRectangle($p1, $p2);
    }

    public function move(ScenePoint $vector): void
    {
        $this->center = $this->center->add($vector);
    }

    public function rotate(float $angle): void
    {
    }

    public function reflect(string $orientation): void
    {
    }

    public function clone(): IFigure
    {
        return new CircleFigure($this->center, $this->radius);
    }
}
