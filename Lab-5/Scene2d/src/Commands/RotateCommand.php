<?php


namespace Scene2d\Commands;


use Scene2d\Scene;

class RotateCommand implements ICommand
{
    private string $name;
    private float $angle;

    public function __construct(string $name, float $angle)
    {
        $this->name = $name;
        $this->angle = $angle;
    }

    public function apply(Scene $scene): void
    {
        if ($this->name === 'scene') {
            $scene->rotateScene($this->angle);
        } else {
            $scene->rotate($this->name, $this->angle);
        }
    }

    public function friendlyResultMessage(): string
    {
        if ($this->name === 'scene') {
            return "Rotate {$this->name} to {$this->angle} \n";
        }
        return "Rotate figure {$this->name} to {$this->angle} \n";
    }
}
