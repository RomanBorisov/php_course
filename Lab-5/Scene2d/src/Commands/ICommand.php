<?php

declare(strict_types=1);

namespace Scene2d\Commands;

use Scene2d\Scene;

interface ICommand
{
    public function apply(Scene $scene): void;

    public function friendlyResultMessage(): string;
}
