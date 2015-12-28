@extends('layouts.app')

@section('content')

    <!-- Display Validation Errors -->
    @include('common.errors')

    <div class="container-fluid">

        <!-- New Task Form -->
        <form action="/club" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('name', Request::input('name'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('city', 'City', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('city', Request::input('city'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('state', 'State', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('state', $states, Request::input('state'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('zip_code', 'Zip Code', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('zip_code', Request::input('zip_code'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('contact_name', 'Contact Name', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('contact_name', Request::input('contact_name'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('contact_email', 'Contact Email', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('contact_email', Request::input('contact_email'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('contact_website', 'Contact Website', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('contact_website', Request::input('contact_website'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('contact_phone', 'Contact Phone', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('contact_phone', Request::input('contact_phone'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Club
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Current Tasks -->
    @if (count($clubs) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Running Clubs
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Name</th>
                        <th>City</th>
                        <th>State</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($clubs as $club)
                            <tr>
                                <td class="table-text">
                                    {{ $club->name }}
                                </td>
                                <td class="table-text">
                                    {{ $club->city }}
                                </td>
                                <td class="table-text">
                                    {{ $club->state }}
                                </td>
                                <td>
                                    <form action="club/{{ $club->id }}" method="GET">
                                        {{ csrf_field() }}
                                        <button>Edit</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="club/{{ $club->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
