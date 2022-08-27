@extends('main.template.main')

@section('content')

<router-view :auth-user='@json(Auth::user())'></router-view>
<audio-player></audio-player>

@endsection
