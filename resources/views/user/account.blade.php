@extends('template')

@section('content')

	<h2>My Current Wishlist</h2>
	{!! Form::open(['route' => 'user.accountupdate']) !!}
	<div id="left-defaults" class="dragula-container">
	@foreach ($user->wishlistGames as $game)
		{!! $game->wishlist !!}
	@endforeach
	</div>
	{{ Form::submit('Update my Wishlist Order') }}
	{!! Form::close() !!}

@endsection