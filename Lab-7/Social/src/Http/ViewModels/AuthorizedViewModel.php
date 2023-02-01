<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;


class AuthorizedViewModel
{
    public string $name;
    public ?int $id;
    public ?string $message;

    public function __construct(string $name, ?int $id = null, ?string $message = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->message = $message;
    }
}