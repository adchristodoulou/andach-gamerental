@extends('mail')

@section('content')

<h2>Your subscription has been changed. </h2>
<p><b>You have changed your subscription to {{$plan->name}}</b>

@endsection