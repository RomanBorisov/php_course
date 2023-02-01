@extends('layouts.app')

@section('content')
    <div class="container">
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

        @if($posts->count())
            @foreach($posts as $post)
                <x-post :post="$post"></x-post>
            @endforeach
        @else
            <span>There are no posts</span>
        @endif
    </div>

@endsection
