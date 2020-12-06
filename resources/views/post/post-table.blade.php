@extends('post.layouts.app')

@section('title', 'Post Table')

@section('page', 'Post Table')


@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="container">
    @can('create models')
        <div class="row">
            <div class="col-sm-4">
                <a class="btn btn-primary" href="{{ route('post.create') }}" title="Add New Post"> <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                  </svg> </a>
            </div>
    @endcan

        <div class="col-sm-8">
            <!-- Search form -->
            <div class="search-inline">
                {!! Form::open(['route' => 'search', 'method' => 'get', 'class' => 'form-contorl form-control-search']) !!}
                    {!! Form::text('search', null, ['class'=>'form-control form-control-margin','required', 'placeholder=search']) !!}
                    {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit','class'=>'btn btn-secondary']) !!}
            {{-- </form> --}}
                {!! Form::close() !!}
            </div>
        </div>
</div>
</div>

<div class="container">

    <table class="table table-bordered table-responsive-lg">
    <tr>
        <th>No</th>
        <th>Title</th>
        <th>Description</th>
        <th>Date Updated</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($posts as $post)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->description }}</td>
            <td>{{ date_format($post->updated_at, 'jS M Y') }}</td>
            <td>
                <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                    @can('view models')
                        <a href="{{ route('post.show', $post->id) }}" title="show" class="crud-spacing">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>
                    @endcan
                    @can('edit models')
                        <a href="{{ route('post.edit', $post->id) }}" class="crud-spacing">
                            <i class="fas fa-edit  fa-lg"></i>
                        </a>
                    @endcan


                    @csrf
                    @can('delete models')
                    @method('DELETE')

                        <button type="submit" title="delete" style="border: none; background-color:transparent;" onclick="return confirm('Are you sure you want to delete the post title {{$post->title}}?')">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                    @endcan
                </form>
            </td>
        </tr>
    @endforeach
    </table>

    {!! $posts->links('pagination::bootstrap-4') !!}
</div>
@endsection

