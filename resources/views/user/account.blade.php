@extends('template')

@section('content')

	<ul class="nav nav-pills nav-justified">
	  <li class="nav-item">
	    <a class="nav-link active" href="{{ route('user.account') }}">Wishlist</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('user.subscription') }}">Subscriptions</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('user.history') }}">Game Rental History</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link disabled" href="#">Disabled</a>
	  </li>
	</ul>

	<h2>My Current Wishlist</h2>
	{!! Form::open(['route' => 'user.accountupdate']) !!}
	<div id="left-defaults" class="dragula-container">
	@foreach ($user->wishlistGames as $game)
		{!! $game->wishlist !!}
	@endforeach
	</div>
	{{ Form::submit('Update my Wishlist Order') }}
	{!! Form::close() !!}

	<h2>My Current Subscription</h2>
	{{ print_r($user->currentSubscription) }}

@endsection