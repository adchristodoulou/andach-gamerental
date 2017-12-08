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
            <img class="card-img-top" src="https://placehold.it/300x200" alt="">
            <div class="card-body">
              <h4 class="card-title">Add Games to Your List</h4>
              <p class="card-text">Sign up for an account and add games to your wishlist. </p>
            </div>
            <div class="card-footer">
              @if (Auth::check())
                <a href="/register" class="btn btn-primary">Register Now!</a>
              @else 
                <a href="/user/wishlist" class="btn btn-primary">Check your Wishlist</a>
              @endif
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="https://placehold.it/300x200" alt="">
            <div class="card-body">
              <h4 class="card-title">Get them through the post</h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque sequi doloribus totam ut praesentium aut.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Find Out More!</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="https://placehold.it/300x200" alt="">
            <div class="card-body">
              <h4 class="card-title">Play as long as you want</h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Find Out More!</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="https://placehold.it/300x200" alt="">
            <div class="card-body">
              <h4 class="card-title">Send it back and get another</h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Find Out More!</a>
            </div>
          </div>
        </div>

      </div>
@endsection