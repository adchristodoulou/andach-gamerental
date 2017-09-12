@extends('template')

@section('content')
	<div class="row">
		<div class="col-lg-4">
			<img src="/storage/{{ $game->thumb_url }}" />
		</div>
		<div class="col-lg-8">
			<h2>Rent {{ $game->name }}</h2>
			@if ($game->publisher)
				<p>Publisher: {{ $game->publisher }}</p>
			@endif
			@if($game->developer)
				<p>Developer: {{ $game->developer }}</p>
			@endif
			<hr />
			{{ $game->description }}

			{!! Form::open(['route' => 'game.addtowishlist', 'method' => 'POST']) !!}
			{{ Form::hidden('id', $game->id) }}
			{{ Form::submit('Add to Wishlist', ['class' => 'form-control']) }}
			{!! Form::close() !!}
		</div>
	</div>
@endsection