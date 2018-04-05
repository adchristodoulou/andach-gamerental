@extends('mail')

@section('content')

<h2>There has been an update to your contact request: {{ $contact->title }}</h2>
@if ($contact->user_id)
	<p>Please <a href="{{ route('contact.show', $contact->id) }}">click here</a> to go to our website and reply. </p>
@else 
	<p>Please <a href="{{ route('contact.create') }}">let us know</a> if you have anything more you need to add.</p>
@endif

<p><b>Original Communciation</b></p>
<p>{{ $contact->full_text }}</p>

@foreach ($contact->replies as $reply)
    <br />
    <div class="row">
        <div class="col-12">
            {!! $reply->mail_box !!}
        </div>
    </div>
@endforeach

@endsection