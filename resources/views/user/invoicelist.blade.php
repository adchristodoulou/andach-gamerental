@extends('template')

@section('content')
	@include('user.menu')

	<h2>Invoice List</h2>

	<div class="row">
		<div class="col-2">Invoice #</div>
		<div class="col-2">Date</div>
		<div class="col-2">Date Shipped</div>
		<div class="col-2">Net</div>
		<div class="col-2">VAT</div>
		<div class="col-2">Total</div>
	</div>
	
	@foreach ($invoices as $invoice)
		<div class="row">
			<div class="col-2"><a href="{{ route('user.invoiceshow', $invoice->id) }}">{{ $invoice->id }} (show)</a></div>
			<div class="col-2">{{ $invoice->date_of_invoice }}</div>
			<div class="col-2">{{ $invoice->date_of_shipping }}</div>
			<div class="col-2">{{ $invoice->net }}</div>
			<div class="col-2">{{ $invoice->vat }}</div>
			<div class="col-2">{{ $invoice->gross }}</div>
		</div>
	@endforeach

@endsection