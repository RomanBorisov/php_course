<?php


namespace Scene2d\Commands;


use Scene2d\Scene;

class ReflectCommand implements ICommand
{
    private string $name;
    private string $orientation;

    public function __construct(string $name, string $orientation)
    {
        $this->name = $name;
        $this->orientation = $orientation;
    }

    public function apply(Scene $scene): void
    {
        if ($this->name === 'scene') {
            $scene->reflectScene($this->orientation);
        } else {
            $scene->reflect($this->name, $this->orientation);
        }
    }

    public function friendlyResultMessage(): string
    {
        if ($this->name === 'scene') {
            return "Scene reflected {$this->orientation}\n";
        }
        return "Figure {$this->name} reflected {$this->orientation}\n";
    }
}
