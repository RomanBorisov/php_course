@if ($errors->count())
    <div class="col-md-12">
        <div class="alert alert-danger text-center">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    </div>
@endif
@if(Session::get('success'))
    <div class="alert alert-success text-center">
        {{session::get('success')}}
    </div>
@endif
