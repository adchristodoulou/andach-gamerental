@extends('template')

@section('content')
	
	<h2>Products Index</h2>

	<div class="row">
	@foreach ($products as $product)
		{!! $product->box !!}
	@endforeach
	</div>

@endsection