@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', 'Login') }}
@endsection

@section('meta-description')
Login for Andach Video Game rentals - rent video games for a fixed price per month and buy accessories and games.  
@endsection

@section('title')
Login for Game Rentals and Purchases | Andach Game Rentals | Rent &amp; Buy Video Games
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Login with Email</h4>

                    {!! Form::open(['route' => 'login', 'method' => 'POST']) !!}

                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('remember', 'Remember Me?') !!}
                            {!! Form::checkbox('remember', 'remember', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                {{ Form::submit('Login', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>

                        <div class="row">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">...or Login with Social Media</h4>

                    <a class="btn btn-block btn-social btn-facebook" href="/login/facebook/"">
                        <span class="fa fa-facebook"></span> Sign in with Facebook
                    </a>

                    <a class="btn btn-block btn-social btn-twitter" href="/login/twitter/"">
                        <span class="fa fa-twitter"></span> Sign in with Twitter
                    </a>

                    <a class="btn btn-block btn-social btn-google" href="/login/google/"">
                        <span class="fa fa-google"></span> Sign in with Google+
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
