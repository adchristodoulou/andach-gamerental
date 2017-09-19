@extends('template')

@section('content')
	<h2>About Us</h2>
	{!! Form::open(['route' => 'admin.stockupdate', 'method' => 'POST']) !!}

	<div class="row">
		{!! Form::label('game_id', 'Game:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('game_id', $games, null, ['class' => 'form-control', 'placeholder' => '(select a game)']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('stock_movement', 'Stock Movement:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('stock_movement', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('note', 'Note:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('note', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			{{ Form::submit('Update Game Stock', ['class' => 'form-control']) }}
		</div>
	</div>

	{!! Form::close() !!}

@endsection