@extends('post.layouts.app')

@section('title', 'Post Create Page')

@section('page', 'Post Create Page')

@section('content')

<div style="width: 100%; display:flex;">
    @can('create models')
            <div class="search-inline">
                <a class="btn btn-primary" href="{{ route('post.create') }}" title="Add New Post"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                </a>
            </div>
    @endcan

            <div class="search-inline">
                <a class="btn btn-primary" href="{{ route('post.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
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



{!! Form::open(['route' => 'post.store', 'method' => 'post', 'class' => '']) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{!! Form::label('title', 'Title') !!}</strong>
                {!! Form::text('title', null, ['placeholder'=>'Enter Title', 'class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{!! Form::label('description', 'Description') !!}</strong>
                {!! Form::text('description', null, ['placeholder'=>'Enter Description', 'class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            {!! Form::button('Save', ['type' => 'submit', 'class'=>'btn btn-primary']) !!}
        </div>
    </div>
{!! Form::close() !!}

{{--
<form action="{{ route('post.store') }}" method="POST" >
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                <input type="text" name="title" class="form-control" placeholder="Enter Title">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:50px" name="description"
                    placeholder="Enter Description"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form> --}}

@endsection
