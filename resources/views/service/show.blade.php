@extends('post.layouts.app')

@section('title', 'Service Show Page')

@section('page', 'Service Show Page')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>  {{ $service->name }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('service.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Service Code:</strong>
            {{ $service->code }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Service Name:</strong>
            {{ $service->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Service Description:</strong>
            {{ $service->description }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Date Updated:</strong>
            {{ date_format($service->created_at, 'jS M Y H:i:s') }}
        </div>
    </div>
</div>

@endsection
