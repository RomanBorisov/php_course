<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;


use Social\Models\FriendRequestModel;
use Social\Models\UserModel;

class UserInfoViewModel
{
    public string $name;
    public array $friends;
    public array $friendsIsOnline;
    public array $subscribers;
    public array $newFriendRequests;
    public array $newsFeed;

    /**
     * @param UserModel[] $friends
     * @param UserModel[] $friendsIsOnline
     * @param UserModel[] $subscribers
     * @param FriendRequestModel[] $newFriendRequests
     * @param PostViewModel[] $newsFeed
     */
    public function __construct(string $name, array $friends, array $friendsIsOnline, array $subscribers, array $newFriendRequests, array $newsFeed)
    {
        $this->name = $name;
        $this->friends = $friends;
        $this->friendsIsOnline = $friendsIsOnline;
        $this->subscribers = $subscribers;
        $this->newFriendRequests = $newFriendRequests;
        $this->newsFeed = $newsFeed;
    }
}
