@extends('template')

@section('h1')
Rent {{ $game->name }} for {{ $game->system->name }} from Online Video Game Rentals from Andah
@endsection

@section('meta-description')
Rent {{ $game->name }} for {{ $game->system->name }} from Andach Game Rentals
@endsection

@section('title')
Rent {{ $game->name }} for {{ $game->system->name }} | Andach Game Rentals | Video Games
@endsection

@section('content')
	<div class="row" itemscope itemtype ="http://schema.org/Product">
		<div class="col-12">
			<h2>Achievements for {{ $game->name }} for <span itemprop="gamePlatform">{{ $game->system->name }}</span></h2>
			@if (Auth::check())
				@if (Auth::user()->isAdmin())
					<p><a href="{{ route('game.edit', $game->id) }}">Edit this Game</a></p>
					<p><a href="{{ route('admin.stock', $game->id) }}">Edit Stock for this Game</a></p>
				@endif
			@endif

			@if ($game->publisher)
				<p>Publisher: {{ $game->publisher }}</p>
			@endif
			@if($game->developer)
				<p>Developer: {{ $game->developer }}</p>
			@endif
			<hr />
			<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
			    <span itemprop="itemReviewed">{{ $game->name }}</span> is rated
			    <span itemprop="ratingValue">{{ $game->rating }}</span> out of
			    <span itemprop="bestRating">100</span> by
			    <span itemprop="reviewCount">{{ $game->rating_count }}</span> user reviewers on <a href="https://www.igdb.com">IGDB</a>. 
			</div>
			<hr />
			Also check out <a href="https://en.wikipedia.org/wiki/{{ $game->name}}">{{ $game->name }}</a> on Wikipedia.
		</div>
	</div>

	@foreach ($game->achievements as $ach)
		<div class="row achievement-row @if ($ach->earned_date) achievement-earned @endif">
			<div class="col-12 col-sm-12 col-md-3"><img src="{{ $ach->image }}" class="img-fluid" /></div>
			<div class="col-12 col-sm-8 col-md-6">
				{{ $ach->name }}<br />
				{{ $ach->achievement_description }}

				@if ($ach->earned_date)
					<br />
					You earned this achievement on {{ date('jS M Y h:m', strtotime($ach->earned_date)) }}
				@endif
			</div>
			<div class="col-3 col-sm-1 col-md-1">{{ $ach->gamerscore }}g</div>
			<div class="col-9 col-sm-3 col-md-2">{{ $ach->percentage_unlocked }}% unlocked</div>
		</div>
	@endforeach
@endsection