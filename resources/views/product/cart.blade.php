@php ($i = 0)
@php ($closedFinalRow = 0)

@extends('template')

@section('content')
	
	<h2>Cart Index</h2>

	<div class="row">
		<div class="col-6">Product</div>
		<div class="col-2">Quantity</div>
		<div class="col-2">Price</div>
		<div class="col-2">Total</div>
	</div>
	@foreach ($cartLines as $line)
		{!! $line->box !!}
	@endforeach

@endsection