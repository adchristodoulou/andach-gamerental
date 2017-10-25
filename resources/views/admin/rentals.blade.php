@extends('template')

@section('content')
	@include('admin.menu')
	<h2>Currently Rented Games - Mark as Received</h2>

	<div class="row">
		<div class="col-2">Game</div>
		<div class="col-3">User</div>
		<div class="col-3">Date Assigned</div>
		<div class="col-2">Date Delivered</div>
	</div>

	{!! Form::open(['route' => 'admin.rentalsupdate', 'method' => 'POST']) !!}
	@foreach ($rentals as $rental)
		<div class="row">
			<div class="col-2">{{ $rental->game->name }}</div>
			<div class="col-3">{{ $rental->user->name }}</div>
			<div class="col-3">{{ $rental->date_of_assignment }}</div>
			<div class="col-3">
				@if ($rental->date_of_delivery)
					{{ $rental->date_of_delivery }}
				@else
					
				@endif
			</div>
			<div class="col-1">
				@if ($rental->date_of_delivery)
					{{ Form::checkbox('rentals[]', $rental->id) }}
				@else
					N/A
				@endif
			</div>
		</div>
	@endforeach

	<div class="row">
		<div class="col-12">{{ Form::submit('Indicate Checked Rentals have been Received') }}</div>
	</div>
	{!! Form::close() !!}
@endsection