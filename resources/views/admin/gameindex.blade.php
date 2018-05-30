@extends('template')

@section('content')
	@include('admin.menu')
	<h2>Admin Game Index</h2>
	{!! Form::open(['route' => 'admin.gameindexpost', 'method' => 'POST']) !!}
	<div class="row">

		<div class="col-12">
			<b>To only show games that haven't been updated in the last x days, and limit to y queries, change the URL to /admin/games/x/y</b>
		</div>

		<div class="col-12">Showing {{ $games->count() }} of {{ $count }} total games.</div>


		<div class="col-1">{!! Form::checkbox('selectall', null, null, ['id' => 'selectall']) !!}</div>
		<div class="col-3">Game</div>
		<div class="col-3">System</div>
		<div class="col-5">Last Updated</div>

	@foreach ($games as $game)
		<div class="col-1">
			{!! Form::checkbox('games[]', $game->id, null, ['class' => 'select']) !!}
		</div>
		<div class="col-3">
			<a href="{{ route('game.show', $game->slug) }}">{{ $game->name }} [Show]</a> <a href="{{ route('game.edit', $game->id) }}">[Edit]</a>
		</div>
		<div class="col-3">
			{{ $game->system->name }}
		</div>
		<div class="col-5">
			{{ $game->updated_at }}
		</div>
	@endforeach

		<div class="col-12">
			{!! Form::submit('Update from IGDB', ['class' => 'form-control btn btn-success']) !!}
		</div>

		<div class="col-12">
			{{ $games->links() }}
		</div>
	</div>
	{!! Form::close() !!}

@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
    $("#selectall").click(function(){
		if ($('#selectall').is(':checked')) {
			$(".select").prop("checked", true); 
		} else {
			$(".select").prop("checked", false); 
		}
    });
});
</script>
@endsection