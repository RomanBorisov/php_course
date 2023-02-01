@extends('layouts.app')

@section('content')
    @include('inc.alerts')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <div class="image">
                    <img
                        src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80"
                        class="rounded" width="155">
                </div>
                <div class="ml-3 w-100">
                    <h4 class="mb-0 mt-0 ml-2 row">{{$user->name}}</h4>
                    <small class="mb-0 mt-0 ml-2">{{$user->gender === 0 ? 'Female' : 'Male' }}</small>
                    <span class="row ml-2">{{$user->email}}</span>
                    <span
                        class="row ml-2">{{$user->is_online ? "Online" : 'last seen: '.$user->last_visit->diffForHumans()}}</span>
                    <span
                        class="row ml-2">Age: {{\Carbon\Carbon::parse($user->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years')}}</span>
                    <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                        <a href="{{route('friends', $user )}}" class="btn btn-primary">
                            <span>Friends: {{$friends->count()}}</span>
                        </a>
                        <a href="#posts" class="btn btn-primary">
                            <span>Posts: {{$posts->count()}}</span>
                        </a>
                    </div>
                    <div class="button mt-2 d-flex flex-row align-items-center">
                        @if($user->id !== auth()->id())
                            @if(!$friends->contains(auth()->id()))
                                <form action="{{ route('friends.send-request', $user) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary w-100"
                                            name="send-request">
                                        Send friend request
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('friends.remove', $user) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                            name="send-request">
                                        Remove from friends
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <p><a name="posts"></a></p>
        @if(auth()->id() === $user->id)
            <div class="d-flex">
                <form action="{{ route('posts') }}" method="post">
                    @csrf
                    <label>
                    <textarea name="text" cols="300" rows="4"
                              class="form-control @error('text') is-invalid @enderror"
                              placeholder="Post something!"
                    ></textarea>
                    </label>
                    @error('text')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                    <input type="submit" class="btn btn-primary mb-4 mt-4" value="Create">
                </form>
            </div>
        @endif
        @if($posts->count())
            <h3> {{$posts->count()}} {{ Str::plural('post',$posts->count()) }}</h3>
            @foreach($posts as $post)
                <x-post :post="$post"></x-post>
            @endforeach
        @else
            <span>{{$user->name}} does not have any posts</span>
        @endif

@endsection
