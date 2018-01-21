@extends('template')

@section('content')
	@include('admin.menu')

	{!! Form::open(['route' => 'admin.competitorspost', 'method' => 'POST']) !!}
	<h2>Competitors Index</h2>
	<p><i>Note: Directly edit competitors using the mySQL database.</i></p>

	<h2>View All Listings</h2>
	@foreach ($competitors as $c)
		<div class="row"><div class="col-12"><b>{{ $c->name }}</b></div></div>

		@foreach ($c->listings as $l)
			<div class="row">
				<div class="col-1">{{ Form::checkbox('listingUpdate[]', $l->id) }}</div>
				<div class="col-4">{{ $l->game_name }}</div>
				<div class="col-3">{{ $l->product_name }}</div>
				<div class="col-1">{{ $l->latest_price_new_format }}</div>
				<div class="col-1">{{ $l->latest_price_preown_format }}</div>
				<div class="col-1">{{ $l->latest_price_buy_format }}</div>
				<div class="col-1">{{ $l->latest_price_voucher_format }}</div>
			</div>
		@endforeach
	@endforeach

	<h2>Add a Listing</h2>
	<div class="row">
		{!! Form::label('competitor_id', 'Competitor:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('competitor_id', $competitors->pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => '-- please select a competitor --']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('product_id', 'Product:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('product_id', $products, null, ['class' => 'form-control', 'placeholder' => '-- please select a product --']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('game_id', 'Game:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('game_id', $games, null, ['class' => 'form-control', 'placeholder' => '-- please select a game --']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('url_new', 'New URL:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('url_new', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('url_preown', 'Preown URL:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('url_preown', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('url_buy', 'Buy URL:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('url_buy', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('url_voucher', 'Voucher URL:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('url_voucher', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ Form::submit('Add new Listing', ['class' => 'form-control btn btn-success']) }}
		</div>
	</div>
	

	{!! Form::close() !!}

@endsection