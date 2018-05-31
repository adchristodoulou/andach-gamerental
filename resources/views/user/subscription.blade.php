@extends('template')

@section('content')
	@include('user.menu')

	<h2>My Current Subscription</h2>
	@if(!$user->isSubscribed())
		<div class="row">
			<div class="col-12 alert alert-warning">You are not currently subscribed.</div>
		</div>
	@endif

	@if ($user->isSubscribedOnGracePeriod())
	<div class="row">
		<div class="col-12 alert alert-warning">You are on your grace period. Your subscription will end on {{ $user->currentSubscription()->ends_at }}</div>
	</div>
	@endif

	{!! $user->currentPlan()->box !!}

	@if ($user->isSubscribedOnGracePeriod())
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

@endsection