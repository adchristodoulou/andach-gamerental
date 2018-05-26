@extends('template')

@section('breadcrumbs')
  {{ Breadcrumbs::render('home') }}
@endsection

@section('content')

  <div class="row alert alert-danger">
    <div class="col-12"><b>Andach Games is launching soon! You can sign up, but we're not ready for subscriptions just yet.</b></div>
  </div>

      <div class="container" style="background-image: url('/images/template/header-ps4.jpeg')">
        <h2>Rent Playstation and Xbox games with Andach</h2>
        <div class="row">
          <div class="col-md-1 col-1 text-center p-3"><i class="fas fa-pound-sign fa-2x"></i></div>
          <div class="col-md-5 col-11 p-3">Subscriptions from &pound;9.99 per month</div>

          <div class="col-md-1 col-1 text-center p-3"><i class="fas fa-envelope-open fa-2x"></i></div>
          <div class="col-md-5 col-11 p-3">Free, first class delivery both ways</div>

          <div class="col-md-1 col-1 text-center p-3"><i class="fas fa-compact-disc fa-2x"></i></div>
          <div class="col-md-5 col-11 p-3">Choice of hundreds of games</div>

          <div class="col-md-1 col-1 text-center p-3"><i class="far fa-clock fa-2x"></i></div>
          <div class="col-md-5 col-11 p-3">No contract, no late fees</div>

          <div class="col-md-1 col-1 text-center p-3"><i class="fas fa-exclamation-triangle fa-2x"></i></div>
          <div class="col-md-5 col-11 p-3">Priority plans available if you want the latest games</div>

          <div class="col-md-1 col-1 text-center p-3"><i class="fas fa-door-open fa-2x"></i></div>
          <div class="col-md-5 col-11 p-3">Stock levels always visible</div>

          <div class="col-md-8 col-1"></div>
          <div class="col-md-4 col-11">
            <p class="align-right">
              <a href="{{ route('plan.index') }}">
                  <button class="form-control btn btn-success">View Rental Packages</button>
              </a>
            </p>
          </div>
        </div>
      </div>

      <h2>How This Works</h2>
      <div class="row">
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-search fa-5x" style="color: #DBA800" aria-hidden="true"></i>
            </div>
            <div class="card-body">
                <h4 class="card-title"><a href="{{ route('register') }}">Sign Up</a></h4>
              <p class="card-text">Choose a rental subscription through our secure, encrypted third party payment provider. We never see and can never access your full credit card information. </p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('plan.index') }}" class="btn btn-primary" style="background-color: #DBA800; border: 1px solid black">View Packages</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-list-ol fa-5x" style="color: #DBA800" aria-hidden="true"></i>
            </div>
            <div class="card-body">
              <h4 class="card-title">Add to List</h4>
              <p class="card-text">Create your list of games in priority order.</p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('game.search') }}" class="btn btn-primary" style="background-color: #DBA800; border: 1px solid black">Search for Games</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-envelope-open fa-5x" style="color: #DBA800" aria-hidden="true"></i>
            </div>
            <div class="card-body">
              <h4 class="card-title">Delivery</h4>
              <p class="card-text">Each morning, we find the games highest on your wishlist that we have in stock, and post out games first class, so that you can play them as soon as possible. </p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('user.account') }}" class="btn btn-primary" style="background-color: #DBA800; border: 1px solid black">Check your List</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-gamepad fa-5x" style="color: #DBA800" aria-hidden="true"></i>
            </div>
            <div class="card-body">
              <h4 class="card-title">Play</h4>
              <p class="card-text">There's no time limit! Keep the game for as long as you like, then pop it in the prepaid return envelope.</p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('register') }}" class="btn btn-primary" style="background-color: #DBA800; border: 1px solid black">Register Now!</a>
            </div>
          </div>
        </div>
      </div>
    
<!--
      <div class="container homepage-rentbox">
        <h2>Rent Xbox One Games Like These</h2>
        <div class="row row-eq-height">
          @foreach ($xboxone as $game)
            {!! $game->box !!}
          @endforeach
        </div>
      </div>
      <div class="container homepage-rentbox">
        <h2>Rent PS4 Games Like These</h2>
        <div class="row">
          @foreach ($ps4 as $game)
            {!! $game->box !!}
          @endforeach
        </div>
      </div>
-->
      
      

      <div class="row">
        <div class="col-12">
          <h2>Contact Us</h2>
          <address>
            <strong>Andach Game Rentals</strong>
            <br>{!! env('CONTACT_ADDRESS') !!}
          </address>
          <address>
            <abbr title="Phone">P:</abbr>
            {{ env('CONTACT_PHONE') }}
            <br>
            <abbr title="Email">E:</abbr>
            <a href="mailto:{{ env('CONTACT_EMAIL') }}">{{ env('CONTACT_EMAIL') }}</a>
          </address>
          <p>
            <a class="btn btn-success btn-lg" href="/contact">Contact Us &raquo;</a>
          </p>
        </div>
      </div>
@endsection