@extends('post.layouts.app')

@section('title', 'Service Import Page')

@section('page', 'Service Import Page')

@section('content')

{{-- @if ($message = Session::get('status'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif --}}

@if (isset($errors) && $errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif

@if (session()->has('failures'))

    <table class="table table-danger">
        <tr>
            <th>Row</th>
            <th>Attribute</th>
            <th>Errors</th>
            <th>Value</th>
        </tr>

        @foreach (session()->get('failures') as $validation)
            <tr>
                <td>{{ $validation->row() }}</td>
                <td>{{ $validation->attribute() }}</td>
                <td>
                    <ul>
                        @foreach ($validation->errors() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    {{ $validation->values()[$validation->attribute()] }}
                </td>
            </tr>
        @endforeach
    </table>

@endif

<div class="container mt-5 text-center">
    <h2 class="mb-4">
        CSV to Import
    </h2>

    {!! Form::open(['route' => ['service.import-store'], 'method' => 'post', 'files' => true]) !!}
        <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
            <div class="custom-file text-left">
                {!! Form::file('file',['class' => 'form-control']); !!}
            </div>
        </div>
                {!! Form::button('Import Data', ['type' => 'submit','class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
    {{-- </form> --}}
</div>

@endsection
