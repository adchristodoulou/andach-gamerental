@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', 'Contact') }}
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
                    <p>T: 0116 123 4567</p>
                    <p><i>Andach Games Ltd</i><br />P: 123 Demonstration Street<br />Nottingham<br />NG12 4SE</p>
                </div>
            </div>

            
        </div>
    </div>
</div>
@endsection
