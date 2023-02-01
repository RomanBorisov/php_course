<?php


namespace Scene2d\CommandBuilders;

use Scene2d\Commands\CompositeFigureCommand;
use Scene2d\Commands\ICommand;
use Scene2d\Exceptions\BadFormatException;


class CompositeFigureCommandBuilder implements ICommandBuilder
{
    private static string $recognizeRegex = /** @lang PhpRegExp */
        "/^group (?P<names>([\w]*,?\s?){2,}) as (?P<groupName>[\w]*)(#.*)?/";

    private string $groupName;

    private array $figureNames;

    public function isCommandReady(): bool
    {
        return true;
    }

    public function appendLine(string $line): void
    {
        if (preg_match(self::$recognizeRegex, $line, $matches)) {
            $matches = (object)$matches;
            $childFigures = preg_split('/[\n\r\s,]+/', $matches->names, -1);
            $this->figureNames = $childFigures;
            $this->groupName = $matches->groupName;

        } else {
            throw new BadFormatException('bad format');
        }
    }

    public function getCommand(): ?ICommand
    {
        return new CompositeFigureCommand($this->groupName, $this->figureNames);
    }
}
