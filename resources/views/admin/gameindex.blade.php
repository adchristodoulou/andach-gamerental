@extends('template')

@section('content')
	@include('admin.menu')

	{!! Form::open(['route' => 'admin.gameindexpost', 'method' => 'POST']) !!}
	<h2>Admin Game Index</h2>

	<div class="row">
		<div class="col-1">{!! Form::checkbox('selectall', null, null, ['id' => 'selectall']) !!}</div>
		<div class="col-3">Game</div>
		<div class="col-3">System</div>
		<div class="col-5">Last Updated</div>
	</div>

	@foreach ($games as $game)
		<div class="row">
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
		</div>
	@endforeach

	<div class="col-12">
		{!! Form::submit('Update from IGDB', ['class' => 'form-control btn btn-success']) !!}
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