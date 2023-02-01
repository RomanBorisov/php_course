<?php

declare(strict_types=1);

namespace Scene2d\Figures;

use Scene2d\ImageBuilder;
use Scene2d\Models\Color;
use Scene2d\Models\ReflectOrientation;
use Scene2d\Models\ScenePoint;
use Scene2d\Models\SceneRectangle;

class PolygonFigure implements IFigure
{
    /** @var ScenePoint[] */
    private array $points;
    private ScenePoint $center;

    /** @param ScenePoint[] $points */
    public function __construct(array $points)
    {
        $this->points = $points;
        $this->center = $this->getPolygonCenter();
    }

    public function draw(ScenePoint $origin, ImageBuilder $imageBuilder): void
    {
        $pointsCount = count($this->points);
        foreach ($this->points as $i => $value) {
            $firstPoint = $value;
            $secondPoint = $i >= $pointsCount - 1
                ? $this->points[0]
                : $this->points[$i + 1];

            $imageBuilder->drawLine(
                $firstPoint->getX() - $origin->getX(),
                $firstPoint->getY() - $origin->getY(),
                $secondPoint->getX() - $origin->getX(),
                $secondPoint->getY() - $origin->getY(),
                Color::darkOrchid()
            );
        }
    }

    public function calculateCircumscribingRectangle(): SceneRectangle
    {
        $xCords = [];
        $yCoords = [];
        foreach ($this->points as $point) {
            $xCords[] = $point->getX();
            $yCoords[] = $point->getY();
        }
        $minX = min($xCords);
        $minY = min($yCoords);
        $maxX = max($xCords);
        $maxY = max($yCoords);

        return new SceneRectangle(new ScenePoint($minX, $minY), new ScenePoint($maxX, $maxY));
    }

    public function move(ScenePoint $vector): void
    {
        foreach ($this->points as $index => $point) {
            $this->points[$index] = $point->add($vector);
        }
        $this->center = $this->center->add($vector);
    }

    public function rotate(float $angle): void
    {
        foreach ($this->points as $index => $point) {
            $this->points[$index] = $this->getPointAfterRotating($point, $angle);
        }
    }

    public function reflect(string $orientation): void
    {
        $points = $this->points;
        $this->points = [];
        if ($orientation === ReflectOrientation::VERTICAL) {
            foreach ($points as $point) {
                $dy = abs($point->getY() - $this->center->getY());
                if ($point->getY() < $this->center->getY()) {
                    $this->points[] = new ScenePoint($point->getX(), $this->center->getY() + $dy);
                }
                if ($point->getY() > $this->center->getY()) {
                    $this->points[] = new ScenePoint($point->getX(), $this->center->getY() - $dy);
                }
                if ($point->getY() === $this->center->getY()) {
                    $this->points[] = $point;
                }
            }
        }
        if ($orientation === ReflectOrientation::HORIZONTAL) {
            foreach ($points as $point) {
                $dx = abs($point->getX() - $this->center->getX());
                if ($point->getX() < $this->center->getX()) {
                    $this->points[] = new ScenePoint($this->center->getX() + $dx, $point->getY());
                }
                if ($point->getX() > $this->center->getX()) {
                    $this->points[] = new ScenePoint($this->center->getX() - $dx, $point->getY());
                }
                if ($point->getX() === $this->center->getX()) {
                    $this->points[] = $point;
                }
            }
        }
    }

    public function clone(): IFigure
    {
        return new PolygonFigure($this->points);
    }

    private function getPolygonCenter(): ScenePoint
    {
        $xCoords = array_map(fn(ScenePoint $p): float => $p->getX(), $this->points);
        $yCoords = array_map(fn(ScenePoint $p): float => $p->getY(), $this->points);
        $maxX = max($xCoords);
        $minX = min($xCoords);
        $maxY = max($yCoords);
        $minY = min($yCoords);
        return new ScenePoint(($maxX + $minX) / 2, ($maxY + $minY) / 2);
    }

    private function getPointAfterRotating(ScenePoint $point, float $angle): ScenePoint
    {
        $angle = $angle * M_PI / 180.;
        $newX = $this->center->getX() + ($point->getX() - $this->center->getX()) * cos($angle) - ($point->getY() - $this->center->getY()) * sin($angle);
        $newY = $this->center->getY() + ($point->getY() - $this->center->getY()) * cos($angle) + ($point->getX() - $this->center->getX()) * sin($angle);
        return new ScenePoint($newX, $newY);
    }
}
