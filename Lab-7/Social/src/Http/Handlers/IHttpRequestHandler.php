<?php

declare(strict_types=1);

namespace Social\Http\Handlers;

use Social\Http\Views\View;

interface IHttpRequestHandler
{
    public function handle(array $requestData): View;
}