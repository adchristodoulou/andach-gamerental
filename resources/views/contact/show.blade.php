@extends('template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Contact #{{ $contact->id }} - {{ $contact->title }}</h2>

            <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-header">Original Communciation</div>
                        <div class="card-body">{{ $contact->full_text }}</div>
                        <div class="card-footer">footer</div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">Details about Communciation</div>
                        <div class="card-body">
                            <p>Date: {{ $contact->created_at }}</p>
                            <p>Category: {{ $contact->category->name }}</p>

                            @if ($contact->user_id)
                                <p>
                                    User #{{ $contact->user_id }}: {{ $contact->user->name }}
                                    <br />
                                    {{ $contact->user->email }}
                                </p>
                            @else
                                <p>Email: {{ $contact->email }}</p>
                                <p>Phone: {{ $contact->phone }}</p>
                            @endif

                        </div>
                        <div class="card-footer">footer</div>
                    </div>
                </div>
            </div>

            @foreach ($replies as $reply)
                <br />
                <div class="row">
                    <div class="col-12">
                        {!! $reply !!}
                    </div>
                </div>
            @endforeach

            @if ($contact->closed_at)
                <br />
                <div class="row">
                    <div class="col-12">
                        <div class="card border-danger">
                            <div class="card-header text-danger">Closed</div>
                            <div class="card-body text-danger">This issue was closed on {{ $contact->closed_at }} by {{ $contact->closed_by_name }}.</div>
                        </div>
                    </div>
                </div>
            @else 

                <h2>Reply to this Issue</h2>

                {!! Form::open(['route' => 'contact.update', 'method' => 'POST', 'files' => true]) !!}
                {{ Form::hidden('id', $contact->id) }}

                <div class="form-group">
                    {!! Form::label('full_text', 'Give us an update:') !!}
                    {!! Form::textarea('full_text', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('attachment', 'Attach a file (if needed)') !!}
                    {!! Form::file('attachment') !!}
                </div>

                <div class="form-group">
                    {!! Form::checkbox('close', 1) !!}
                    {!! Form::label('close', ' - Is this closed/complete? Tick if yes.') !!}
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::submit('Update This', ['class' => 'btn btn-primary']) }}
                    </div>
                </div>

                {!! Form::close() !!}

            @endif
        </div>
    </div>
</div>
@endsection
