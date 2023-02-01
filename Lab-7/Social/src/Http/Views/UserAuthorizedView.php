<?php

declare(strict_types=1);

namespace Social\Http\Views;


use Social\Http\ViewModels\AuthorizedViewModel;

class UserAuthorizedView extends View
{
 public function __construct(AuthorizedViewModel $model)
 {
     parent::__construct($model, 'user-authorized');
 }
}