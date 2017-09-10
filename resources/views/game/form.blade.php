@extends('template')

@section('content')
	@if (isset($game))
		{!! Form::model($game, ['route' => ['game.update', $game->id], 'files' => true, 'method' => 'PUT']) !!}
	@else
		{!! Form::open(['route' => 'game.store', 'files' => true]) !!}
	@endif

	<h1>Create or Edit a Game</h1>
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
			{{ Form::submit('Add this Game', ['class' => 'form-control']) }}
		</div>
	</div>

	{!! Form::close() !!}

@endsection