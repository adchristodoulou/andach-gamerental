
  <ul class="nav nav-pills nav-justified">
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.rentals')) active @endif" href="{{ route('admin.rentals') }}">Current Rentals</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.sendgames')) active @endif" href="{{ route('admin.sendgames') }}">Send Games</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.stock') || Route::is('admin.stockindex')) active @endif" href="{{ route('admin.stockindex') }}">Stock Index</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.users')) active @endif" href="{{ route('admin.users') }}">Users</a>
    </li>
  </ul>