<?php


namespace Scene2d\CommandBuilders;


use Scene2d\Commands\ICommand;
use Scene2d\Commands\ReflectCommand;
use Scene2d\Exceptions\BadFormatException;
use Scene2d\Models\ReflectOrientation;

class ReflectCommandBuilder implements ICommandBuilder
{
    private static string $recognizeRegex = '/^reflect (?P<orientation>(vertically|horizontally)) (?P<name>[\w]*)/';
    private string $name;
    private string $orientation;

    public function isCommandReady(): bool
    {
        return true;
    }

    public function appendLine(string $line): void
    {
        if (preg_match(self::$recognizeRegex, $line, $matches)) {
            $matches = (object)$matches;
            $this->name = $matches->name;
            if ($matches->orientation === 'vertically') {
                $this->orientation = ReflectOrientation::VERTICAL;
            } else if ($matches->orientation === 'horizontally'){
                $this->orientation = ReflectOrientation::HORIZONTAL;
            }
        } else {
            throw new BadFormatException();
        }
    }

    public function getCommand(): ?ICommand
    {
        return new ReflectCommand($this->name, $this->orientation);
    }
}
