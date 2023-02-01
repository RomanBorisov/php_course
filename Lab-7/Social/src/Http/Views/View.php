<?php

declare(strict_types=1);

namespace Social\Http\Views;

use InvalidArgumentException;
use stdClass;

abstract class View
{
    public ?object $model;
    private string $name;

    public function __construct(?object $model, string $name)
    {
        if (!$this->viewExists($name)) {
            throw new InvalidArgumentException("View '{$name}' not found");
        }

        $this->model = $model;
        $this->name = $name;
    }

    public function render(): void
    {
        $model = $this->model ?? new stdClass();

        include $this->getPathToView($this->name);
    }

    private function viewExists(string $name): bool
    {
        return file_exists($this->getPathToView($name));
    }

    private function getPathToView(string $name): string
    {
        return "views/{$name}.php";
    }
}