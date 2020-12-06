@extends('post.layouts.app')

@section('title', 'Post Create Page')

@section('page', 'Post Create Page')

@section('content')

<div class="container">
    @can('create models')
        <div class="row">
            <div class="col-sm-2">
                <a class="btn btn-primary" href="{{ route('post.create') }}" title="Add New Post"> <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                  </svg> </a>
            </div>
    @endcan

            <a class="btn btn-primary" href="{{ route('post.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>

        <div class="col-sm-8">
            <!-- Search form -->
            <div class="search-inline">
                {!! Form::open(['route' => 'search', 'method' => 'get', 'class' => 'form-contorl form-control-search']) !!}
                    {!! Form::text('search', null, ['class'=>'form-control form-control-margin','required', 'placeholder=search']) !!}
                    {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit','class'=>'btn btn-secondary']) !!}
                {!! Form::close() !!}
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
