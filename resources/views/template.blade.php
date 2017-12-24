  
<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-108867511-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-108867511-1');
    </script>



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description', 'Andach Rentals, Video Game Rentals for Xbox One, 360, PS3, PS4 and Retro Gaming. Rent unlimited games for only &pound;9.99 per month!')">
    <meta name="author" content="">
    <meta name="p:domain_verify" content="e9d1312cc0534f98a43b3f786b39e93a"/>

    <title>@yield('title', 'Andach Video Game Rentals - Xbox One and 360, PS3, PS4 and Wii')</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css">

    <!-- Custom styles for this template -->
    <link href="/css/app.css" rel="stylesheet">

    <link rel="canonical" href="{{ url()->current() }}" />

    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:title" content="@yield('title', 'Andach Video Game Rentals - Xbox One and 360, PS3, PS4 and Wii')"/>
    <meta property="og:site_name" content="Andach Video Game Rentals"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description" content="@yield('meta-description', 'Andach Rentals, Video Game Rentals for Xbox One, 360, PS3, PS4 and Retro Gaming. Rent unlimited games for only &pound;9.99 per month!')" />
    <meta property="og:image" content="@yield('image', '')" />

    <meta property="twitter:card" content="product" />
    <meta property="twitter:description" content="@yield('meta-description', 'Andach Rentals, Video Game Rentals for Xbox One, 360, PS3, PS4 and Retro Gaming. Rent unlimited games for only &pound;9.99 per month!')" />
    <meta property="twitter:title" content="@yield('title', 'Andach Video Game Rentals - Xbox One and 360, PS3, PS4 and Wii')"/>
    <meta property="twitter:url" content="{{ url()->current() }}"/>
    <meta property="twitter:image" content="@yield('image', '')" />



  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <div>
          <img src="/images/template/andach-rental-logo.png" />
        </div>
        <div id="navbar-title">
          <a class="navbar-brand" href="/">Andach Game Rentals</a><br />
          <h1>@yield('h1', 'Xbox, Playstation and retro game rentals!')</h1>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/about-us">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contact">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/open-source">Open Source</a>
            </li>
            @if (Auth::check())
              <li class="nav-item">
                <a class="nav-link" href="{{ route('log-out') }}">Log Out</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('user.account') }}">My Account</a>
              </li>
              @if (Auth::user()->isAdmin())
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.admin') }}">Admin</a>
                </li>
              @endif
            @else
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Log In</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
              </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="{{ route('product.cart') }}">Cart
                @if ($numberofitemsincart > 0)
                  ({{ $numberofitemsincart }})
                @endif
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Game Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-top: 20px">
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ml-auto navbar-gamebar">
            @foreach ($gamemenu as $system)
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="https://example.com" id="navbarDropdownMenuLink-{{ $system->url }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ $system->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-{{ $system->url }}">
                  <a class="dropdown-item" href="{{ route('game.search', ['system_id' => $system->url]) }}">All Games</a>
                  <div class="dropdown-divider"></div>
                  @foreach ($gamecategories as $category)
                  <a class="dropdown-item" href="{{ route('game.search', ['system_id' =>  $system->url, 'category_id' => $category->url]) }}">{{ $category->name }}</a> 
                  @endforeach
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </nav>

    @if (Auth::check())
      @if (!Auth::user()->subscription('main'))
        <div class="row">
          <div class="col-12">
            <div class="alert alert-danger text-center">You are not currently subscribed to any plan. Check out <b><a href="{{ route('plan.index') }}">our full range of plans</a></b>, pick one and get playing immediately!</div>
          </div>
        </div>
      @endif
    @endif

    @if (Session::has('success'))
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-success"><b>Success:</b> {!! Session::get('success') !!}</div>
        </div>
      </div>
    </div>
    @endif

    @if (Session::has('danger'))
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-danger"><b>Error:</b> {!! Session::get('danger') !!}</div>
        </div>
      </div>
    </div>
    @endif

    @if (isset($errors))
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
    @endif

    <!-- Page Content -->
    <div class="container" id="contentcontainer">
      @yield('content')
    </div>

    <!-- Footer -->
    @include('footer')

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--If we use the CDN version rather than the self-hosted it doesn't work. Yay programming!-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/esm/popper.min.js"></script>-->
    <script src="/js/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js"></script>

    @yield('javascript')

  </body>

</html>
