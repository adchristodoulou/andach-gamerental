@extends('template')

@section('content')
	@if (isset($product))
		{!! Form::model($product, ['route' => ['admin.productupdate'], 'files' => true, 'method' => 'PUT']) !!}
		{{ Form::hidden('id', $product->id) }}
		<h2>Edit Product</h2>
	@else
		{!! Form::open(['route' => 'admin.productstore', 'files' => true, 'method' => 'POST']) !!}
		<h2>Create Product</h2>
	@endif

	
	<p><a href="{{ route('admin.productcreate') }}">Make a New Product</a></p>
	<div class="row">
		{!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('name', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('game_id', 'Game:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('game_id', $games, null, ['class' => 'form-control', 'placeholder' => '(please select a game)']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('slug', 'Slug:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('slug', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('price', 'Price (in pence):', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('price', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('supplier_url', 'Supplier URL:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('supplier_url', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('supplier_product_id', 'Supplier Product ID:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('supplier_product_id', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('snippet', 'Snippet:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::textarea('snippet', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('full_text', 'Full Text:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::textarea('full_text', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('is_vatable', 'Is VATable?', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::checkbox('is_vatable', 1, 1, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('uploadpictures', 'Upload Pictures:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::file('uploadpictures[]', ['class' => 'form-control', 'multiple' => 'multiple']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('add_category', 'Category:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::select('add_category', $categories, null, ['class' => 'form-control', 'placeholder' => '(please select a category)']) !!}
		</div>
	</div>

	@if (isset($product))
		@if (count($product->categories))
			<h2>All Categories for this Product</h2>

			<div class="row">
			@foreach ($product->categories as $cat)
				<div class="col-1">
					{{ Form::checkbox('deleteCat[]', $cat->id) }}
				</div>
				<div class="col-11">
					{{ $cat->name }}
				</div>
			@endforeach
			</div>
		@endif

		@if (count($product->pictures))
			<h2>All Pictures for this Product</h2>

			<div class="row">
			@foreach ($product->pictures as $picture)
				<div class="col-3">
					<img src="{{ $picture->thumb_path }}" /><br />
					{{ Form::checkbox('deleteImage[]', $picture->id) }}
					{{ Form::radio('is_main', $picture->id, $picture->is_main) }}
					{{ Form::hidden('pictures[]', $picture->id) }}
				</div>
			@endforeach
			</div>
		@endif
	@endif

	@if (isset($product))
		<div class="row">
			<div class="col-lg-12">
				{{ Form::submit('Edit this Product', ['class' => 'form-control btn btn-success']) }}
			</div>
		</div>
	@else
		<div class="row">
			<div class="col-lg-12">
				{{ Form::submit('Add this Product', ['class' => 'form-control btn btn-success']) }}
			</div>
		</div>
	@endif

	{!! Form::close() !!}

@endsection