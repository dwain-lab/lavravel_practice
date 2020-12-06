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

    <div class="row">
        <div class="col-sm-4">
            <a class="btn btn-primary" href="{{ route('post.create') }}" title="Add New Post"> <svg width="4em" height="3em" viewBox="0 0 13 13" class="bi bi-person-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
            </svg> </a>
        </div>

        <div class="col-sm-8">
            <!-- Search form -->
            <form class="input-group" action="{{route('search')}}" method="GET">
                @csrf
                <input type="text" class="form-control" placeholder="Search" name="search">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="submit">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
            </form>

        </div>
    </div>

<table class="table table-bordered table-responsive-lg">
<tr>
    <th>No</th>
    <th>Title</th>
    <th>Description</th>
    <th>Date Created</th>
    <th width="280px">Action</th>
</tr>
@foreach ($posts as $post)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $post->title }}</td>
        <td>{{ $post->description }}</td>
        <td>{{ date_format($post->created_at, 'jS M Y') }}</td>
        <td>
            <form action="{{ route('post.destroy', $post->id) }}" method="POST">

                <a href="{{ route('post.show', $post->id) }}" title="show" class="crud-spacing">
                    <i class="fas fa-eye text-success  fa-lg"></i>
                </a>

                <a href="{{ route('post.edit', $post->id) }}" class="crud-spacing">
                    <i class="fas fa-edit  fa-lg"></i>

                </a>

                @csrf
                @method('DELETE')

                <button type="submit" title="delete" style="border: none; background-color:transparent;" onclick="return confirm('Are you sure you want to delete the post title {{$post->title}}?')">
                    <i class="fas fa-trash fa-lg text-danger"></i>

                </button>
            </form>
        </td>
    </tr>
@endforeach
</table>

{!! $posts->links('pagination::bootstrap-4') !!}
</div>
@endsection

