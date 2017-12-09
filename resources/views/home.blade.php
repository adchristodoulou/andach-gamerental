@extends('template')

@section('content')

      <h2>Rent Xbox One Games</h2>
      <div class="row row-eq-height">
        @foreach ($xboxone as $game)
          {!! $game->box !!}
        @endforeach
      </div>
      <h2>Rent PS4 Games</h2>
      <div class="row">
        @foreach ($ps4 as $game)
          {!! $game->box !!}
        @endforeach
      </div>

      <div class="row">
        <div class="col-sm-8">
          <h2 class="mt-4">What We Do</h2>
          <p>Andach Game Rentals is a rental service for all the games you love, with a difference!</p>
          <p>Our entire website is fully <a href="/open-source">open source</a> and our business is completely open, reflecting the way we think you should do business. </p>
          <p>You pay a regular monthly fee and get as many games as you like! There's no catch, there's no small print. 
          <p>
            <a class="btn btn-primary btn-lg" href="/register">Register Now! &raquo;</a>
          </p>
        </div>
        <div class="col-sm-4">
          <h2 class="mt-4">Contact Us</h2>
          <address>
            <strong>Andach Game Rentals</strong>
            <br>3481 Melrose Place
            <br>Beverly Hills, CA 90210
            <br>
          </address>
          <address>
            <abbr title="Phone">P:</abbr>
            (123) 456-7890
            <br>
            <abbr title="Email">E:</abbr>
            <a href="mailto:#">name (AT) example.com</a>
          </address>
        </div>
      </div>
      <!-- /.row -->

      <h2>How This Works</h2>
      <div class="row">
        <div class="col-sm-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-search fa-5x" style="color: #084c61" aria-hidden="true"></i>
            </div>
            <div class="card-body">
              <h4 class="card-title">Sign Up</h4>
              <p class="card-text">Sign up for an account through our secure, encrypted third party payment provider. We never see and can never access your full credit card information. </p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('register') }}" class="btn btn-primary">Register Now!</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-list-ol fa-5x" style="color: #345995" aria-hidden="true"></i>
            </div>
            <div class="card-body">
              <h4 class="card-title">Add to List</h4>
              <p class="card-text">Browse and search for games you want, to create an ordered list of your preferenes for us to send to you. </p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('game.search') }}" class="btn btn-primary">Search our Games Database</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-envelope-o fa-5x" style="color: #db3a34" aria-hidden="true"></i>
            </div>
            <div class="card-body">
              <h4 class="card-title">Get them through the post</h4>
              <p class="card-text">We run our scripts each morning, and post out games first class, so that you can play them as soon as possible. </p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('user.account') }}" class="btn btn-primary">Check your Wishlist</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-gamepad fa-5x" style="color: #ffc857" aria-hidden="true"></i>
            </div>
            <div class="card-body">
              <h4 class="card-title">Play as long as you want</h4>
              <p class="card-text">There's no time limit! Play for as long as you want, and put them in the prepaid envelope we'll give you to return them. </p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('user.history') }}" class="btn btn-primary">Game Rental History</a>
            </div>
          </div>
        </div>

      </div>
@endsection