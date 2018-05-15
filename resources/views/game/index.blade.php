@php ($i = 0)
@php ($closedFinalRow = 0)

@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', 'Game Search') }}
@endsection

@section('content')
	
	<h2>Games Index</h2>

	{!! Form::open(['route' => 'game.search', 'method' => 'GET']) !!}
	<div class="row">
		<div class="col-3 col-md-2">Name:</div>
		<div class="col-9 col-md-4">{{ Form::text('name', null, ['class' => 'form-control']) }}</div>
		<div class="col-3 col-md-2">System:</div>
		<div class="col-9 col-md-4">{{ Form::select('system_id', $systems, null, ['class' => 'form-control', 'placeholder' => '']) }}</div>
	</div>
	<div class="row">
		<div class="col-3 col-md-2">Only Available?</div>
		<div class="col-9 col-md-4">{{ Form::checkbox('num_available', 1, null, ['class' => 'form-control']) }}</div>
		<div class="col-3 col-md-2">Genre:</div>
		<div class="col-9 col-md-4">{{ Form::select('genre_id', $genres, null, ['class' => 'form-control', 'placeholder' => '']) }}</div>
	</div>
	<div class="row">
		<div class="col-3 col-md-2">Only Premium?</div>
		<div class="col-9 col-md-4">{{ Form::select('is_premium', $premium, null, ['class' => 'form-control', 'placeholder' => '']) }}</div>
		<div class="col-3 col-md-2">Rating:</div>
		<div class="col-9 col-md-4">{{ Form::select('rating_id', $ratings, null, ['class' => 'form-control', 'placeholder' => '']) }}</div>
	</div>
	<div class="row">
		<div class="col-12">{{ Form::submit('Search Games', ['class' => 'form-control btn btn-primary']) }}</div>
	</div>
	{!! Form::close() !!}

	@foreach ($games as $game)

		@if (++$i % 4 == 1)
			<div class="row">
			@php ($closedFinalRow = 0)
		@endif

		{!! $game->box !!}

		@if ($i % 4 == 0)
			</div>
			@php ($closedFinalRow = 1)
		@endif

	@endforeach

	@if ($closedFinalRow == 0)
	</div>
	@endif

	<div class="row">
		<div class="col-12 text-center">
			{{ $games->appends(request()->except('page'))->links() }}
		</div>
	</div>

@endsection