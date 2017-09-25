@extends('template')

@section('h1')
The {{ $plan->name }} game rental service.
@endsection

@section('content')
<div class="container">

  <div class="row">
    <div class="col-12"><h2>{{ $plan->name }}</h2></div>
  </div>
  <div class="row">
    <div class="col-12">{{ $plan->description }}</div>
  </div>
  <div class="row">
    <div class="col-2">{{ $plan->max_games_simultaneously }}</div>
    <div class="col-10">Simultaneous Games</div>
  </div>
  <div class="row">
    <div class="col-2">@if ($plan->is_premium) Yes @else No @endif</div>
    <div class="col-10">Premium Games Included</div>
  </div>
  <div class="row">
    <div class="col-2">@if ($plan->is_priority) Yes @else No @endif</div>
    <div class="col-10">Priority Service</div>
  </div>

@if(Auth::check())  
  
  @if(Auth::user()->subscription('main'))
    <div class="row">
      <div class="col-12 alert alert-warning">
        <strong>You are already subscribed to a plan.</strong> Please only pay for a new plan here if you want to switch.
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-8 col-offset-2">

    <h2>Please Pay Below</h2>
      <form method="post" id="payment-form" action="{{ route('plan.store') }}">
        {{ csrf_field() }}
        {{ Form::hidden('plan', $plan->id) }}
        <div id="dropin-container"></div>
        <hr>

        <button id="payment-button" class="btn btn-primary btn-flat invisible" type="submit">Pay now</button>
      </form>
    </div>
  </div>

@else
  <div class="row">
    <div class="col-12">You must be logged in to purchase a plan. <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a> today!</div>
  </div>
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