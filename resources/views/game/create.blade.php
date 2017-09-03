@extends('template')

@section('content')
@if (isset($game))
	{!! Form::model($game, ['route' => ['game.update', $user]]) !!}
@else
	{!! Form::open(['route' => ['game.store']]) !!}
@endif

<div class="form-group">
	{!! Form::label('email', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
	<div class="col-lg-10">
    	{!! Form::email('email', $value = null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
	</div>
</div>
{!! Form::close() !!}