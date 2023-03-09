@extends('layouts.auth')

@section('content')
    <form method="post" action="{{ route('logOut') }}">
        @auth
            @csrf
            @method('DELETE')
            <button type="submit">Log out</button>
        @endauth
    </form>
@endsection
