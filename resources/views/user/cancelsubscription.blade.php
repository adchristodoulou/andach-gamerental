@extends('template')

@section('content')

	<h2>Cancel Subscription</h2>
	<div class="row">
		<div class="col-12 alert alert-danger">Are you sure you want to cancel your subscription?</div>
	</div>
	{{ Form::open(['route' => 'user.cancelsubscription', 'method' => 'POST']) }}
	{{ Form::hidden('confirm', 1) }}
	<div class="row">
		<div class="col-12">{{ Form::submit('Cancel Subscription', ['class', 'form-control btn btn-danger']) }}</div>
	</div>
	{{ Form::close() }}


@endsection