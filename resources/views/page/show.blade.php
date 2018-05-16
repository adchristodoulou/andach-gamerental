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

@section('microdata')
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Article",
  "author": {
    "@type": "Organization",
    "name": "Andach Games Ltd"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Andach Games Ltd",
    "logo": {
      "@type": "ImageObject",
      "url": "https://andachgames.co.uk/images/template/andach-rental-logo.png",
      "width": 98,
      "height": 60
    }
  },
  "mainEntityOfPage": {
   "@type": "WebPage",
   "@id": "{{ url()->current() }}"
  },
  "datePublished": "{{ $page->created_at }}",
  "dateModified": "{{ $page->updated_at }}",
  "headline": "{{ $page->h1 }}",
  "image": {
    "@type": "ImageObject",
    "url": "https://andachgames.co.uk/images/template/andach-rental-logo.png",
    "width": 98,
    "height": 60
  }
}
</script>
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{!! $page->bootstrapped_body !!}
		</div>
	</div>
@endsection