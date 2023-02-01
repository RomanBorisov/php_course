<?php

declare(strict_types=1);

namespace Social\Http\Views;


class SendRequestView extends View
{
    public function __construct()
    {
        parent::__construct(null, 'send-friend-request');
    }
}