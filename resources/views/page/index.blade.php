@extends('template')

@section('content')
	
	<h2>Pages Index</h2>

	<p><a href="{{ route('page.create') }}">Create a Page</a></p>
	<div class="row">
		<div class="col-1">ID</div>
		<div class="col-3">Slug</div>
		<div class="col-3">H1</div>
		<div class="col-5">User</div>
	</div>

	@foreach ($pages as $page)

		<div class="row">
			<div class="col-1">{{ $page->id }}</div>
			<div class="col-3"><a href="{{ route('page.edit', $page->id) }}">{{ $page->slug }}</div>
			<div class="col-3">{{ $page->h1 }}</div>
			<div class="col-5">{{ $page->author->name }}</div>
		</div>

	@endforeach

@endsection