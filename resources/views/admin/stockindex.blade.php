@extends('template')

@section('content')
	@include('admin.menu')

	<div class="row">
		<div class="col-1">ID</div>
		<div class="col-2">Game</div>
		<div class="col-2">System</div>
		<div class="col-1">Date Purchased</div>
		<div class="col-1">Price</div>
		<div class="col-2">In Stock?</div>
		<div class="col-2">Retired?</div>
		<div class="col-1">Times Rented</div>
	</div>

	@foreach ($stocks as $stock)
		<div class="row">
			<div class="col-1">{{ $stock->id }}</div>
			<div class="col-2"><a href="{{ route('game.edit', $stock->game_id) }}">{{ $stock->game->name }}</a></div>
			<div class="col-2">{{ $stock->game->system->name }}</div>
			<div class="col-1">{{ $stock->date_purchased }}</div>
			<div class="col-1">{{ $stock->purchase_price_formatted }}</div>
			<div class="col-2">{{ $stock->currently_in_stock }}</div>
			<div class="col-2">
				@if ($stock->date_retired)
					{{ $stock->date_retired }}<br />{{ $stock->retirementReason->name }}
				@endif
			</div>
			<div class="col-1">{{ $stock->times_rented }}</div>
		</div>
	@endforeach

@endsection