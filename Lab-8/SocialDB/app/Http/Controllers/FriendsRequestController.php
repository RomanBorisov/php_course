<?php

namespace App\Http\Controllers;

use App\DAO\FriendRequestDAO;
use App\DBModels\FriendRequest;
use App\DBModels\User;
use App\Models\FriendRequestStatus;
use Illuminate\Http\RedirectResponse;

class FriendsRequestController extends Controller
{
    /**
     * @var FriendRequestDAO
     */
    public $friendRequestDAO;

    public function __construct(FriendRequestDAO $friendRequestDAO)
    {
        $this->friendRequestDAO = $friendRequestDAO;
    }

    /**
     * @param FriendRequest $request
     * @return RedirectResponse
     */
    public function accept(FriendRequest $request): RedirectResponse
    {
        $this->friendRequestDAO->updateRequestStatus($request->id, FriendRequestStatus::ACCEPTED);
        return back()->with('User added in friend list');
    }

    /**
     * @param FriendRequest $request
     * @return RedirectResponse
     */
    public function decline(FriendRequest $request): RedirectResponse
    {
        $this->friendRequestDAO->updateRequestStatus($request->id, FriendRequestStatus::DECLINED);
        return back();
    }

    /**
     * @param User $user
     * @param int $requestId
     * @return RedirectResponse
     * @throws \Exception
     */
    public function cancel(User $user, int $requestId): RedirectResponse
    {
        $this->friendRequestDAO->removeRequest($requestId);
        return back()->withSuccess('Your request has been canceled');
    }
}
