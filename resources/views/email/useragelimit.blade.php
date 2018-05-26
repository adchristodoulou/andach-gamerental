@extends('mail')

@section('content')

<h2>Set a New Age Limit</h2>
<p>You have requested to set a new age limit of {{ $user->maximum_age_held }} on your account. The current age limit is {{ $user->maximum_age }}.</p>
<p>Please <a href="https://andachrental.co.uk/{{ route('user.agelimitconfirm', $user->maximum_age_hash) }}">click here</a> to confirm this request. You must do this within 24 hours, or the link will expire.</p>

@endsection