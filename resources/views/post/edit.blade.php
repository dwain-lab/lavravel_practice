@extends('post.layouts.app')

@section('title', 'Post Edit Page')

@section('page', 'Post Edit Page')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Post</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('post.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
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

    {!! Form::open(['route' => ['post.update', $post->id], 'method' => 'patch']) !!}

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>{!! Form::label('title', 'Title') !!}</strong>
                    {!! Form::text('title', $post->title, ['placeholder'=>'Enter Title', 'class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>{!! Form::label('description', 'Description') !!}</strong>
                    {!! Form::text('description', $post->description, ['placeholder'=>'Enter Description', 'class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                {!! Form::button('Update', ['type' => 'submit', 'class'=>'btn btn-primary']) !!}
            </div>
        </div>

    {!! Form::close() !!}

{{-- <form action="{{ route('post.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                <input type="text" name="title" value="{{ $post->title }}" class="form-control" placeholder="Title">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:50px" name="description"
                    placeholder="Description">{{ $post->description }}</textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>

</form> --}}

@endsection
