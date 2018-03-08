@extends('template')

@section('breadcrumbs')
  {{ Breadcrumbs::render('home') }}
@endsection

@section('content')

      <div class="container" style="background-image: #444444">
        <h2>Rent video games rather than buying them with Andach Games</h2>
        <div class="row">
          <div class="col-4">
            <div class="rounded px-1 border border-dark" style="background-color: #084c61; height: 100%">
              <p class="text-center text-white">
                <i class="fa fa-gbp fa-5x"" aria-hidden="true"></i>
              </p>
              <p class="text-center text-white">
                It's cheaper. Even second hand games now can be astonishingly expensive, and you're stuffed if you find out you don't like one. Not with Andach - just send it back and get another at no extra cost! 
              </p>
            </div>
          </div>
          <div class="col-4">
            <div class="rounded px-1 border border-dark" style="background-color: #345995; height: 100%">
              <p class="text-center text-white">
                <i class="fa fa-edit fa-5x"" aria-hidden="true"></i>
              </p>
              <p class="text-center text-white">
                Register Today for just &pound;3.99 per month for our cheapest plan, or &pound;9.99 per month for unlimited games! We're completely open about how much stock we have, unlike some games rental companies, so you'll always be able to see what you can get. 
              </p>
            </div>
          </div>
          <div class="col-4">
            <div class="rounded px-1 border border-dark" style="background-color: #ffffff; height: 100%">
              <p class="text-center">
                <i class="fa fa-list fa-5x"" aria-hidden="true"></i>
              </p>
              <p class="text-center">
                Better choice than Games with Gold, EA Access and PS Plus, we have many more games for lots of systems, all for one simple subscription!
              </p>
              <p class="text-center"><a class="btn btn-success btn-lg" href="/register">Register Now! &raquo;</a></p>
            </div>
          </div>
        </div>
      </div>
    
      <h2>Rent Xbox One Games Like These</h2>
      <div class="row row-eq-height">
        @foreach ($xboxone as $game)
          {!! $game->box !!}
        @endforeach
      </div>
      <h2>Rent PS4 Games Like These</h2>
      <div class="row">
        @foreach ($ps4 as $game)
          {!! $game->box !!}
        @endforeach
      </div>

      <div class="row row-same-height">
        <div class="col-12 col-md-6 col-lg-3">
          <div class="rounded px-1" style="background-color: #084c61; height: 100%">
            <p class="text-center text-white">
              <i class="fa fa-gbp fa-5x"" aria-hidden="true"></i>
            </p>
            <p class="text-center text-white">
              <b>Low Prices and Lots of Choice</b>
            </p>
            <p class="text-center text-white">
              Our plans start at just &pound;3.99 per month, and we have a range of options including unlimited games per month and priority plans for gamers who want to play the latest games the moment they're released. 
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="rounded px-1" style="background-color: #345995; height: 100%">
            <p class="text-center text-white">
              <i class="fa fa-heart fa-5x"" aria-hidden="true"></i>
            </p>
            <p class="text-center text-white">
              <b>Top Games and Retro Options</b>
            </p>
            <p class="text-center text-white">
              We have an excellent range of games for both the current generation of consoles as well as retro games for older consoles. <br /><br />
              We aim to have one copy of every game released for modern consoles, and to make sure that we have multiple copies on release date for the big releases. 
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="rounded px-1" style="background-color: #db3a34; height: 100%">
            <p class="text-center text-white">
              <i class="fa fa-envelope-o fa-5x" aria-hidden="true"></i>
            </p>
            <p class="text-center text-white">
              <b>First Class Delivery and Free Postage</b>
            </p>
            <p class="text-center text-white">
              All delivery is first class to you, so you'll be playing the next day as soon as we allocate your games. <br /><br />
              There's free postage both ways - it's all included in the cost of the subscription, and we pay for your cost of posting things back to us
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="rounded px-1" style="background-color: #DBA800; height: 100%">
            <p class="text-center text-white">
              <i class="fa fa-ban fa-5x" aria-hidden="true"></i>
            </p>
            <p class="text-center text-white">
              <b>No Late Fees, No Contract</b>
            </p>
            <p class="text-center text-white">
              We don't have late fees at all. As long as you're a member, you can keep any game for absolutely as long as you like with no restrictions. <br /><br />
              We also don't believe in tying you into a contract - we'll keep your business by providing you with excellent customer service. There's one-click cancellation in your member's area. 
            </p>
          </div>
        </div>
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
            <br>{!! env('CONTACT_ADDRESS') !!}
          </address>
          <address>
            <abbr title="Phone">P:</abbr>
            {{ env('CONTACT_PHONE') }}
            <br>
            <abbr title="Email">E:</abbr>
            <a href="mailto:{{ env('CONTACT_EMAIL') }}">{{ env('CONTACT_EMAIL') }}</a>
          </address>
        </div>
      </div>
      <!-- /.row -->

      <h2>How This Works</h2>
      <div class="row">
        <div class="col-12 col-md-6 col-lg-3">
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
        <div class="col-12 col-md-6 col-lg-3">
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
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-envelope-o fa-5x" style="color: #db3a34" aria-hidden="true"></i>
            </div>
            <div class="card-body">
              <h4 class="card-title">Get them through the post</h4>
              <p class="card-text">Each morning, we find the games highest on your wishlist that we have in stock, and post out games first class, so that you can play them as soon as possible. </p>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('user.account') }}" class="btn btn-primary">Check your Wishlist</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card">
            <div class="card-header text-center" style="background-color: #898486">
              <i class="fa fa-gamepad fa-5x" style="color: #DBA800" aria-hidden="true"></i>
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