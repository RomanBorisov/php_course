<?php

declare(strict_types=1);

namespace Scene2d\Figures;

use Scene2d\ImageBuilder;
use Scene2d\Models\Color;
use Scene2d\Models\ReflectOrientation;
use Scene2d\Models\ScenePoint;
use Scene2d\Models\SceneRectangle;

class RectangleFigure implements IFigure
{
    private ScenePoint $p1;
    private ScenePoint $p2;
    private ScenePoint $p3;
    private ScenePoint $p4;
    private ScenePoint $center;

    public function __construct(ScenePoint $p1, ScenePoint $p2)
    {
        $this->p1 = $p1;
        $this->p2 = new ScenePoint($p2->getX(), $p1->getY());
        $this->p3 = $p2;
        $this->p4 = new ScenePoint($p1->getX(), $p2->getY());
        $this->center = new ScenePoint(($p1->getX() + $p2->getX()) / 2, ($p1->getY() + $p2->getY()) / 2);
    }

    public function clone(): self
    {
        return clone $this;
    }

    public function calculateCircumscribingRectangle(): SceneRectangle
    {
        $points = [$this->p1, $this->p2, $this->p3, $this->p4];
        $xCoords = array_map(fn(ScenePoint $p): float => $p->getX(), $points);
        $yCoords = array_map(fn(ScenePoint $p): float => $p->getY(), $points);

        return new SceneRectangle(
            new ScenePoint(min($xCoords), min($yCoords)),
            new ScenePoint(max($xCoords), max($yCoords)),
        );
    }

    public function move(ScenePoint $vector): void
    {
        $this->p1 = $this->p1->add($vector);
        $this->p2 = $this->p2->add($vector);
        $this->p3 = $this->p3->add($vector);
        $this->p4 = $this->p4->add($vector);
        $this->center = $this->center->add($vector);
    }

    public function rotate(float $angle): void
    {
        $this->p1 = $this->pointAfterRotating($this->p1, $angle);
        $this->p2 = $this->pointAfterRotating($this->p2, $angle);
        $this->p3 = $this->pointAfterRotating($this->p3, $angle);
        $this->p4 = $this->pointAfterRotating($this->p4, $angle);
    }

    public function reflect(string $orientation): void
    {
        $newPoint = [];
        if ($orientation === ReflectOrientation::VERTICAL) {
            foreach ([$this->p1, $this->p2, $this->p3, $this->p4] as $point) {
                $dy = abs($point->getY() - $this->center->getY());
                if ($point->getY() < $this->center->getY()) {
                    $newPoint[] = new ScenePoint($point->getX(), $this->center->getY() + $dy);
                }
                if ($point->getY() > $this->center->getY()) {
                    $newPoint[] = new ScenePoint($point->getX(), $this->center->getY() - $dy);
                }
                if ($point->getY() === $this->center->getY()) {
                    $newPoint[] = $point;
                }
            }
        }
        if ($orientation === ReflectOrientation::HORIZONTAL) {
            foreach ([$this->p1, $this->p2, $this->p3, $this->p4] as $point) {
                $dx = abs($point->getX() - $this->center->getX());
                if ($point->getX() < $this->center->getX()) {
                    $newPoint[] = new ScenePoint($this->center->getX() + $dx, $point->getY());
                }
                if ($point->getX() > $this->center->getX()) {
                    $newPoint[] = new ScenePoint($this->center->getX() - $dx, $point->getY());
                }
                if ($point->getX() === $this->center->getX()) {
                    $newPoint[] = $point;
                }
            }
        }
        $this->p1 = $newPoint[0];
        $this->p2 = $newPoint[1];
        $this->p3 = $newPoint[2];
        $this->p4 = $newPoint[3];
    }

    public function draw(ScenePoint $origin, ImageBuilder $imageBuilder): void
    {
        $imageBuilder->drawLine(
            $this->p1->getX() - $origin->getX(),
            $this->p1->getY() - $origin->getY(),
            $this->p2->getX() - $origin->getX(),
            $this->p2->getY() - $origin->getY(),
            Color::blue()
        );

        $imageBuilder->drawLine(
            $this->p2->getX() - $origin->getX(),
            $this->p2->getY() - $origin->getY(),
            $this->p3->getX() - $origin->getX(),
            $this->p3->getY() - $origin->getY(),
            Color::blue()
        );

        $imageBuilder->drawLine(
            $this->p3->getX() - $origin->getX(),
            $this->p3->getY() - $origin->getY(),
            $this->p4->getX() - $origin->getX(),
            $this->p4->getY() - $origin->getY(),
            Color::blue()
        );

        $imageBuilder->drawLine(
            $this->p4->getX() - $origin->getX(),
            $this->p4->getY() - $origin->getY(),
            $this->p1->getX() - $origin->getX(),
            $this->p1->getY() - $origin->getY(),
            Color::blue()
        );
    }

    private function pointAfterRotating(ScenePoint $point, float $angle): ScenePoint
    {
        $angle = $angle * M_PI / 180.0;
        $x = $this->center->getX() + ($point->getX() - $this->center->getX()) * cos($angle) - ($point->getY() - $this->center->getY()) * sin($angle);
        $y = $this->center->getY() + ($point->getY() - $this->center->getY()) * cos($angle) + ($point->getX() - $this->center->getX()) * sin($angle);
        return new ScenePoint($x, $y);
    }
}
