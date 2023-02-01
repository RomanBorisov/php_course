<?php
/** @var \App\ViewModels\CreateSongPageViewModel $model */ ?>
<html lang="en">
<h4>Add new song</h4>

<form action="{{route('songs.create')}}" method="POST">
    <label>Title: <input type="text" name="title"></label>
    <br>
    Duration:
    <input id='h' name='h' type='number' min='0' max='24'>
    <label for='h'>h</label>
    <input id='m' name='m' type='number' min='0' max='59'>
    <label for='m'>m</label>
    <input id='s' name='s' type='number' min='0' max='59'>
    <label for='s'>s</label>
    <br>
    Album id: <input type="number" disabled id="albumId" name="albumId" value="{{$model->id}}">

    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    @error('h')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    @error('m')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    @error('s')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <input type="submit" name="submit" value="Add">
</form>
</html>
