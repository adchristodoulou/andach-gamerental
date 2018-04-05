@extends('mail')

@section('content')

<h2>Your game is in the post. </h2>
<p><b>{{ $rental->game->name }} is on its way to you now! You should have it within a day or two. Happy playing!</b>

@endsection