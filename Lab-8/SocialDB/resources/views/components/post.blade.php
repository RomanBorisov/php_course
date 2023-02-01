@props(['post' => $post])

<div class="row border p-4">
    <div class="col-sm">
        <a href="{{route('users.profile', $post->user)}}" class="h3" aria-current="true">
            <h4 class="mb-2">{{$post->user->name}}</h4>
        </a>
        <small>{{$post->created_at->diffForHumans()}}</small>
        <p> {{$post->likes->count()}} {{ Str::plural('like',$post->likes->count()) }}</p>
    </div>
    <div class="col-sm">
        <p>{{$post->text}}</p>
    </div>
    <div class="col-sm">
        <div class="float-right d-flex flex-grow-1">
            @if(!$post->likedBy(auth()->user()))
                <form action="{{route('posts.likes', $post ) }}" method="post" class="pr-2">
                    @csrf
                    <button type="submit" class="btn btn-primary">Like</button>
                </form>
            @else
                <form action="{{route('posts.likes', $post ) }}" method="post" class="pr-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Unlike</button>
                </form>
            @endif

            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endcan
        </div>
    </div>
</div>
