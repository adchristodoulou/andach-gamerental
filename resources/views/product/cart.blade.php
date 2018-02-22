@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', 'Cart') }}
@endsection

@section('meta-description')
Purchase video games and video game accessories from Andach Game Rentals, great prices and availability!
@endsection

@section('title')
Purchase Video Games and Accessories | Andach Game Rentals | Video Games
@endsection

@section('content')
	
	<h2>Cart (Step 1 of 4)</h2>

	@if (count($cartLines))

		{!! Form::open(['route' => 'product.cartpost', 'method' => 'POST']) !!}

		<div class="row">
			<div class="col-6">Product</div>
			<div class="col-2">Quantity</div>
			<div class="col-2">Price</div>
			<div class="col-2">Total</div>
		</div>

		@foreach ($cartLines as $line)
			{!! $line->box !!}
		@endforeach

		<div class="row">
			<div class="col-6"></div>
			<div class="col-2">{{ Form::submit('Update Quantities', ['class' => 'form-control btn btn-warning'])}}</div>
			<div class="col-2">Subtotal:</div>
			<div class="col-2">&pound;{{ $prices['lines'] }}</div>
		</div>
		<div class="row">
			<div class="col-8"></div>
			<div class="col-2">Delivery:</div>
			<div class="col-2">&pound;{{ $prices['shipping'] }}</div>
		</div>
		<div class="row">
			<div class="col-8"></div>
			<div class="col-2">Grand Total:</div>
			<div class="col-2">&pound;{{ $prices['total'] }}</div>
		</div>
		{!! Form::close() !!}

		<div class="row">
			<div class="col-8"></div>
			<div class="col-4"><a href="{{ route('product.cart2') }}">
				{{ Form::submit('>> Buy Now!', ['class' => 'form-control btn btn-success']) }}
			</a></div>
		</div>

	@else
		<div class="row">
			<div class="col-12">
				Your cart is empty. 
			</div>
		</div>
	@endif


@endsection