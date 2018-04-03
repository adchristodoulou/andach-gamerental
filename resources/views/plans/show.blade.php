@extends('template')

@section('google-analytics')
  gtag('set', {'content_group1': 'Plans'}); 
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('plan', $plan) }}
@endsection

@section('h1')
The {{ $plan->name }} game rental service.
@endsection

@section('meta-description')
Rent {{ $plan->max_games_simultaneously }} video games at a time for &pound;{{ number_format($plan->cost, 2) }} per month. 
@endsection

@section('title')
The {{ $plan->name }} game rental service. | Andach Game Rentals | Rent &amp; Buy Video Games
@endsection

@section('content')
<div class="container">

  <div class="row">
    <div class="col-12"><h2>Game Plan - {{ $plan->name }}</h2></div>
  </div>
  <div class="row">
    <div class="col-2">{{ $plan->max_games_simultaneously }}</div>
    <div class="col-10">Simultaneous Games</div>
  </div>
  <div class="row">
    <div class="col-2">@if ($plan->is_priority) Yes @else No @endif</div>
    <div class="col-10">Priority Service</div>
  </div>
  <div class="row">
    <div class="col-2">&pound;{{ number_format($plan->cost, 2) }}</div>
    <div class="col-10">Price Per Month</div>
  </div>

@if(Auth::check())  

  @if(Auth::user()->subscription('main'))

    @if (Auth::user()->currentPlan()->braintree_plan == $plan->braintree_plan)
    <div class="row">
      <div class="col-12 alert alert-danger">
        You are already subscribed to this plan. 
      </div>
    </div>
    @else
    <div class="row">
      <div class="col-12 alert alert-warning">
        <b>You are already subscribed to plan - <a href="{{ route('plan.show', Auth::user()->currentPlan()->slug) }}">{{ Auth::user()->currentPlan()->name }}</a>.</b> Please only pay for a new plan here if you want to switch.
      </div>
    </div>
    @endif
  @endif


  <h2>Please Pay Below</h2>
  <p>You'll need to wait just a few seconds for the form below to load. Please note that you need to provide your <i>billing</i> post code to the form, not your delivery post code.</p>
  <form method="post" id="payment-form" action="{{ route('plan.store') }}">
      {{ csrf_field() }}
      {{ Form::hidden('payment_method_nonce', '', ['id' => 'payment_method_nonce']) }}
      {{ Form::hidden('plan', $plan->id) }}
      <div id="dropin-container"></div>
      <button id="submit-button" class="btn btn-primary btn-flat " type="submit">Pay now</button>
  </form>

</div>
@else
  <p class="alert alert-danger"><b>You aren't logged in:</b> - You can only subscribe to a plan with an account. Either <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>, then come back here to get subscribed and play your new games within days!</p>
@endif

</div>

@endsection

@section('javascript')
<script src="https://js.braintreegateway.com/web/dropin/1.9.2/js/dropin.min.js"></script>
<script>
    var form = document.querySelector('#payment-form');
    var client_token = "{{ Braintree_ClientToken::generate() }}";

    braintree.dropin.create({
      authorization: client_token,
      selector: '#dropin-container',
      paypal: {
        flow: 'vault'
      }
    }, function (createErr, instance) {
      if (createErr) {
        console.log('Create Error', createErr);
        return;
      }
      form.addEventListener('submit', function (event) {
        event.preventDefault();

        instance.requestPaymentMethod(function (err, payload) {
          if (err) {
            console.log('Request Payment Method Error', err);
            return;
          }

          // Add the nonce to the form and submit
          document.querySelector('#payment_method_nonce').value = payload.nonce;
          form.submit();
        });
      });
    });
</script>
@endsection