@extends('main.template.main')

@section('content')
    <router-view :auth-user='@json(Auth::user())'></router-view>
    <audio-player :auth-user='@json(Auth::user())'></audio-player>
    <player-tray />
@endsection
