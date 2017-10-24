@extends('template')

@section('content')
	@include('admin.menu')

	<p>
		<b>{{ $assignment->rental->user->name }}</b><br />
		{{ $assignment->rental->user->shipping_address1 }}<br />
		{{ $assignment->rental->user->shipping_address2 }}<br />
		{{ $assignment->rental->user->shipping_address3 }}<br />
		{{ $assignment->rental->user->shipping_town }}<br />
		{{ $assignment->rental->user->shipping_country }}<br />
		{{ $assignment->rental->user->shipping_postcode }}
	</p>

@endsection