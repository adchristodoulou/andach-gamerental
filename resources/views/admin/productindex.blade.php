@extends('template')

@section('content')
	@include('admin.menu')

	{!! Form::open(['route' => 'admin.gameindexpost', 'method' => 'POST']) !!}
	<h2>Admin Game Index</h2>

	<div class="row">
		<div class="col-12">
			<a href="{{ route('admin.productcreate') }}">Click here to create a product.</a>
		</div>
	</div>

	<div class="row">
		<div class="col-3">Image</div>
		<div class="col-4">Product</div>
		<div class="col-3">Price</div>
		<div class="col-2">Last Updated</div>
	</div>

	@foreach ($products as $product)
		<div class="row">
			<div class="col-3">
				{!! $product->thumb_img !!}
			</div>
			<div class="col-4">
				<a href="{{ route('admin.productedit', $product->id) }}">{{ $product->name }}</a>
			</div>
			<div class="col-3">
				{{ $product->price_format }}
			</div>
			<div class="col-2">
				{{ $product->updated_at }}
			</div>
		</div>
	@endforeach

@endsection