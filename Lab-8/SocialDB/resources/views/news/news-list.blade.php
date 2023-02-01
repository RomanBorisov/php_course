@extends('layouts.app')

@section('content')
    <div class="container">
        @if($posts->count())
            <h1 class="h1">News: {{$posts->count()}}</h1>

            @foreach($posts as $post)
                <x-post :post="$post"></x-post>
            @endforeach
        @else
            <span>There are no new posts</span>
        @endif

        <div class="mt-4">
        </div>
    </div>

@endsection
