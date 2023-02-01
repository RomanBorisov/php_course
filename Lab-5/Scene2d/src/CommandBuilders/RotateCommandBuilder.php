<?php


namespace Scene2d\CommandBuilders;


use Scene2d\Commands\ICommand;
use Scene2d\Commands\RotateCommand;
use Scene2d\Exceptions\BadFormatException;

class RotateCommandBuilder implements ICommandBuilder
{

    private static string $recognizeRegex = '/^rotate (?P<name>[\w]*) (?P<angle>-?\d+)/';
    private string $name;
    private float $angle;

    public function isCommandReady(): bool
    {
        return true;
    }

    public function appendLine(string $line): void
    {
        if (preg_match(self::$recognizeRegex, $line, $matches)) {
            $matches = (object)$matches;
            $this->name = $matches->name;
            $this->angle = $matches->angle;
        } else {
            throw new BadFormatException();
        }
    }

    public function getCommand(): ?ICommand
    {
        return new RotateCommand($this->name, $this->angle);
    }
}
