@extends('template')

@section('content')
	@include('admin.menu')
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
				<div class="row">
					<div class="col-2">Make Into Rental</div>
					<div class="col-3">User</div>
					<div class="col-3">Game</div>
					<div class="col-2">Deliver?</div>
					<div class="col-2">Print Delivery Note</div>
				</div>

				@foreach ($run->assignments as $assignment)

				//These are here to allow testing to be easier in the appropriate environment. 
				@if (App::environment() == 'testing')
					<!-- {{ $assignment->user->name }} gets {{ $assignment->game->name }} -->
					<!-- {{ $assignment->user->name }} on run #{{ $run->id }} -->
				@endif
				<div class="row">
					<div class="col-2">
						@if (!$assignment->rental_id)
							{!! Form::checkbox('assign[]', $assignment->id) !!}
						@endif
					</div>
					<div class="col-3">{{ $assignment->user->name }}</div>
					<div class="col-3"><a href="{{ route('game.show', $assignment->game->slug) }}">{{ $assignment->game->name }}</a></div>
					<div class="col-2">
						@if ($assignment->rental_id)
							@if ($assignment->rental->date_of_delivery)
								{{ $assignment->rental->date_of_delivery }}
							@else 
								{!! Form::checkbox('deliver[]', $assignment->id) !!}
							@endif
						@else
							Not yet assigned.
						@endif
					</div>
					<div class="col-2">
						<a href="{{ route('admin.printdeliverynote', $assignment->id) }}">Print</a>
					</div>
				</div>

				@endforeach
			@endif 

		@endforeach

		{{ Form::submit('Make Assignments into Rentals and/or Deliver Rentals') }}

		{!! Form::close() !!}
	@endif

	{!! Form::open(['route' => 'admin.assignmentrun', 'method' => 'POST']) !!}
	{{ Form::submit('Run an Assignment') }}
	{!! Form::close() !!}
@endsection