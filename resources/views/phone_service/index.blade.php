@extends('post.layouts.app')

@section('title', 'Phone Service Table')

@section('page', 'Phone Service Table')


@section('content')

@if ($search = Session::get('search'))
<div class="alert alert-success">
    <p>{{ $search }} records returned successfully</p>
</div>
@endif

@if(!is_null ($search) && $search == 0)
<div class="alert alert-warning">
    <p>{{ $search }} records returned</p>
</div>
@endif


@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

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

@can('view models')
    <div style="width: 100%; display:flex;">
@can('create models')
        <div class="search-inline">
            <a class="btn btn-primary" href="{{ route('phone_service.create') }}" title="Add New Phone"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            </a>
        </div>
@endcan

        <div class="search-inline">
            <a class="btn btn-primary" href="{{ route('phone_service.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
        </div>
            <!-- Search form -->
        <div class="search-inline" style="width: 100%; display:grid">
            {!! Form::open(['route' => 'search-phone_service', 'method' => 'get', 'class' => 'form-contorl form-control-search']) !!}
                {!! Form::text('search', null, ['class'=>'form-control form-control-margin', 'required' , 'placeholder=search']) !!}
                {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit','class'=>'btn btn-secondary']) !!}
            {!! Form::close() !!}
        </div>

    </div>

<div class="container">

    <table class="table table-bordered table-responsive-lg">
    <tr>
        {{-- <th>No</th> --}}
        <th> @sortablelink('number' , 'Phone Number') </th>
        {{-- <th> @sortablelink('name' , 'Service') </th> --}}
        <th>Service</th>
        {{-- <th> Phone Number </th>
        <th> Service </th> --}}
        <th> @sortablelink('updated_at', 'Date Updated') </th>
        {{-- <th>Date Updated</th> --}}
        <th width="280px">Action</th>
    </tr>
    @foreach ($phones as $phone)
        <tr>
            <td>{{ $phone->number }}</td>
            <td>
                    <div class="btn-group">
                        <?php $services = $phone->services->sortBy('name'); ?>
                    @foreach( $services as $service)
                    {!! Form::open(['route' => ['phone_service.destroy', $service->pivot->phone_id, $service->pivot->service_id], 'method' => 'post']) !!}

                            {!! Form::button('<i class="fa fa-window-close" >' . $service->name.'</i>', ['class' => 'btn btn-primary', 'type' => 'submit', 'title' => 'delete '.$service->name ,'onclick' => 'return confirm(\'Are you sure you want to delete the service tag '. $service->name.'?\')', 'style' => 'padding: revert']) !!}

                        {{-- <button type="button" class="btn btn-primary" style="padding: revert"> <i class="fa fa-window-close"> {{ $service->name }}</i></button> --}}
                        {{-- <a href="{{ 'route'('phone_service.destroy', [$service->pivot->phone_id, $service->pivot->service_id]) }}" title="destroy" class="">
                            <i class="fa fa-window-close"> {{ $service->name }}</i>
                        </a> --}}
                    {!! Form::close() !!}
                    @endforeach
                    </div>
            </td>
            <td>{{ $phone->updated_at->diffForHumans() }}</td>
            <td>
                    {{--@can('view models')
                        <a href="{{ route('phone.show', $phone->id) }}" title="show" class="crud-spacing">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>
                    @endcan --}}

                    @can('edit models')
                    <a href="{{ route('phone_service.edit', $phone->id) }}" class="crud-spacing" title= "edit">
                        <i class="fas fa-edit  fa-lg"></i>
                    </a>
                    @endcan

                    @can('delete models')
                    {{-- @method('post') --}}
                        {!! Form::open(['route' => ['phone_service.destroyAll', $phone->id], 'method' => 'post', 'style' => 'display: contents;']) !!}
                            {!! Form::button('<i class="fas fa-trash fa-lg text-danger"></i>', ['type' => 'submit', 'onclick' => 'return confirm(\'Are you sure you want to delete all association with phone number '. $phone->number.'?\')', 'style' => 'border: none; background-color:transparent;', 'title' => 'Delete All Service Tags']) !!}
                        {!! Form::close() !!}
                    @endcan
            </td>
        </tr>
    @endforeach
    </table>

    {!! $phones->appends(\Request::except('page'))->render('pagination::bootstrap-4') !!}
@endcan
    {{-- {{ $phones->links(pagination::bootstrap-4) }} --}}

@endsection
