@extends('template')

@section('content')
	@include('user.menu')

	<h2>My Game Rental History</h2>

	<div class="row">
		<div class="col-2">Date of Rental</div>
		<div class="col-2">Game</div>
		<div class="col-2">System</div>
		<div class="col-2">Date of Return</div>
		<div class="col-2">Returned in Good Condition?</div>
		<div class="col-2">Length of Rental</div>
	</div>
	
	@foreach ($rentals as $rental)
		<div class="row">
			<div class="col-2">{{ $rental->date_of_delivery }}</div>
			<div class="col-2"><a href="{{ route('game.show', $rental->game_id) }}">{{ $rental->game->name }}</a></div>
			<div class="col-2">{{ $rental->game->system->name }}</div>
			<div class="col-2">{{ $rental->date_of_return }}</div>
			<div class="col-2">{{ $rental->returned_ok }}</div>
			<div class="col-2">{{ $rental->length_of_rental }}</div>
		</div>
	@endforeach

@endsection