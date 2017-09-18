@extends('template')

@section('content')
	<div class="row">
		<div class="col-lg-4 text-center">
			<img src="/storage/{{ $game->thumb_url }}" />
			<br />
			@if ($game->onWishlist())
				{!! Form::open(['route' => 'game.deletefromwishlist', 'method' => 'POST']) !!}
				{{ Form::hidden('id', $game->id) }}
				{{ Form::submit('Remove Game from Wishlist', ['class' => 'form-control btn btn-danger']) }}
				{!! Form::close() !!}
			@else
				{!! Form::open(['route' => 'game.addtowishlist', 'method' => 'POST']) !!}
				{{ Form::hidden('id', $game->id) }}
				{{ Form::submit('Add to Wishlist', ['class' => 'form-control btn btn-success']) }}
				{!! Form::close() !!}
			@endif
		</div>
		<div class="col-lg-6">
			<h2>Rent {{ $game->name }}</h2>
			@if(Auth::id() == 1)
				<p><a href="{{ route('game.edit', $game->id) }}">Edit this Game</a></p>
			@endif

			@if ($game->publisher)
				<p>Publisher: {{ $game->publisher }}</p>
			@endif
			@if($game->developer)
				<p>Developer: {{ $game->developer }}</p>
			@endif
			<hr />
			{!! nl2br(e($game->description)) !!}



		</div>
		<div class="col-lg-2">
			<h2>Rating</h2>
			<p>{{ $game->rating }} / 100</p>
			<p>Using {{ $game->rating_count }} reviews</p>

			<p><img src="{{ $game->esrb_picture }}" data-toggle="modal" data-target="#exampleModal" height="64px" /></p>
			<p><img src="{{ $game->pegi_picture }}" data-toggle="modal" data-target="#exampleModal" height="64px"/></p>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h2>Videos</h2>

			<!-- Set up your HTML -->
			<div class="owl-carousel owl-theme">
				@foreach ($game->videos as $video)
	            <div class="item-video" data-merge="2">
	              <a class="owl-video" href="https://www.youtube.com/watch?v={{ $video->youtube_id }}"></a>
	              <br/><p>{{ $video->name }}</p> 
	            </div>
				@endforeach
			</div>
		</div>
	</div>
<!--
	<div class="row">
		<h2>Game Ratings</h2>
		<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		    Button with data-target
		  </button>
		<div class="collapse" id="collapseExample">
			<img src="{{ $game->esrb_picture }}" height="64px" />
			<div >
			  <div class="card card-block">
			    {{ $game->esrb_synopsis }}
			  </div>
			</div>
		</div>
	</div>-->
@endsection

@section('javascript')
<script>
  $(document).ready(function() {
  $('.owl-carousel').owlCarousel({
    items: 1,
    //merge: true,
    loop: true,
    margin: 10,
    video: true,
    lazyLoad: true,
    center: true,
    responsive: {
      480: {
        items: 2
      },
      600: {
        items: 4
      }
    }
  })
})
</script>
@endsection