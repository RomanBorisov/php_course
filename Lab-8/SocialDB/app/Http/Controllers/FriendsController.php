<?php

namespace App\Http\Controllers;

use App\DAO\FriendRequestDAO;
use App\DBModels\FriendRequest;
use App\DBModels\User;
use App\Models\FriendRequestStatus;
use App\Services\FriendsService;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FriendsController extends Controller
{
    /**
     * @var FriendsService
     */
    public $friendsService;
    /**
     * @var Factory
     */
    public $authFactory;
    /**
     * @var FriendRequestDAO
     */
    public $friendRequestDAO;

    public function __construct(FriendsService $friendsService, Factory $factory, FriendRequestDAO $friendRequestDAO)
    {
        $this->friendsService = $friendsService;
        $this->authFactory = $factory->guard();
        $this->friendRequestDAO = $friendRequestDAO;
    }

    /**
     * @param User $user
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(User $user)
    {
        $friends = $this->friendsService->getFriends($user->id);
        $friendsOnline = $this->friendsService->getOnlineFriends($friends);
        $currentUserRequests = $this->friendRequestDAO->getUserRequests($this->authFactory->id());
        $subscribers = $this->friendRequestDAO->getUserSubscribers($this->authFactory->id());
        return view('friends.friends-list', [
            'friends' => $friends,
            'friendsOnline' => $friendsOnline,
            'requests' => $subscribers,
            'myRequests' => $currentUserRequests,
            'user' => $user,
            'canAddToFriends' => $this->canAddToFriends($user->id, $friends)
        ]);
    }

    public function canAddToFriends(int $userId, $friends): bool
    {
        return !$friends->contains($this->authFactory->id()) && $userId !== $this->authFactory->id();
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function store(User $user): RedirectResponse
    {
        $sameRequest = $this->friendRequestDAO->getRequestByParticipants($this->authFactory->id(), $user->id);

        if ($sameRequest !== null) {
            return back()->withErrors('You have already sent a request to this person! Wait for him to accept or reject it.');
        }

        $request = new FriendRequest();
        $request->user_id_from = $this->authFactory->id();
        $request->user_id_to = $user->id;
        $request->status = FriendRequestStatus::SENT;
        $request->save();

        return back()->withSuccess('Request has been sended');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->friendRequestDAO->removeFromFriends($user->id);
        return back()->withSuccess('User has been removed from friends');
    }
}
