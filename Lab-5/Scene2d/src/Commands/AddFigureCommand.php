<?php

declare(strict_types=1);

namespace Scene2d\Commands;

use Scene2d\Figures\IFigure;
use Scene2d\Scene;

class AddFigureCommand implements ICommand
{
    private string $name;

    private IFigure $figure;

    public function __construct(string $name, IFigure $figure)
    {
        $this->name = $name;
        $this->figure = $figure;
    }

    public function apply(Scene $scene): void
    {
        $scene->addFigure($this->name, $this->figure);
    }

    public function friendlyResultMessage(): string
    {
        $className = get_class($this->figure);

        return "Added figure {$this->name} of type {$className}\n";
    }
}
