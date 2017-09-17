@extends('template')

@section('content')

	<h2>My Current Wishlist</h2>
	@foreach ($user->wishlistGames as $game)
		{!! $game->wishlist !!}
	@endforeach

@endsection