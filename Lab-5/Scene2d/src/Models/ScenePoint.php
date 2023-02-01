<?php

declare(strict_types=1);

namespace Scene2d\Models;

class ScenePoint
{
    private float $x;

    private float $y;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function add(self $vector): self
    {
        return new self($this->x + $vector->x, $this->y + $vector->y);
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function __toString(): string
    {
        return "({$this->x}, {$this->y})";
    }
}
