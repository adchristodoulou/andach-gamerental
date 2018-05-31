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

  {!! $plan->box !!}

@if(Auth::check())  

  @if(Auth::user()->isSubscribed())

    @if (Auth::user()->isOnPlan($plan))
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


  @if ($showPurchaseForm)
  <h2>Please Pay Below</h2>
  <p>You'll need to wait just a few seconds for the form below to load. Please note that you need to provide your <i>billing</i> post code to the form, not your delivery post code.</p>
  <form method="post" id="paymentForm" action="{{ route('plan.store') }}">
      {{ csrf_field() }}
      {{ Form::hidden('plan_id', $plan->id) }}

      <span id="paymentErrors"></span>

      <div class="row">
        <div class="col-2">
          <label>Name on Card</label>
        </div>
        <div class="col-10">
          <input data-worldpay="name" name="name" type="text" class="form-control" />
        </div>
        <div class="col-2">
          <label>Card Number</label>
        </div>
        <div class="col-10">
          <input data-worldpay="number" size="20" type="text" class="form-control" />
        </div>
        <div class="col-2">
          <label>Expiration (MM/YYYY)</label> 
        </div>
        <div class="col-10">
          <input data-worldpay="exp-month" size="2" type="text" class="form-control" /> 
          <label> / </label>
          <input data-worldpay="exp-year" size="4" type="text" class="form-control" />
        </div>
        <div class="col-2">
          <label>CVC</label>
        </div>
        <div class="col-10">
          <input data-worldpay="cvc" size="4" type="text" class="form-control" />
        </div>
      </div>
      
      {{ Form::submit('Sign Up!', ['class' => 'form-control btn btn-success']) }}
  </form>
  @endif

</div>
@else
  <p class="alert alert-danger"><b>You aren't logged in:</b> - You can only subscribe to a plan with an account. Either <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>, then come back here to get subscribed and play your new games within days!</p>
@endif

</div>

@endsection

@section('javascript')
<script src="https://cdn.worldpay.com/v1/worldpay.js"></script>

<script type="text/javascript">
var form = document.getElementById('paymentForm');

Worldpay.useOwnForm({
  'clientKey': '{{ env('WORLDPAY_CLIENT_KEY') }}',
  'form': form,
  'reusable': true,
  'callback': function(status, response) {
    document.getElementById('paymentErrors').innerHTML = '';
    if (response.error) {             
      Worldpay.handleError(form, document.getElementById('paymentErrors'), response.error); 
    } else {
      var token = response.token;
      Worldpay.formBuilder(form, 'input', 'hidden', 'token', token);
      form.submit();
    }
  }
});
</script>
@endsection