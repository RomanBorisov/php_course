<?php

declare(strict_types=1);

namespace Scene2d\CommandBuilders;

use Scene2d\Commands\ICommand;

interface ICommandBuilder
{
    public function isCommandReady(): bool;

    public function appendLine(string $line): void;

    public function getCommand(): ?ICommand;
}
