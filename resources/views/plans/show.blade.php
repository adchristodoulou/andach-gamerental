@extends('template')

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
      {{ Form::hidden('plan', $plan->id) }}
      <div id="dropin-container"></div>

      <button id="payment-button" class="btn btn-primary btn-flat invisible" type="submit">Pay now</button>
  </form>

</div>
@else
  <p class="alert alert-danger"><b>You aren't logged in:</b> - You can only subscribe to a plan with an account. Either <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>, then come back here to get subscribed and play your new games within days!</p>
@endif

</div>

@endsection

@section('javascript')
<script src="https://js.braintreegateway.com/js/braintree-2.30.0.min.js"></script>

    <script>
        $.ajax({
            url: '{{ url('braintree/token') }}'
        }).done(function (response) {
            braintree.setup(response.data.token, 'dropin', {
                container: 'dropin-container',
                onReady: function () {
                    $('#payment-button').removeClass('invisible');
                }
            });
        });
    </script>
@endsection