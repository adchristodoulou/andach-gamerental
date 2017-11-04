@extends('template')

@section('content')
	@include('user.menu')
	
	<h2>Cancel Subscription</h2>
	<p>Are you sure you want to cancel your subscription?</p>
	{{ Form::open(['route' => 'user.cancelsubscription', 'method' => 'POST']) }}
	<div class="row">
		<div class="col-12">
			{{ Form::hidden('confirm', 1) }}
			{{ Form::submit('Yes, I am sure. Cancel my Subscription', ['class', 'form-control btn btn-danger']) }}
		</div>
	</div>
	{{ Form::close() }}

@endsection