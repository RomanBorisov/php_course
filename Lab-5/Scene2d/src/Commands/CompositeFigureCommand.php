<?php


namespace Scene2d\Commands;


use Scene2d\Scene;

class CompositeFigureCommand implements ICommand
{

    private array $figureNames;

    private string $name;

    public function __construct(string $name, array $figureNames)
    {
        $this->name = $name;
        $this->figureNames = $figureNames;
    }

    public function apply(Scene $scene): void
    {
        $scene->createCompositeFigure($this->name, $this->figureNames);
    }

    public function friendlyResultMessage(): string
    {
        return "Create group {$this->name} \n";
    }
}
