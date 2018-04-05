@extends('mail')

@section('content')

<h2>Your game has been received. </h2>
<p><b>{{ $rental->game->name }} has been received! We'll send you another game soon.</b>

@endsection