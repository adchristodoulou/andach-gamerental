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
	@if (count($user->currentSubscription) > 1)
		<div class="row">
			<div class="col-12 alert alert-danger">You appear to have two active subscriptions. This shouldn't happen and may result in you being charged twice. Please contact us to remedy this.</div>
		</div>
	@elseif(count($user->currentSubscription) == 0)
		<div class="row">
			<div class="col-12 alert alert-warning">You are not crrently subscribed.</div>
		</div>
	@endif

	@foreach ($user->currentSubscription as $sub)
		@if ($user->subscription('main')->onGracePeriod())
		<div class="row">
			<div class="col-12 alert alert-warning">You are on your grace period.</div>
		</div>
		@endif
		<div class="row">
			<div class="col-12">{{ $sub->plan->name }}</div>
		</div>
		<div class="row">
			<div class="col-12">{{ $sub->plan->description }}</div>
		</div>
		<div class="row">
			<div class="col-2">{{ $sub->plan->max_games_simultaneously }}</div>
			<div class="col-10">Simultaneous Games</div>
		</div>
		<div class="row">
			<div class="col-2">@if ($sub->plan->is_premium) Yes @else No @endif</div>
			<div class="col-10">Premium Games Included</div>
		</div>
		<div class="row">
			<div class="col-2">@if ($sub->plan->is_priority) Yes @else No @endif</div>
			<div class="col-10">Priority Service</div>
		</div>

		@if ($user->subscription('main')->onGracePeriod())
			{{ Form::open(['route' => 'user.resumesubscription', 'method' => 'POST']) }}
			<div class="row">
				<div class="col-12">{{ Form::submit('Uncancel Subscription', ['class', 'form-control btn btn-danger']) }}</div>
			</div>
			{{ Form::close() }}
		@else
			{{ Form::open(['route' => 'user.cancelsubscription', 'method' => 'POST']) }}
			<div class="row">
				<div class="col-12">{{ Form::submit('Cancel Subscription', ['class', 'form-control btn btn-danger']) }}</div>
			</div>
			{{ Form::close() }}
		@endif
	@endforeach

@endsection