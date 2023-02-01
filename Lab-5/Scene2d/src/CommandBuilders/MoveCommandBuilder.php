<?php


namespace Scene2d\CommandBuilders;


use Scene2d\Commands\MoveCommand;
use Scene2d\Exceptions\BadFormatException;
use Scene2d\Models\ScenePoint;

class MoveCommandBuilder implements ICommandBuilder
{
    private static string $recognizeRegex = '/^move (?P<name>[\w]*) \((?P<x>-?\d+)\s*,\s*(?P<y>-?\d+)\)/';

    private string $name;
    private ScenePoint $vector;

    public function isCommandReady(): bool
    {
        return true;
    }

    public function appendLine(string $line): void
    {
        if (preg_match(self::$recognizeRegex, $line, $matches)) {
            $matches = (object)$matches;
            $this->name = $matches->name;
            $this->vector = new ScenePoint((float)$matches->x, (float)$matches->y);
        } else {
            throw new BadFormatException();
        }
    }

    public function getCommand(): MoveCommand
    {
        return new MoveCommand($this->name, $this->vector);
    }
}
