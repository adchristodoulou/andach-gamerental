@extends('template')

@section('content')
	@include('admin.menu')

	{!! Form::open(['route' => 'admin.users', 'method' => 'POST']) !!}
	<div class="row">
		{!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('name', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('Email', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('email', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('shipping_postcode', 'Shipping Postcode:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('shipping_postcode', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('billing_postcode', 'Billing Postcode:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('billing_postcode', null, ['class' => 'form-control']) !!}
		</div>
	</div>


	<div class="row">
		<div class="col-12">
	    	{!! Form::submit('Search Users', ['class' => 'form-control']) !!}
		</div>
	</div>

	@if (count($users))
		<h2>Users Listing</h2>
		<div class="row">
			<div class="col-1">ID</div>
			<div class="col-2">Name</div>
			<div class="col-4">Email</div>
			<div class="col-2">Phone</div>
			<div class="col-3">Current Plan</div>
		</div>
		@foreach ($users as $user)
			<div class="row">
				<div class="col-1"><a href="{{ route('user.edit', $user->id) }}">{{ $user->id }}</a></div>
				<div class="col-2"><a href="{{ route('user.edit', $user->id) }}">{{ $user->name }}</a></div>
				<div class="col-4"><a href="{{ route('user.edit', $user->id) }}">{{ $user->email }}</a></div>
				<div class="col-2">{{ $user->telephone }}</div>
				<div class="col-3">PLAn</div>
			</div>
		@endforeach
	@endif

	{!! Form::close() !!}

@endsection