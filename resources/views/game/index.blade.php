@php ($i = 0)

@extends('template')

@section('content')
	
	<h2>Games Index</h2>

	{!! Form::open(['route' => 'game.searchpost', 'method' => 'POST']) !!}
	<div class="row">
		<div class="col-2">Name:</div>
		<div class="col-4">{{ Form::text('name', null, ['class' => 'form-control']) }}</div>
		<div class="col-2">System:</div>
		<div class="col-4">{{ Form::select('system_id', $systems, null, ['class' => 'form-control', 'placeholder' => '']) }}</div>
	</div>
	<div class="row">
		<div class="col-2">Only Available?</div>
		<div class="col-4">{{ Form::checkbox('num_available', 1, null, ['class' => 'form-control']) }}</div>
		<div class="col-2">Category:</div>
		<div class="col-4">{{ Form::select('category_id', $categories, null, ['class' => 'form-control', 'placeholder' => '']) }}</div>
	</div>
	<div class="row">
		<div class="col-2">Only Premium?</div>
		<div class="col-4">{{ Form::select('is_premium', $premium, null, ['class' => 'form-control', 'placeholder' => '']) }}</div>
		<div class="col-2">Rating:</div>
		<div class="col-4">{{ Form::select('rating_id[]', $ratings, null, ['class' => 'form-control', 'placeholder' => '', 'multiple' => 'multiple']) }}</div>
	</div>
	<div class="row">
		<div class="col-12">{{ Form::submit('Search Games', ['class' => 'form-control btn btn-primary']) }}</div>
	</div>
	{!! Form::close() !!}

	@foreach ($games as $game)

		@if (++$i % 4 == 1)
			<div class="row">
		@endif

		{!! $game->box !!}

		@if ($i % 4 == 0)
			</div>
		@endif

	@endforeach

	<div class="row">
		<div class="col-12">
			<div class="text-center">
			{{ $games->links() }}
			</div>
		</div>
	</div>

@endsection