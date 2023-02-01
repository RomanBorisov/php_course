<?php

declare(strict_types=1);

namespace Scene2d\Figures;

use Scene2d\ImageBuilder;
use Scene2d\Models\ScenePoint;
use Scene2d\Models\SceneRectangle;

class CompositeFigure implements ICompositeFigure
{
    /**
     * @var IFigure[]
     */
    private array $figures;

    /**
     * @param IFigure[] $figures
     */
    public function __construct(array $figures)
    {
        $this->figures = $figures;
    }

    public function getChildFigures(): array
    {
        return $this->figures;
    }

    public function calculateCircumscribingRectangle(): SceneRectangle
    {
        $points = [];
        foreach ($this->figures as $figure) {
            $points[] = $figure->calculateCircumscribingRectangle()->vertex1;
            $points[] = $figure->calculateCircumscribingRectangle()->vertex2;
        }
        $xCoordinates = array_map(fn(ScenePoint $p): float => $p->getX(), $points);
        $yCoordinates = array_map(fn(ScenePoint $p): float => $p->getY(), $points);

        return new SceneRectangle(
            new ScenePoint(min($xCoordinates), min($yCoordinates)),
            new ScenePoint(max($xCoordinates), max($yCoordinates)),
        );
    }

    public function move(ScenePoint $vector): void
    {
        foreach ($this->figures as $figure) {
            $figure->move($vector);
        }
    }

    public function rotate(float $angle): void
    {
        foreach ($this->figures as $figure) {
            $figure->rotate($angle);
        }
    }

    public function reflect(string $orientation): void
    {
        foreach ($this->figures as $figure) {
            $figure->reflect($orientation);
        }
    }

    public function draw(ScenePoint $origin, ImageBuilder $imageBuilder): void
    {
    }

    public function clone(): ICompositeFigure
    {
        $clones = [];
        foreach ($this->figures as $figure) {
            $clones[] = clone $figure;
        }
        return new CompositeFigure($clones);
    }
}