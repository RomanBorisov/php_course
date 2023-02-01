<?php /** @var \App\ViewModels\AlbumViewModel $model */ ?>

<html lang="en">
<h4>Album '{{$model->album->title}}', Summary duration: {{$model->duration['hours']}}h, {{$model->duration['minutes']}}
    m, {{$model->duration['seconds']}}s</h4>
<ul>
    @foreach($model->songs as $song)
        <li>
            Id: <strong>{{$song->id}}</strong>,
            Title: <strong>{{$song->title}}</strong>,
            Duration: <strong>{{$song->duration ?? 'None'}}</strong>
            {{--            <a href="{{route('songs.removePage', ['id' => $song->id, 'albumId' => $song->albumId])}}">Remove</a>--}}
            <form action="{{ route('songs.remove', ['id' => $song->id, 'albumId' => $song->albumId]) }}"
                  method="post">
                @method('DELETE')
                @csrf
                <input type="submit" class="btn btn-danger" value="Remove"/>
            </form>
        </li>
    @endforeach
    <a href="{{route('songs.createPage', ['albumId' => $model->album->id])}}">Add new song</a>
</ul>

</html>
