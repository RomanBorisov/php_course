<?php


namespace Scene2d\Commands;


use Scene2d\Models\SceneRectangle;
use Scene2d\Scene;

class CircumscribingRectangleCommand implements ICommand
{
    private string $name;

    private SceneRectangle $rectangle;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function apply(Scene $scene): void
    {
        if ($this->name === 'scene') {
            $this->rectangle = $scene->calculateSceneCircumscribingRectangle();
        } else {
            $this->rectangle = $scene->calculateCircumscribingRectangle($this->name);
        }
    }

    public function friendlyResultMessage(): string
    {
        return "Circumscribing rectangle for {$this->name}:({$this->rectangle->vertex1->getX()}, {$this->rectangle->vertex1->getY()}) ({$this->rectangle->vertex2->getX()}, {$this->rectangle->vertex2->getY()})\n";
    }
}