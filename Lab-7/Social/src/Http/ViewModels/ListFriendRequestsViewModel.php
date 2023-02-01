<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;


use Social\Models\FriendRequestModel;

class ListFriendRequestsViewModel
{
    /** @var FriendRequestModel[] */
    public array $requests;

    /**
     * @param FriendRequestModel[] $requests
     */
    public function __construct(array $requests)
    {
        $this->requests = $requests;
    }
}
