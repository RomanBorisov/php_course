<?php


namespace Scene2d\CommandBuilders;


use Scene2d\Commands\ICommand;
use Scene2d\Commands\DeleteCommand;
use Scene2d\Exceptions\BadFormatException;

class DeleteCommandBuilder implements ICommandBuilder
{
    private static string $recognizeRegex = /** @lang PhpRegExp */
        '/^delete (?P<name>[\w]*)(#.*)?/';

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
        } else {
            throw new BadFormatException('bad format');
        }
    }

    public function getCommand(): ?ICommand
    {
        return new DeleteCommand($this->name);
    }
}
