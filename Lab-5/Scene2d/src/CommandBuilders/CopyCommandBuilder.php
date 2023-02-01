<?php


namespace Scene2d\CommandBuilders;


use Scene2d\Commands\ICommand;
use Scene2d\Commands\CopyCommand;
use Scene2d\Exceptions\BadFormatException;

class CopyCommandBuilder implements ICommandBuilder
{

    private static string $recognizeRegex = /** @lang PhpRegExp */'/^copy (?P<originalName>[\w]*) to (?P<copyName>[\w]*)(#.*)?/';

    private string $originalName;

    private string $copyName;

    public function isCommandReady(): bool
    {
        return true;
    }

    public function appendLine(string $line): void
    {
        if (preg_match(self::$recognizeRegex, $line, $matches)){
            $matches = (object)$matches;
            $this->originalName = $matches->originalName;
            $this->copyName = $matches->copyName;
        }else{
            throw new BadFormatException('bad format');
        }
    }

    public function getCommand(): ?ICommand
    {
        return new CopyCommand($this->originalName, $this->copyName);
    }
}
