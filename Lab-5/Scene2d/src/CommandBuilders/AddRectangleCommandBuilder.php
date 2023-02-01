<?php

declare(strict_types=1);

namespace Scene2d\CommandBuilders;

use Scene2d\Commands\AddFigureCommand;
use Scene2d\Commands\ICommand;
use Scene2d\Exceptions\BadFormatException;
use Scene2d\Figures\IFigure;
use Scene2d\Figures\RectangleFigure;
use Scene2d\Models\ScenePoint;

class AddRectangleCommandBuilder implements ICommandBuilder
{
    private static string $recognizeRegex = '/^add rectangle (?P<name>[\w]*) \((?P<p1x>-?\d+),\s*(?P<p1y>-?\d+)\) \((?P<p2x>-?\d+),\s*(?P<p2y>-?\d+)\)/';

    private ?IFigure $rectangle = null;
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
            $p1 = new ScenePoint((float)$matches->p1x, (float)$matches->p1y);
            $p2 = new ScenePoint((float)$matches->p2x, (float)$matches->p2y);

            $this->rectangle = new RectangleFigure($p1, $p2);
        } else {
            throw new BadFormatException();
        }
    }

    public function getCommand(): ?ICommand
    {
        return new AddFigureCommand($this->name, $this->rectangle);
    }
}
