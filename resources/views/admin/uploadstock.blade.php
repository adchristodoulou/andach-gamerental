@extends('template')

@section('content')
	@include('admin.menu')
	<h2>Upload Stock</h2>

	{!! Form::open(['route' => 'admin.uploadstockpost', 'method' => 'POST', 'files' => 'true']) !!}

	<p>Upload a CSV containing a header line of "game_id", "date_purchased", "purchase_price" and "note" and upload it. </p>
	<p>Note that any date fields must be in the format of YYYY-MM-DD.</p>
	
	<div class="row">
		<div class="col-2">Upload CSV</div>
		<div class="col-10">
			{{ Form::file('csv') }}
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			{{ Form::submit('Upload this Stock', ['class' => 'form-control btn btn-success']) }}
		</div>
	</div>

	{!! Form::close() !!}
@endsection