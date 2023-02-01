<html lang="en">
<h4>Add new album:</h4>

<form action="{{route('albums.create')}}" method="POST">
    <label for="title">Title
        <input type="text" id="title" name="title" class="@error('title') is-invalid @enderror">
    </label>
    <label for="date">Date
        <input type="date" id="date" name="date">
    </label>

    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    @error('date')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <input type="submit" name="submit" value="Add">
</form>
</html>
