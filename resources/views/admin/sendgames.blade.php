@extends('template')

@section('content')
	<h2>Games on Most Recent Assignment Run</h2>

	@if (count($runs) == 0)
		<b>You have not run any assignments today</b>
	@else
		{!! Form::open(['route' => 'admin.confirmassignments', 'method' => 'POST']) !!}
		@foreach ($runs as $run)
			<p><b>Assignment run #{{ $run->id }} on {{ $run->created_at }} by {{ $run->user->name }}</b></p>

			@if (count($run->assignments) == 0)
				<p><i>There were no assignments</i></p>
			@else
				@foreach ($run->assignments as $assignment)

				<div class="row">
					<div class="col-2">
						@if (!$assignment->rental_id)
							{!! Form::checkbox('assign[]', $assignment->id) !!}
						@endif
					</div>
					<div class="col-5">{{ $assignment->user->name }}</div>
					<div class="col-5">{{ $assignment->game->name }}</div>
				</div>

				@endforeach
			@endif 

		@endforeach

		{{ Form::submit('Send Ticked Games') }}

		{!! Form::close() !!}
	@endif

	{!! Form::open(['route' => 'admin.assignmentrun', 'method' => 'POST']) !!}
	{{ Form::submit('Run an Assignment') }}
	{!! Form::close() !!}
@endsection