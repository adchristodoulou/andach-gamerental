@extends('template')

@section('meta-description')
Address details for video games and video game accessories from Andach Game Rentals, great prices and availability!
@endsection

@section('title')
Address details for Video Games and Accessories | Andach Game Rentals | Video Games
@endsection

@section('content')
	
	<h2>Cart - Personal &amp; Delivery Info (Step 2 of 4)</h2>

	{!! Form::model(Auth::user(), ['route' => 'product.cart3', 'method', 'POST']) !!}

	<div class="alert alert-warning">
		You aren't logged in. If you log in, then all your orders will be saved in the same place and it'll be easier if there is any need to return any goods. 
	</div>

	<div class="row">
		<div class="col-9">
			<div class="card">
				<div class="card-header">Your Details</div>
				<div class="card-body">
					<div class="row">
						{!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('name', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('email', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('email', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('phone', 'Phone:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('phone', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('shipping_address1', 'Address 1:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('shipping_address1', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('shipping_address2', 'Address 2:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('shipping_address2', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('shipping_address3', 'Address 3:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('shipping_address3', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('shipping_town', 'Town:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('shipping_town', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('shipping_county', 'County:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('shipping_county', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('shipping_postcode', 'Postcode:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('shipping_postcode', null, ['class' => 'form-control']) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="card">
				<div class="card-header">Order Summary</div>
				<div class="card-body">
					@foreach ($cartLines as $line)
						{!! $line->box_mini !!}
					@endforeach
				</div>
				<div class="card-footer">Price: &pound;{{ $prices['total'] }}</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">{{ Form::submit('>> Payment Details', ['class' => 'form-control btn btn-success']) }}</div>	
	</div>

	{!! Form::close() !!}

@endsection