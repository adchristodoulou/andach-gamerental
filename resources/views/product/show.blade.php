@extends('template')

@section('breadcrumbs')
	@foreach ($product->categories as $category)
    	{{ Breadcrumbs::render('product', $product, $category) }}
    @endforeach
@endsection

@section('content')
	
	<h2>{{ $product->name }}</h2>

	<div class="row">
		<div class="col-3">
			<a  data-fancybox="gallery" href="{{ $product->main_img_path }}">{!! $product->thumb_img !!}</a>
			{{ Form::open(['route' => 'product.addtocart', 'method' => 'post']) }}
			
			{{ Form::hidden('product_id', $product->id) }}
			{{ Form::text('quantity', 1, ['class' => 'form-control']) }}
			{{ Form::submit('Add To Cart', ['class' => 'form-control btn btn-success']) }}

			{{ Form::close() }}
		</div>
		<div class="col-9">
			{!! $product->full_text_nl2br !!}
		</div>
	</div>

	@if (count($product->competitorListings))
		<h2>Our Competitor's Prices</h2>
		<div class="row">
			<div class="col-4">Competitor</div>
			<div class="col-2">New Price</div>
			<div class="col-2">Preowned Price</div>
			<div class="col-2">Buy Price</div>
			<div class="col-2">Voucher Price</div>
		</div>
		@foreach ($product->competitorListings as $l)
			<div class="row">
				<div class="col-4">{{ $l->competitor->name }}</div>
				<div class="col-2">{{ $l->latest_price_new_format }}</div>
				<div class="col-2">{{ $l->latest_price_preown_format }}</div>
				<div class="col-2">{{ $l->latest_price_buy_format }}</div>
				<div class="col-2">{{ $l->latest_price_voucher_format }}</div>
			</div>
		@endforeach
	@endif

	<!-- Root element of PhotoSwipe. Must have class pswp. -->
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

	    <!-- Background of PhotoSwipe. 
	         It's a separate element as animating opacity is faster than rgba(). -->
	    <div class="pswp__bg"></div>

	    <!-- Slides wrapper with overflow:hidden. -->
	    <div class="pswp__scroll-wrap">

	        <!-- Container that holds slides. 
	            PhotoSwipe keeps only 3 of them in the DOM to save memory.
	            Don't modify these 3 pswp__item elements, data is added later on. -->
	        <div class="pswp__container">
	            <div class="pswp__item"></div>
	            <div class="pswp__item"></div>
	            <div class="pswp__item"></div>
	        </div>

	        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
	        <div class="pswp__ui pswp__ui--hidden">

	            <div class="pswp__top-bar">

	                <!--  Controls are self-explanatory. Order can be changed. -->

	                <div class="pswp__counter"></div>

	                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

	                <button class="pswp__button pswp__button--share" title="Share"></button>

	                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

	                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

	                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
	                <!-- element will get class pswp__preloader--active when preloader is running -->
	                <div class="pswp__preloader">
	                    <div class="pswp__preloader__icn">
	                      <div class="pswp__preloader__cut">
	                        <div class="pswp__preloader__donut"></div>
	                      </div>
	                    </div>
	                </div>
	            </div>

	            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
	                <div class="pswp__share-tooltip"></div> 
	            </div>

	            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
	            </button>

	            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
	            </button>

	            <div class="pswp__caption">
	                <div class="pswp__caption__center"></div>
	            </div>

	        </div>

	    </div>

	</div>


@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

@endsection