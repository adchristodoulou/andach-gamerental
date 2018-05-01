@extends('template')

@section('google-analytics')
	gtag('set', {'content_group1': 'Static Pages'}); 
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', $page->name) }}
@endsection

@section('h1'){{ $page->h1 }}@endsection

@section('meta-description'){{ $page->meta_description }}@endsection

@section('title'){{ $page->html_title }}@endsection

@section('content')
	<div class="row" itemscope itemtype ="http://schema.org/Article">
		<div class="col-12">
			{!! $page->bootstrapped_body !!}
		</div>
	</div>
@endsection