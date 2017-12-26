@extends('template')

@section('content')
	@include('user.menu')

	<h2>Invoice Show</h2>

	<div class="row">
		<div class="col-12 col-md-4">
			<div class="card">
				<div class="card-header"><b>Invoice Information:</b></div>
				<div class="card-body">{!! $invoice->formatted_user_info !!}</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="card">
				<div class="card-header"><b>Shipping Address:</b></div>
				<div class="card-body">{!! $invoice->formatted_shipping_address !!}</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="card">
				<div class="card-header"><b>Billing Address:</b></div>
				<div class="card-body">{!! $invoice->formatted_billing_address !!}</div>
			</div>
		</div>
	</div>

	<h2>Invoice Lines</h2>
	<div class="row">
		<div class="col-1">Qty</div>
		<div class="col-7">Product</div>
		<div class="col-2">Net</div>
		<div class="col-2">Price with VAT</div>
	</div>
	@foreach ($invoice->lines as $line)
		{!! $line->box !!}
	@endforeach
	<div class="row">
		<div class="col-8"></div>
		<div class="col-2">Subtotal:</div>
		<div class="col-2">{{ $invoice->lines_gross }}</div>
	</div>
	<div class="row">
		<div class="col-8"></div>
		<div class="col-2">Shipping:</div>
		<div class="col-2">{{ $invoice->shipping_gross }}</div>
	</div>
	<div class="row">
		<div class="col-8"></div>
		<div class="col-2">Total:</div>
		<div class="col-2">{{ $invoice->gross }}</div>
	</div>

@endsection