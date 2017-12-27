@extends('template')

@section('content')
	@include('user.menu')

	<h2>Invoice #{{ $invoice->id }}</h2>

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
	<table class="table table-hover table-bordered table-sm table-responsive">
		<thead class="thead-default">
			<tr>
				<th>Qty</th>
				<th>Product</th>
				<th>Net</th>
				<th>Price with VAT</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($invoice->lines as $line)
				{!! $line->box !!}
			@endforeach
			<tr>
				<td>&nbsp;</td>
				<td>Subtotal:</td>
				<td class="text-right">{{ $invoice->getFormattedValue('lines_net') }}</td>
				<td class="text-right">{{ $invoice->getFormattedValue('lines_gross') }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Shipping:</td>
				<td class="text-right">{{ $invoice->getFormattedValue('shipping_net') }}</td>
				<td class="text-right">{{ $invoice->getFormattedValue('shipping_gross') }}</td>
			</tr>
			<tr class="table-success">
				<td>&nbsp;</td>
				<td>Total:</td>
				<td class="text-right">{{ $invoice->getFormattedValue('net') }}</td>
				<td class="text-right">{{ $invoice->getFormattedValue('gross') }}</td>
			</tr>
		</tbody>
	</table>

@endsection