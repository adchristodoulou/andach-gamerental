@extends('template')

@section('content')
	@include('admin.menu')
	@if (isset($game))
		{!! Form::model($game, ['route' => ['game.update', $game->id], 'files' => true, 'method' => 'PUT']) !!}
	@else
		{!! Form::open(['route' => 'game.store', 'files' => true]) !!}
	@endif

	<h2>Create or Edit Game</h2>
	<div class="row">
		{!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('name', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('system_id', 'System:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('system_id', $systems, null, ['class' => 'form-control', 'placeholder' => '(please select a system)']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('gamesdb_id', 'ID from The Games DB:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('gamesdb_id', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('rating_id', 'Rating:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('rating_id', $ratings, null, ['class' => 'form-control', 'placeholder' => '(please select a rating)']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('category_id', 'Category:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'placeholder' => '(please select a category)']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('release_date', 'Release Date:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::date('release_date', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('max_gamerscore', 'Max Gamerscore:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('max_gamerscore', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('xbox_id', 'Xbox ID:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('xbox_id', null, ['class' => 'form-control']) !!}
		</div>
	</div>


	<div class="row">
		{!! Form::label('is_premium', 'Is Premium?', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::checkbox('is_premium', 1, null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('description', 'Description:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::textarea('description', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('picture', 'Upload Picture:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::file('picture', ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			{{ Form::submit('Add this Game', ['class' => 'form-control btn btn-success']) }}
		</div>
	</div>

	{!! Form::close() !!}

	@if (isset($game))
		<h2>Stock Information</h2>
		<p>There are <b>{{ $game->num_in_stock }}</b> copies of this game in stock, of which <b>{{ $game->num_on_rental }}</b> are on rental, leaving <b>{{ $game->num_available }}</b> available. </p>

		<p><a href="{{ route('admin.stock', $game->id) }}">Update Stock for this Game</a></p>
	@endif

@endsection