@extends('template')

@section('content')
	@include('user.menu')
	
	<h2>My Current List</h2>
	{!! Form::open(['route' => 'user.accountupdate']) !!}

    <!--
	<div class="row">
		<div class="col-2">Boxart</div>
		<div class="col-3">Game</div>
        <div class="col-6">Number in Stock</div>
        <div clas="col-1">Delete?</div>
	</div>
    -->

	<div id="left-defaults" class="dragula-container">
		@foreach ($user->wishlistGames as $game)
			{!! $game->wishlist !!}
		@endforeach
	</div>
    
    <div class="row">
        <div class="col-2">{{ Form::submit('Delete from List', ['class' => 'form-control btn btn-danger', 'name' => 'btnDelete']) }}</div>
        <div class="col-6"></div>
        <div class="col-4">{{ Form::submit('Update List Order', ['class' => 'form-control btn btn-success', 'name' => 'btnUpdate']) }}</div>
    </div>
	{!! Form::close() !!}

@endsection

@section('javascript')
    <script>
    dragula([document.getElementById('left-defaults')]);
    </script>
@endsection