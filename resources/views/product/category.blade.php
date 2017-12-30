@extends('template')

@section('breadcrumbs')
	{{ Breadcrumbs::render('category', $category) }}
@endsection

@section('content')
	
	<h2>{{ $category->name }}</h2>

	<div class="row">
		<ul class="nav nav-pills nav-justified">
			@foreach ($children as $child)
				<li class="nav-item">
					<a class="nav-link" href="{{ route('product.showcategory', $child['slug']) }}">{{ $child['name'] }}</a>
				</li>
			@endforeach	
		</ul>
	</div>

	<div class="row">
		@foreach ($category->products as $product)
			{!! $product->box !!}
		@endforeach	
	</div>

@endsection