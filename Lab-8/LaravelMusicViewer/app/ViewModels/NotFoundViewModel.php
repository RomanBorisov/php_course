<?php

declare(strict_types=1);

namespace App\ViewModels;

class NotFoundViewModel
{
    public string $returnUrl;

    public function __construct(string $returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }
}
