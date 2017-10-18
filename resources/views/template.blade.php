
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <div>
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
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contact-us">Contact</a>
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
          </ul>
        </div>
      </div>
    </nav>

    @if (Session::has('success'))
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-success"><b>Success:</b> {{ Session::get('success') }}</div>
        </div>
      </div>
    </div>
    @endif

    @if (Session::has('danger'))
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-danger"><b>Error:</b> {{ Session::get('danger') }}</div>
        </div>
      </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- Page Content -->
    <div class="container" id="contentcontainer">
      @yield('content')
    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Andach Game Rentals 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/esm/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>

    @yield('javascript')
      

  <script>
    dragula([document.getElementById('left-defaults')]);

    drake.on('drop', (el, target, source, sibling) => {
        const newColumnIndex = parseInt(get(target, 'id'));
        const previousColumnIndex = parseInt(get(source, 'id'));
        const belowId = get(sibling, 'id');
        const itemId = get(el, 'id');

        let columns = this.state.columns;
        if (belowId === undefined) {
          const newItemIndex = columns[newColumnIndex].items.length;
          columns[previousColumnIndex].items.splice(columns[previousColumnIndex].items.indexOf(itemId), 1);
          columns[newColumnIndex].items.splice(newItemIndex, 0, itemId);
          this.setState({columns});
        }
        else {
          const newItemIndex = columns[newColumnIndex].items.indexOf(belowId);
          columns[previousColumnIndex].items.splice(columns[previousColumnIndex].items.indexOf(itemId), 1);
          columns[newColumnIndex].items.splice(newItemIndex, 0, itemId);
          this.setState({columns});
        }

        if (this.props.onDrag !== undefined) {
          this.props.onDrag(columns);
        }
      });
    
  </script>

  </body>

</html>
