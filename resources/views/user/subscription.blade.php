@extends('template')

@section('content')
	@include('user.menu')

	<h2>My Current Subscription</h2>
	@if(!$user->isSubscribed())
		<div class="row">
			<div class="col-12 alert alert-warning">You are not crrently subscribed.</div>
		</div>
	@endif

	@if ($user->isSubscribedOnGracePeriod())
	<div class="row">
		<div class="col-12 alert alert-warning">You are on your grace period. Your subscription will end on {{ $user->currentSubscription()->ends_at }}</div>
	</div>
	@endif
	<div class="row">
		<div class="col-12">{{ $user->currentPlan()->name }}</div>
	</div>
	<div class="row">
		<div class="col-12">{{ $user->currentPlan()->description }}</div>
	</div>
	<div class="row">
		<div class="col-2">{{ $user->currentPlan()->max_games_simultaneously }}</div>
		<div class="col-10">Simultaneous Games</div>
	</div>
	<div class="row">
		<div class="col-2">@if ($user->currentPlan()->is_premium) Yes @else No @endif</div>
		<div class="col-10">Premium Games Included</div>
	</div>
	<div class="row">
		<div class="col-2">@if ($user->currentPlan()->is_priority) Yes @else No @endif</div>
		<div class="col-10">Priority Service</div>
	</div>

	@if ($user->isSubscribedOnGracePeriod())
		{{ Form::open(['route' => 'user.resumesubscription', 'method' => 'POST']) }}
		<div class="row">
			<div class="col-12">{{ Form::submit('Uncancel Subscription', ['class', 'form-control btn btn-success']) }}</div>
		</div>
		{{ Form::close() }}
	@else
		{{ Form::open(['route' => 'user.cancelsubscription', 'method' => 'POST']) }}
		<div class="row">
			<div class="col-12">{{ Form::submit('Cancel Subscription', ['class', 'form-control btn btn-danger']) }}</div>
		</div>
		{{ Form::close() }}
	@endif

@endsection