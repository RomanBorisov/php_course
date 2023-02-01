@extends('layouts.app')

@section('content')
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Gender</th>
            <th scope="col">Last visit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>
                    <a href="{{route('users.profile',$user)}}">
                        {{$user->name}}
                    </a>
                </td>
                <td>{{$user->email}}</td>
                <td>{{$user->gender === 0 ? 'Female' : 'Male' }}</td>
                <td>{{$user->is_online ? "Online" : $user->last_visit->diffForHumans()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
