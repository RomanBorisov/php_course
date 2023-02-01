<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;

class PostCreatedViewModel
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}