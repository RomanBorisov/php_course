<?php


namespace Scene2d\Commands;


use Scene2d\Models\ScenePoint;
use Scene2d\Scene;

class MoveCommand implements ICommand
{
    private string $name;
    private ScenePoint $vector;

    public function __construct(string $name, ScenePoint $vector)
    {
        $this->name = $name;
        $this->vector = $vector;
    }

    public function apply(Scene $scene): void
    {
        if ($this->name === 'scene') {
            $scene->moveScene($this->vector);
        } else {
            $scene->move($this->name, $this->vector);
        }
    }

    public function friendlyResultMessage(): string
    {
        if ($this->name === 'scene') {
            return "Move {$this->name} to {$this->vector->__toString()} \n";
        }
        return "Figure {$this->name} moved by {$this->vector}\n";
    }
}
