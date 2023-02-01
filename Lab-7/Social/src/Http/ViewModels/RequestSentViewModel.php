<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;


class RequestSentViewModel
{
    public string $name;
    public ?string $message;

    public function __construct(string $name, ?string $message = null)
    {
        $this->name = $name;
        $this->message = $message;
    }
}