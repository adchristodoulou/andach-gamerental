@extends('template')

@section('content')
	@include('admin.menu')
<div class="container">
    <h2>Contact List</h2>

    @foreach ($contacts as $contact)
        {!! $contact->box !!}
    @endforeach
</div>
@endsection
