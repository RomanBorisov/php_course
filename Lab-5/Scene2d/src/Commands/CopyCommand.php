<?php


namespace Scene2d\Commands;


use Scene2d\Scene;

class CopyCommand implements ICommand
{
    private string $originalName;

    private string $copyName;

    public function __construct(string $originalName, string $copyName)
    {
        $this->originalName = $originalName;
        $this->copyName = $copyName;
    }

    public function apply(Scene $scene): void
    {
        if ($this->originalName === 'scene') {
            $scene->copyScene($this->copyName);
        } else {
            $scene->copy($this->originalName, $this->copyName);
        }
    }

    public function friendlyResultMessage(): string
    {
        if ($this->originalName === 'scene') {
            return "Copy scene to {$this->copyName} \n";
        }
        return "Copy figure {$this->originalName} to {$this->copyName} \n";
    }
}