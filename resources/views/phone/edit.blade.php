@extends('post.layouts.app')

@section('title', 'Phone Edit Page')

@section('page', 'Phone Edit Page')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Phone</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('phone.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    {!! Form::open(['route' => ['phone.update', $phone->id], 'method' => 'patch']) !!}

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>{!! Form::label('number', 'Phone Number') !!}</strong>
                    {!! Form::text('number', $phone->number, ['placeholder'=>'Enter Title', 'class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                {!! Form::button('Update', ['type' => 'submit', 'class'=>'btn btn-primary']) !!}
            </div>
        </div>

    {!! Form::close() !!}

@endsection
