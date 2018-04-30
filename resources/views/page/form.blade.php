@extends('template')

@section('content')
	@if (isset($page))
		{!! Form::model($page, ['route' => ['page.update', $page->id], 'files' => true, 'method' => 'PUT']) !!}
	@else
		{!! Form::open(['route' => 'page.store', 'files' => true]) !!}
	@endif

	<h2>Create or Edit Page</h2>
	<div class="row">
		{!! Form::label('slug', 'Slug:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('slug', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('name', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('h1', 'H1:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('h1', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('html_title', 'HTML Title:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('html_title', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<p id="titleCharacters"></p>

	<div class="row">
		{!! Form::label('meta_description', 'Meta Description:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::textarea('meta_description', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<p id="descCharacters"></p>

	<div class="row">
		{!! Form::label('body', 'Body:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::textarea('body', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('date_published', 'Date Published:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::date('date_published', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			@if (isset($page))
				{{ Form::submit('Edit this Page', ['class' => 'form-control btn btn-success']) }}
			@else
				{{ Form::submit('Add this Page', ['class' => 'form-control btn btn-success']) }}
			@endif
			
		</div>
	</div>

	{!! Form::close() !!}

@endsection

@section('javascript')
<script src="//cdn.ckeditor.com/4.9.1/full-all/ckeditor.js"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };

  CKEDITOR.replace('body', options);

	document.getElementById('html_title').oninput= function(e)
	{
	    document.getElementById('titleCharacters').innerHTML = '<b>' + (this.value.length) + ' characters (60 max)</b>';
	};

	document.getElementById('meta_description').oninput= function(e)
	{
	    document.getElementById('descCharacters').innerHTML = '<b>' + (this.value.length) + ' characters (300 max)</b>';
	};
</script>
@endsection