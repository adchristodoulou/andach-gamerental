@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', 'All Game Rental Plans') }}
@endsection

@section('h1')
Video Game Rental Plans from Andach Game Rental
@endsection

@section('title')
Value and Unlimited Video Game Rental Plans | Andach Game Rental
@endsection

@section('content')
<h2>Game Rental Plans</h2>
<p>We have a variety of game rental plans available. All our plans have unlimited games in each month, they just differ in the amount of games you can have at a time, and whether you're on the priority service or not. </p>
<p>Our priority service is for customers who want to play the latest games, or want to pay a little extra to ensure they have their top choices much more of the time. It's simple. The game allocation script runs once for priority customers, fills up all their choices, then runs for non-priority customers. There's no other difference. </p>
<p>This means that the latest games will likely go to priority customers until they've all had the opportunity to play them and sent them back - at which point everybody can have them. But we don't believe in restricting our games artificially so they're available for everybody if nobody else wants them. </p>

@if (!Auth::check())
<p class="alert alert-warning"><b>You aren't logged in:</b> - You can only subscribe to a plan with an account. Either <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>, then come back here to get subscribed and play your new games within days!</p>
@else
	@if(Auth::user()->subscription('main'))
		<p class="alert alert-warning"><b>You are already subscribed to a plan.</b> Please only pay for a new plan here if you want to switch.</p>
	@else
		<p class="alert alert-success">You are currently logged in as <b>{{ Auth::user()->name }}</b> and are not subscribed to a plan. So don't hesitate!</p>
	@endif
@endif

<h2>Pick a Rental Plan</h2>
<div class="row">
	<div class="col-3">Name</div>
	<div class="col-2"># of Games</div>
	<div class="col-2">Priority?</div>
	<div class="col-2">Price per Month</div>
	<div class="col-3">Buy</div>
</div>


<div class="divzebra">
@foreach ($plans as $plan)
<div class="row">
	<div class="col-3">{{ $plan->name }}</div>
	<div class="col-2">{{ $plan->max_games_simultaneously }}</div>
	<div class="col-2">
		@if ($plan->is_priority)
			<img src="/images/template/tick.svg" height="32px">
		@else
			<img src="/images/template/cross.svg" height="32px">
		@endif
	</div>
	<div class="col-2">&pound;{{ number_format($plan->cost, 2) }}</div>
	<div class="col-3">
		<a href="{{ route('plan.show', $plan->slug) }}">
			<button class="btn btn-success">Choose Plan</button></a>
	</div>
</div>
@endforeach
</div>
@endsection