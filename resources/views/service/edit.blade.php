@extends('post.layouts.app')

@section('title', 'Service Edit Page')

@section('page', 'Service Edit Page')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Service</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('service.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
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

    {!! Form::open(['route' => ['service.update', $service->id], 'method' => 'patch']) !!}

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>{!! Form::label('code', 'Service Code') !!}</strong>
                    {!! Form::text('code', $service->code, ['placeholder'=>'Enter Code', 'class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    <strong>{!! Form::label('name', 'Service Name') !!}</strong>
                    {!! Form::text('name', $service->name, ['placeholder'=>'Enter Name', 'class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    <strong>{!! Form::label('description', 'Service Description') !!}</strong>
                    {!! Form::text('description', $service->description, ['placeholder'=>'Enter Description', 'class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                {!! Form::button('Update', ['type' => 'submit', 'class'=>'btn btn-primary']) !!}
            </div>
        </div>

    {!! Form::close() !!}

@endsection
