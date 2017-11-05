@extends('template')

@section('content')
	@include('user.menu')
	
	<h2>My Current Wishlist</h2>
	{!! Form::open(['route' => 'user.accountupdate']) !!}

	<div class="row">
		<div class="col-2">Boxart</div>
		<div class="col-3">Game</div>
        <div class="col-6">Number in Stock</div>
        <div clas="col-1">Delete?</div>
	</div>

	<div id="left-defaults" class="dragula-container">
		@foreach ($user->wishlistGames as $game)
			{!! $game->wishlist !!}
		@endforeach
	</div>
	{{ Form::submit('Update my Wishlist Order, and/or Delete Ticked Games') }}
	{!! Form::close() !!}

@endsection

@section('javascript')
<script>
dragula([document.getElementById('left-defaults')]);
</script>
@endsection