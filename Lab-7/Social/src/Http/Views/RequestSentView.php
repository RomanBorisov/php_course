<?php

declare(strict_types=1);

namespace Social\Http\Views;


use Social\Http\ViewModels\RequestSentViewModel;

class RequestSentView extends View
{
    public function __construct(RequestSentViewModel $model)
    {
        parent::__construct($model, 'request-sent');
    }
}