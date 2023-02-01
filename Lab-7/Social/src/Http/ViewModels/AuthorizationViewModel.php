<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;


class AuthorizationViewModel
{
    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }
}