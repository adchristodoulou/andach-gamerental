	<ul class="nav nav-pills nav-justified">
	  <li class="nav-item">
	    <a class="nav-link @if(Route::is('user.account')) active @endif" href="{{ route('user.account') }}">Wishlist</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link @if(Route::is('user.subscription')) active @endif" href="{{ route('user.subscription') }}">Subscriptions</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link @if(Route::is('user.history')) active @endif" href="{{ route('user.history') }}">Game Rental History</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link @if(Route::is('user.invoicelist')) active @endif" href="{{ route('user.invoicelist') }}">Invoices</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link @if(Route::is('user.edit')) active @endif" href="{{ route('user.edit') }}">Edit Details</a>
	  </li>
	</ul>
