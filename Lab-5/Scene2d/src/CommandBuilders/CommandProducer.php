<?php

declare(strict_types=1);

namespace Scene2d\CommandBuilders;

use Scene2d\Commands\ICommand;
use Scene2d\Exceptions\BadFormatException;

class CommandProducer implements ICommandBuilder
{
    /**
     * @var callable[]
     */
    private static array $commands = [];

    private ?ICommandBuilder $currentBuilder = null;

    public function __construct()
    {
        self::$commands = [
            "/^add rectangle .*/" => fn(): ICommandBuilder => new AddRectangleCommandBuilder(),
            "/^add circle .*/" => fn(): ICommandBuilder => new AddCircleCommandBuilder(),
            "/^add polygon .*/" => fn(): ICommandBuilder => new AddPolygonCommandBuilder(),
            "/^move .*/" => fn(): ICommandBuilder => new MoveCommandBuilder(),
            "/^rotate .*/" => fn(): ICommandBuilder => new RotateCommandBuilder(),
            "/^reflect .*/" => fn(): ICommandBuilder => new ReflectCommandBuilder(),
            "/^group .*/" => fn(): ICommandBuilder => new CompositeFigureCommandBuilder(),
            "/^copy .*/" => fn(): ICommandBuilder => new CopyCommandBuilder(),
            "/^delete .*/" => fn(): ICommandBuilder => new DeleteCommandBuilder(),
            "/^print circumscribing rectangle for .*/" => fn() => new CircumscribingRectangleCommandBuilder(),
        ];
    }

    public function isCommandReady(): bool
    {
        if ($this->currentBuilder === null) {
            return false;
        }

        return $this->currentBuilder->isCommandR`eady();
    }

    /**
     * @throws BadFormatException
     */
    public function appendLine(string $line): void
    {
        if ($this->currentBuilder === null) {
            foreach (self::$commands as $regex => $commandFactory) {
                if (preg_match($regex, $line)) {
                    $this->currentBuilder = $commandFactory();

                    break;
                }
            }

            if ($this->currentBuilder === null) {
                throw new BadFormatException();
            }
        }

        $this->currentBuilder->appendLine($line);
    }

    public function getCommand(): ?ICommand
    {
        if ($this->currentBuilder === null) {
            return null;
        }

        $command = $this->currentBuilder->getCommand();
        $this->currentBuilder = null;

        return $command;
    }
}
