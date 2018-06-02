@extends('template')

@section('content')
	@include('user.menu')

	<h2>My Current Subscription</h2>
	@if(!$user->isSubscribed())
		<div class="row">
			<div class="col-12">You are not currently subscribed.</div>
		</div>
	@else

		@if ($user->isChangingPlan())
		<div class="row">
			<div class="col-12 alert alert-warning">You are changing plans. Your current subscription to {{ $user->currentPlan()->name }} will end on {{ $user->currentSubscription()->ends_at }} and your new plan {{ $user->upcomingPlan()->name }} will start the day after.</div>
		</div>
		@elseif ($user->isSubscribedOnGracePeriod())
		<div class="row">
			<div class="col-12 alert alert-warning">You are on your grace period. Your subscription will end on {{ $user->currentSubscription()->ends_at }}</div>
		</div>
		@endif

		{!! $user->currentPlan()->box !!}

		@if ($user->isChangingPlan())
			{{ Form::open(['route' => 'user.resumesubscription', 'method' => 'POST']) }}
			<div class="row">
				<div class="col-12">{{ Form::submit('Cancel Downgrade and Continue on Current Plan ('.$user->currentPlan()->name.')', ['class' => 'form-control btn btn-success']) }}</div>
			</div>
			{{ Form::close() }}
		@elseif ($user->isSubscribedOnGracePeriod())
			{{ Form::open(['route' => 'user.resumesubscription', 'method' => 'POST']) }}
			<div class="row">
				<div class="col-12">{{ Form::submit('Uncancel Subscription', ['class' => 'form-control btn btn-success']) }}</div>
			</div>
			{{ Form::close() }}
		@else
			{{ Form::open(['route' => 'user.cancelsubscription', 'method' => 'POST']) }}
			<div class="row">
				<div class="col-12">{{ Form::submit('Cancel Subscription', ['class' => 'form-control btn btn-danger']) }}</div>
			</div>
			{{ Form::close() }}
		@endif
	@endif

@endsection