<footer class="py-1 bg-dark">
	<div class="container">
		<div class="row footer">
			<div class="col-3 col-md-2">
				<p><b>Links</b></p>
				<p><a href="{{ route('home') }}">Homepage</a></p>
				<p><a href="{{ route('plan.index') }}">Our Plans</a></p>
				<p><a href="{{ route('login') }}">Login</a></p>
				<p><a href="{{ route('register') }}">Register</a></p>
				<p><a href="{{ route('sitemap') }}">Sitemap</a></p>
			</div>
			<div class="col-3 col-md-2">
				<p><b>Legal</b></p>
				<p><a href="{{ route('page.show', 'cookies') }}">Cookies</a></p>
				<p><a href="{{ route('page.show', 'delivery-information') }}">Delivery Information</a></p>
				<p><a href="{{ route('page.show', 'environmental-policy') }}">Environmental Policy</a></p>
				<p><a href="{{ route('page.show', 'privacy-policy') }}">Privacy Policy</a></p>
				<p><a href="{{ route('page.show', 'security-policy') }}">Security Policy</a></p>
				<p><a href="{{ route('page.show', 'terms-and-conditions') }}">Terms and Conditions</a></p>
				<p><a href="{{ route('page.show', 'transparency-policy') }}">Transparency Policy</a></p>
			</div>
			<div class="col-3 col-md-2">
				<p><b>Supported Systems</b></p>
				<p><a href="{{ route('page.show', 'rent-video-games') }}">Video Games</a></p>
				<p><a href="{{ route('page.show', 'rent-console-games') }}">Console Games</a></p>
				<p><a href="{{ route('page.show', 'rent-xbox-one-games') }}">Xbox One</a></p>
				<p><a href="{{ route('page.show', 'rent-xbox-360-games') }}">Xbox 360</a></p>
				<p><a href="{{ route('page.show', 'rent-ps2-games') }}">Playstation 2</a></p>
				<p><a href="{{ route('page.show', 'rent-ps3-games') }}">Playstation 3</a></p>
				<p><a href="{{ route('page.show', 'rent-ps4-games') }}">Playstation 4</a></p>
			</div>
			<div class="col-3 col-md-2">
				<p><b>Comparisons</b></p>
				<p><a href="{{ route('page.show', 'netflix-for-video-games') }}">Netflix</a></p>
				<p><a href="{{ route('page.show', 'xbox-game-pass-comparison') }}">Xbox Game Pass</a></p>
				<p><a href="{{ route('page.show', 'playstation-now-comparison') }}">Playstation Now</a></p>
				<p><a href="{{ route('page.show', 'ea-access-comparison') }}">EA Access</a></p>
			</div>
			<div class="col-12 col-md-4">
				<p><b>Social Media</b></p>
				<p>
					<a href="https://www.facebook.com/andachgames" style="color: #3B5998"><i class="fab fa-facebook-square fa-2x" aria-hidden="true"></i></a> 
					<a href="https://www.instagram.com/andachgames" style="color: #8a3ab9"><i class="fab fa-instagram fa-2x" aria-hidden="true"></i></a> 
					<a href="https://twitter.com/andachgames" style="color: #55acee"><i class="fab fa-twitter fa-2x" aria-hidden="true"></i></a> 
					<a href="https://www.pinterest.co.uk/andachgames" style="color: #cb2027"><i class="fab fa-pinterest fa-2x" aria-hidden="true"></i></a> 

			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p>Copyright &copy; 2017 - @php echo date('Y') @endphp Andach Game Rental
				<span class="float-right">
					<img src="/images/creditcards/visa.svg" alt="Visa" />
					<img src="/images/creditcards/mastercard.svg" alt="Mastercard" />
					<img src="/images/creditcards/amex.svg" alt="American Express" />
				</span>
				</p>
			</div>
		</div>
	</div>
</footer>