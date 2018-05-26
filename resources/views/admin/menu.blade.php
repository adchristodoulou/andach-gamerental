
  <ul class="nav nav-pills nav-justified">
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.competitors')) active @endif" href="{{ route('admin.competitors') }}">Competitors</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('contact.index')) active @endif" href="{{ route('contact.index') }}">Contacts</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.rentals')) active @endif" href="{{ route('admin.rentals') }}">Current Rentals</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('game.create')) active @endif" href="{{ route('game.create') }}">Game Create</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.gameindex')) active @endif" href="{{ route('admin.gameindex') }}">Game Index</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('page.index')) active @endif" href="{{ route('page.index') }}">Pages</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.productindex')) active @endif" href="{{ route('admin.productindex') }}">Products</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.sendgames')) active @endif" href="{{ route('admin.sendgames') }}">Send Games</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.stock') || Route::is('admin.stockindex')) active @endif" href="{{ route('admin.stockindex') }}">Stock Index</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.uploadgames')) active @endif" href="{{ route('admin.uploadgames') }}">Upload Games</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.uploadstock')) active @endif" href="{{ route('admin.uploadstock') }}">Upload Stock</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.users')) active @endif" href="{{ route('admin.users') }}">Users</a>
    </li>
  </ul>