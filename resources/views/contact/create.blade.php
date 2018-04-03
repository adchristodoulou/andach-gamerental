@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', 'Contact') }}
@endsection

@section('h1')
Get in touch with Andach Games
@endsection

@section('meta_description')
Contact Andach Games for any questions about video game rental, our plans or to suggest games that we don't have yet - we'll see if we can get a copy ASAP!
@endsection

@section('title')
Contact Us | Excellent Value Game Rental | Andach Games
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Contact Andach Game Rentals</h2>

            @if (!Auth::check())
                <div class="alert alert-warning">
                    You are not logged in. If you have an account, we strongly recommend that you log in and then you can see your history of past communications in your account. This helps us to give you better customer service. 
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-9">
                    {!! Form::open(['route' => 'contact.store', 'method' => 'POST', 'files' => true]) !!}

                    @if (!Auth::check())
                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('phone', 'Phone:') !!}
                            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                        </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('title', 'What are you getting in touch about?') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('category_id', 'Category:') !!}
                        {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('full_text', 'Give us the full details:') !!}
                        {!! Form::textarea('full_text', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('attachment', 'Attach a file (if needed)') !!}
                        {!! Form::file('attachment') !!}
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::submit('Contact Us', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="col-12 col-md-3">
                    <b>Alternative Contact Details</b>
                    <p>You can get in touch with us by phone or post at:</p>
                    <address>
                        <strong>Andach Game Rentals</strong>
                        <br>{!! env('CONTACT_ADDRESS') !!}
                      </address>
                      <address>
                        <abbr title="Phone">P:</abbr>
                        {{ env('CONTACT_PHONE') }}
                        <br>
                        <abbr title="Email">E:</abbr>
                        <a href="mailto:{{ env('CONTACT_EMAIL') }}">{{ env('CONTACT_EMAIL') }}</a>
                      </address>
                </div>
            </div>

            
        </div>
    </div>
</div>
@endsection
