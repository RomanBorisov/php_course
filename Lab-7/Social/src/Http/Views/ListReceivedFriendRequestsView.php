<?php

declare(strict_types=1);

namespace Social\Http\Views;


use Social\Http\ViewModels\ListFriendRequestsViewModel;

class ListReceivedFriendRequestsView extends View
{
    public function __construct(ListFriendRequestsViewModel $model)
    {
        parent::__construct($model, 'list-received-friend-requests');
    }
}