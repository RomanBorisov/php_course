@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{ route('users.profile', $user) }}">Back</a>
        @include('inc.alerts')

        @if($user->id === auth()->id())
            @if($myRequests->count())
                <div class="container border">
                    <h3 class="border-bottom border-gray pb-2 mb-0 text-center">My sent friend
                        requests: {{$myRequests->count()}}</h3>

                    @foreach($myRequests as $request)

                        <div class="media text-muted pt-3">
                            <img data-src="holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1"
                                 alt="32x32"
                                 class="mr-2 rounded"
                                 src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17894dbbf93%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17894dbbf93%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.828125%22%20y%3D%2216.965625%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                                 data-holder-rendered="true" style="width: 32px; height: 32px;">
                            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <a href="{{route('users.profile', $request->recipient)}}">
                                        <strong class="text-gray-dark">{{ $request->recipient->name}}</strong>
                                    </a>
                                </div>
                                <span class="d-block">
                                    {{ $request->recipient->is_online ? "Online" : 'last seen: '. $request->recipient->last_visit->diffForHumans()}}
                                </span>
                            </div>
                            <form
                                action="{{ route('friends.request.cancel', ['request' => $request->id,'user'=> auth()->user()]) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger m-2"
                                        name="send-request">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        @if($user->id === auth()->id())
            @if($requests->count())
                <div class="container border">
                    <h3 class="border-bottom border-gray pb-2 mb-0 text-center">
                        Subscribers: {{$requests->count()}}
                    </h3>

                    @foreach($requests as $request)

                        <div class="media text-muted pt-3">
                            <img data-src="holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1"
                                 alt="32x32"
                                 class="mr-2 rounded"
                                 src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17894dbbf93%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17894dbbf93%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.828125%22%20y%3D%2216.965625%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                                 data-holder-rendered="true" style="width: 32px; height: 32px;">
                            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <a href="{{route('users.profile', $request->sender)}}">
                                        <strong class="text-gray-dark">{{ $request->sender->name}}</strong>
                                    </a>
                                </div>
                                <span class="d-block">
                                    {{ $request->sender->is_online ? "Online" : 'last seen: '. $request->sender->last_visit->diffForHumans()}}
                                </span>
                            </div>
                            <div class="d-flex">
                                <form
                                    action="{{ route('friends.request.accept', ['user'=> auth()->user(),'request' => $request]) }}"
                                    method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success m-2"
                                            name="send-request">
                                        Accept
                                    </button>
                                </form>
                                @if($request->status !== \App\Models\FriendRequestStatus::DECLINED)
                                    <form
                                        action="{{ route('friends.request.decline',  ['user'=> auth()->user(),'request' => $request]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger m-2"
                                                name="send-request">
                                            Decline
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="d-flex">
            <div class="my-3 bg-white rounded box-shadow w-50 mr-4 border">
                <h3 class="border-bottom border-gray pb-2 mb-0 text-center">
                    Friends: {{$friends->count()}}</h3>

                @if($friends->count())
                    @foreach($friends as $friend)
                        <x-friend :friend="$friend"
                                  :user="$user"
                                  :canAddToFriends="$canAddToFriends"></x-friend>
                    @endforeach
                @else
                    {{$user->name}}'s friends list empty
                @endif
            </div>
            <div class="my-3 p-3 bg-white rounded box-shadow w-50 border">
                <h3 class="border-bottom border-gray pb-2 mb-0 text-center">
                    Friends online: {{$friendsOnline->count()}}
                </h3>

                @if($friendsOnline->count())
                    @foreach($friendsOnline as $friend)
                        <x-friend :friend="$friend"
                                  :user="$user"
                                  :canAddToFriends="$canAddToFriends"></x-friend>
                    @endforeach
                @else
                    {{$user->name}}'s online friends list empty
                @endif
            </div>
        </div>
    </div>
@endsection
