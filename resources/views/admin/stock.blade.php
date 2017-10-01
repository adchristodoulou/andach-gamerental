@extends('template')

@section('content')

	{!! Form::open(['route' => 'admin.stockupdate', 'method' => 'POST']) !!}
	<h2>{{ $game->name }} - Current Stock</h2>
	
	@if (count($game->stock) == 0)
		<div class="row">
			<div class="col-12">There is no stock for this game currently. </div>
		</div>
	@else
		<div class="row">
			<div class="col-1">Retire?</div>
			<div class="col-1">ID</div>
			<div class="col-2">Date Purchased</div>
			<div class="col-2">Date Retired</div>
			<div class="col-2">Retirement Reason</div>
			<div class="col-2">#Times Rented</div>
			<div class="col-2">Purchase Price</div>
		</div>

		@foreach ($game->stock as $stock)
			<div class="row">
				<div class="col-1">{{ Form::checkbox('retire[]', $stock->id) }}</div>
				<div class="col-1">{{ $stock->id }}</div>
				<div class="col-2">{{ $stock->date_purchased }}</div>
				<div class="col-2">{{ $stock->date_retired}}</div>
				<div class="col-2">{{ optional($stock->retirementReason)->name }}</div>
				<div class="col-2">{{ $stock->times_rented }}</div>
				<div class="col-2">{{ $stock->purchase_price_formatted }}</div>
			</div>
		@endforeach
	@endif

	<div class="row">
		{!! Form::label('retirement_reason_id', 'Retirement Reason:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('retirement_reason_id', $reasons, null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-12">
	    	{!! Form::submit('Log Game Purchase') !!}
		</div>
	</div>
	{!! Form::close() !!}

	{!! Form::open(['route' => 'admin.stockupdate', 'method' => 'POST']) !!}
	<h2>Add New Stock</h2>
	<div class="row">
		{!! Form::label('date_purchased', 'Date Purchased (pence as integer):', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::date('date_purchased', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('purchase_price', 'Purchase Price:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('purchase_price', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-12">
	    	{!! Form::submit('Log Game Purchase') !!}
		</div>
	</div>
	

	{!! Form::hidden('game_id', $game->id) !!}
	{!! Form::close() !!}

	

@endsection