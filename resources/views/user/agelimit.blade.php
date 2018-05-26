@extends('template')

@section('content')
	@include('user.menu')
	
	<h2>Set an Age Limit</h2>
	{!! Form::open(['route' => 'user.agelimitupdate']) !!}

	<div class="row">
		<div class="col-12">You can set an age limit for your account. 
            This means only games of a certain PEGI age rating can be added to a wishlist. 
            You may want this feature to be enabled if you are subscribing for your child. 
            You can share your account with your child, and they can't change the age limit without your email. 
            When you select a new age limit, an email will be sent to you with a link to click - you'll need to do this within 24 hours. 
        </div>
        <div class="col-12">{!! $user->age_limit_box !!}</div>
        <div class="col-2">New Age Limit:</div>
        <div class="col-10">
            <select name="age" class="form-control">
                <option value="3">3</option>
                <option value="7">7</option>
                <option value="12">12</option>
                <option value="16">16</option>
                <option value="">18 (remove age limit)</option>
            </select>
        </div>
        <div class="col-12">
            {{ Form::submit('Update Age Limit', ['class' => 'form-control btn btn-success']) }}
        </div>
	</div>
        
	{!! Form::close() !!}

@endsection