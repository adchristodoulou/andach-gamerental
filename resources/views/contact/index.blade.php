@extends('template')

@section('content')
<div class="container">
    <h2>Contact List</h2>

    @foreach ($contacts as $contact)
        {!! $contact->box !!}
    @endforeach
</div>
@endsection
