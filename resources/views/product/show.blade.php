@extends('template')

@section('breadcrumbs')
	@foreach ($product->categories as $category)
    	{{ Breadcrumbs::render('product', $product, $category) }}
    @endforeach
@endsection

@section('content')
	
	<h2>{{ $product->name }}</h2>

	<div class="row">
		<div class="col-3">
			{!! $product->thumb_img !!}
			{{ Form::open(['route' => 'product.addtocart', 'method' => 'post']) }}
			
			{{ Form::hidden('product_id', $product->id) }}
			{{ Form::text('quantity', 1, ['class' => 'form-control']) }}
			{{ Form::submit('Add To Cart', ['class' => 'form-control btn btn-success']) }}

			{{ Form::close() }}
		</div>
		<div class="col-9">
			{!! $product->full_text_nl2br !!}
		</div>
	</div>

	<h2>Our Competitor's Prices</h2>
	<div class="row">
		<div class="col-4">Competitor</div>
		<div class="col-2">New Price</div>
		<div class="col-2">Preowned Price</div>
		<div class="col-2">Buy Price</div>
		<div class="col-2">Voucher Price</div>
	</div>
	@foreach ($product->competitorListings as $l)
		<div class="row">
			<div class="col-4">{{ $l->competitor->name }}</div>
			<div class="col-2">{{ $l->latest_price_new_format }}</div>
			<div class="col-2">{{ $l->latest_price_preown_format }}</div>
			<div class="col-2">{{ $l->latest_price_buy_format }}</div>
			<div class="col-2">{{ $l->latest_price_voucher_format }}</div>
		</div>
	@endforeach

@endsection