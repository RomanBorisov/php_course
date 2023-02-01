<?php


namespace Scene2d\Commands;

use Scene2d\Scene;

class DeleteCommand implements ICommand
{
    private string $name;


    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function apply(Scene $scene): void
    {
        if ($this->name === 'scene') {
            $scene->deleteScene();
        } else {
            $scene->delete($this->name);
        }
    }

    public function friendlyResultMessage(): string
    {
        if ($this->name === 'scene') {
            return "Deleted scene \n";
        }
        return "Deleted figure {$this->name} \n";
    }
}