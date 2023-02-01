<?php


namespace Scene2d\CommandBuilders;


use Scene2d\Commands\AddFigureCommand;
use Scene2d\Commands\ICommand;
use Scene2d\Exceptions\BadFormatException;
use Scene2d\Figures\CircleFigure;
use Scene2d\Figures\IFigure;
use Scene2d\Models\ScenePoint;

class AddCircleCommandBuilder implements ICommandBuilder
{
    private static string $recognizeRegex = '/^add circle (?P<name>[\w]*) \((?P<centerX>-?\d+)\s*,\s*(?P<centerY>-?\d+)\) radius (?P<radius>\d+)/';
    private ?IFigure $circle = null;
    private string $name;

    public function isCommandReady(): bool
    {
        return true;
    }

    public function appendLine(string $line): void
    {
        if (preg_match(self::$recognizeRegex, $line, $matches)) {
            $matches = (object)$matches;
            $this->name = $matches->name;
            $center = new ScenePoint((float)$matches->centerX, (float)$matches->centerY);
            $radius = $matches->radius;

            $this->circle = new CircleFigure($center, $radius);
        } else {
            throw new BadFormatException();
        }
    }

    public function getCommand(): ?ICommand
    {
        return new AddFigureCommand($this->name, $this->circle);
    }
}
