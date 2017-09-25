@extends('template')

@section('content')

	<ul class="nav nav-pills nav-justified">
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('user.account') }}">Wishlist</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link active" href="{{ route('user.subscription') }}">Subscriptions</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('user.history') }}">Game Rental History</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link disabled" href="#">Disabled</a>
	  </li>
	</ul>

	<h2>My Current Subscription</h2>
	{{ print_r($user->currentSubscription) }}

@endsection