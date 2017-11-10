@extends('template')

@section('h1')
The {{ $plan->name }} game rental service.
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
  <p>You'll need to wait just a few seconds for the form below to show up. Please note that you need to provide your <i>billing</i> post code to the form, not your delivery post code.</p>
  {!! Form::open(['route' => 'plan.store', 'method' => 'post', 'id' => 'my-sample-form']) !!}

  <div class="row">
    <div class="col-12 col-md-6">


      <label class="hosted-field--label" for="card-number"><span class="icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg></span> Card Number 
      </label>
      <div id="card-number" class="hosted-field"></div>
    </div>

    <div class="col-12 col-md-6">

      <label class="hosted-field--label" for="expiration-date">
      <span class="icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
      </span> 
      Expiration Date</label>
      <div id="expiration-date" class="hosted-field"></div>
    </div>


    <div class="col-12 col-md-6">
      <label class="hosted-field--label" for="cvv">
      <span class="icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
      </span>
      CVV</label>
      <div id="cvv" class="hosted-field"></div>
    </div>

    <div class="col-12 col-md-6">

      <label class="hosted-field--label" for="postal-code">
      <span class="icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
      <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
      </span> 
      Postal Code</label>
      <div id="postal-code" class="hosted-field"></div>
    </div>

    <div class="col-12">
      {{ Form::submit('Pay for Plan', ['class' => 'form-control btn btn-success']) }}
    </div>
  </div>

</div>

  {!! Form::close() !!}
@else
  <p class="alert alert-danger"><b>You aren't logged in:</b> - You can only subscribe to a plan with an account. Either <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>, then come back here to get subscribed and play your new games within days!</p>
@endif

</div>

@endsection

@section('javascript')
<script src="https://js.braintreegateway.com/web/3.25.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.25.0/js/hosted-fields.min.js"></script>
    

    <script>
        var form = document.querySelector('#my-sample-form');
      var submit = document.querySelector('input[type="submit"]');

      braintree.client.create({
        //https://developers.braintreepayments.com/guides/authorization/tokenization-key/javascript/v3#obtaining-a-tokenization-key
        authorization: '{{ env('BRAINTREE_AUTHTOKEN') }}'
      }, function (clientErr, clientInstance) {
        if (clientErr) {
          console.error(clientErr);
          return;
        }

        // This example shows Hosted Fields, but you can also use this
        // client instance to create additional components here, such as
        // PayPal or Data Collector.

        braintree.hostedFields.create({
          client: clientInstance,
          styles: {
            'input': {
              'font-size': '14px'
            },
            'input.invalid': {
              'color': 'red'
            },
            'input.valid': {
              'color': 'green'
            }
          },
          fields: {
            number: {
              selector: '#card-number',
              placeholder: '4111 1111 1111 1111'
            },
            cvv: {
              selector: '#cvv',
              placeholder: '123'
            },
            expirationDate: {
              selector: '#expiration-date',
              placeholder: '10/2019'
            },
            postalCode: {
              selector: '#postal-code',
              placeholder: '11111'
            }
          }
        }, function (hostedFieldsErr, hostedFieldsInstance) {
          if (hostedFieldsErr) {
            console.error(hostedFieldsErr);
            return;
          }

          submit.removeAttribute('disabled');

          form.addEventListener('submit', function (event) {
            event.preventDefault();

            hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
              if (tokenizeErr) {
                console.error(tokenizeErr);
                return;
              }

              // If this was a real integration, this is where you would
              // send the nonce to your server.
              console.log('Got a nonce: ' + payload.nonce);
            });
          }, false);
        });
      });
    </script>
@endsection