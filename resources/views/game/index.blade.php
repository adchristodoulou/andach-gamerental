@php ($i = 0)

@extends('template')

@section('content')
	
	<h1>Games Index</h1>

	@foreach ($games as $game)

		@if (++$i % 4 == 1)
			<div class="row">
		@endif

		{!! $game->box !!}

		@if ($i % 4 == 0)
			</div>
		@endif

	@endforeach

	<div class="row">
		<div class="col-lg-12">
			{{ $games->links() }}
		</div>
	</div>

@endsection