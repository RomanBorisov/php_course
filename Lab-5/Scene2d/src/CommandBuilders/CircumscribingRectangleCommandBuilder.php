<?php


namespace Scene2d\CommandBuilders;


use Scene2d\Commands\ICommand;
use Scene2d\Commands\CircumscribingRectangleCommand;

class CircumscribingRectangleCommandBuilder implements ICommandBuilder
{
    private static string $recognizeRegex = /** @lang PhpRegExp */
        "/^print circumscribing rectangle for (?P<name>[\w]*)(#.*)?/";

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
        }
    }

    public function getCommand(): ?ICommand
    {
        return new CircumscribingRectangleCommand($this->name);
    }
}
