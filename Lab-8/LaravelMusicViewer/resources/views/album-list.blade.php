<?php /** @var \App\ViewModels\AlbumListViewModel $model */?>

<html lang="en">
<h4>Albums:</h4>
<ul>
    @foreach($model->albums as $album)
        <li>
            Id: <strong>{{$album->id}}</strong>,
            Title: <strong>{{$album->title}}</strong>,
            Date: <strong>{{$album->date ?? 'None'}}</strong>
            <a href="{{route('albums.get', ['id' => $album->id])}}">Show songs</a>
            <form action="{{ route('albums.remove', ['id' => $album->id])}}" method="post">
                @method('DELETE')
                @csrf
                <input type="submit" value="Delete"/>
            </form>
        </li>
    @endforeach

    <li>
        <a href="{{route('albums.createPage')}}">Add new album</a>
    </li>
</ul>

</html>
