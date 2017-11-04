@extends('template')

@section('content')
<h2>404 - Oops! This page could not be found!</h2>
<div class="row">
	<div class="col-12 col-md-4">
		You might want to try some of these links instead:<br />
		<a href="/">Home</a><br />
		<a href="{{ route('page.show', 'about-us') }}">About Us</a><br />
		<a href="{{ route('page.show', 'contact-us') }}">Contat Us</a><br />
	</div>
	<div class="col-12 col-md-8">
		<img src="/images/template/404.jpg" alt="404 image of lego" class="img-fluid" />
	</div>
</div>
@endsection