
  <ul class="nav nav-pills nav-justified">
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.sendgames')) active @endif" href="{{ route('admin.sendgames') }}">Send Games</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  @if(Route::is('admin.users')) active @endif" href="{{ route('admin.users') }}">Users</a>
    </li>
  </ul>