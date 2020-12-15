@extends('post.layouts.app')

@section('title', 'Phone Show Page')

@section('page', 'Phone Show Page')

@section('content')

@can('view models')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>  {{ $phone->name }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('phone.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone Number:</strong>
            {{ $phone->number }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Date Updated:</strong>
            {{ date_format($phone->created_at, 'jS M Y H:i:s') }}
        </div>
    </div>
</div>
@endcan
@endsection
