@php ($i = 0)

@extends('template')

@section('content')
	
	<h1>Games Index</h1>

	@foreach ($games as $game)

		@if (++$i % 4 == 1)
			<div class="row">
		@endif

		<div class="col-lg-3">

			<img src="/storage/{{ $game->thumb_url }}" height="200" width="150"> <br />
			<b>{{$i}}/{{$i%4}}<br/><a href="{{ route('game.show', $game->id) }}">{{ $game->name }}</a></b>
		</div>

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