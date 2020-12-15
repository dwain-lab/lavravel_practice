@extends('post.layouts.app')

@section('title', 'Phone Service Edit Page')

@section('page', 'Phone Service Edit Page')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Phone Service</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('phone_service.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
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

    {!! Form::open(['route' => ['phone_service.update', $phone->id], 'method' => 'put']) !!}

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>{!! Form::label('number', 'Phone Number') !!}</strong>
                    {!! Form::text('number', $phone->number, ['placeholder'=>'Enter Title', 'class'=>'form-control', 'readonly']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    @foreach ($taggedServices as $taggedService)
                        <strong>{!! Form::label('code', $taggedService->name) !!}</strong>
                        {!! Form::checkbox('tags[]', $taggedService->id, 'checked') !!}
                    @endforeach
                    @foreach ($noneTaggedServices as $noneTaggedService)
                        <strong>{!! Form::label('code', $noneTaggedService->name) !!}</strong>
                        {!! Form::checkbox('tags[]', $noneTaggedService->id) !!}
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                {!! Form::button('Update', ['type' => 'submit', 'class'=>'btn btn-primary', 'title' => 'update']) !!}
            </div>
        </div>

    {!! Form::close() !!}

@endsection
