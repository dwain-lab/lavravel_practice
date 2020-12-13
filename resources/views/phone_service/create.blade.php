@extends('post.layouts.app')

@section('title', 'Phone Service Create Page')

@section('page', 'Phone Service Create Page')

@section('content')

<div style="width: 100%; display:flex;">
    @can('create models')
            <div class="search-inline">
                <a class="btn btn-primary" href="{{ route('phone_service.create') }}" title="Add New Number"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                </a>
            </div>
    @endcan

            <div class="search-inline">
                <a class="btn btn-primary" href="{{ route('phone_service.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
                <!-- Search form -->
            <div class="search-inline" style="width: 100%; display:grid">
                {!! Form::open(['route' => 'search', 'method' => 'get', 'class' => 'form-contorl form-control-search']) !!}
                    {!! Form::text('search', null, ['class'=>'form-control form-control-margin', 'required' , 'placeholder=search']) !!}
                    {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit','class'=>'btn btn-secondary']) !!}
                {!! Form::close() !!}
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

{!! Form::open(['route' => ['phone_service.store'], 'method' => 'post', 'class' => '']) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{!! Form::label('number', 'Phone Number') !!}</strong>
                {{-- {!! Form::text('number', null, ['placeholder'=>'Enter Phone Number', 'class'=>'form-control']) !!} --}}
                    {!! Form::select('number', $phones, null, ['placeholder' => 'Pick a number...', 'class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                @foreach ($services as $service)
                    <strong>{!! Form::label('code', $service->name) !!}</strong>
                    {!! Form::checkbox('tags[]', $service->id) !!}
                @endforeach
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{!! Form::label('code', 'Service Code') !!}</strong> --}}
                {{-- {!! Form::select('code', $services, null, ['placeholder' => 'Pick a Service...', 'class'=>'form-control']) !!} --}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            {!! Form::button('Save', ['type' => 'submit', 'class'=>'btn btn-primary']) !!}
        </div>
    </div>
{!! Form::close() !!}

@endsection
