@extends('template')

@section('content')
	@include('admin.menu')
	<h2>Upload Games</h2>

	{!! Form::open(['route' => 'admin.uploadgamespost', 'method' => 'POST', 'files' => 'true']) !!}

	<p>Upload a CSV containing a header line of "system_id", "gamesdb_id" and "xbox_id" and upload it. </p>
	
	<div class="row">
		<div class="col-2">Upload CSV</div>
		<div class="col-10">
			{{ Form::file('csv') }}
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			{{ Form::submit('Upload these Games', ['class' => 'form-control btn btn-success']) }}
		</div>
	</div>

	{!! Form::close() !!}
@endsection