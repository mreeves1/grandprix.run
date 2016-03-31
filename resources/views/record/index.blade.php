@extends('layouts.app')

@section('content')

    <!-- Display Validation Messages and Errors -->
    @include('common.success')
    @include('common.errors')


    <div class="panel panel-default">
        <div class="panel-heading" style="">
            <h4 style="display:inline-block">Running Records</h4>
            <div style="float:right;">
                <form action="record/create" method="GET">
                    {{ csrf_field() }}
                    <button class="btn btn-success">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Add New Record
                    </button>
                </form>
            </div>
        </div>

        <div class="panel-body">
            @if (count($records) > 0)
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Athlete Name</th>
                        <th>Race Name</th>
                        <th>Race Date</th>
                        <th>Race Location</th>
                        <th colspan="3">Actions</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <td class="table-text">
                                    {{ $record->first_name }} {{ $record->last_name }}
                                </td>
                                <td class="table-text">
                                    {{ $record->race_name }}
                                </td>
                                <td class="table-text">
                                    {{ $record->race_date }}
                                </td>
                                <td class="table-text">
                                    {{ $record->race_location }}
                                </td>
                                <td width="50">
                                    <form action="record/{{ $record->id }}" method="GET">
                                        {{ csrf_field() }}
                                        <button class="btn btn-xs btn-info">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            View
                                        </button>
                                    </form>
                                </td>
                                <td width="50">
                                    <form action="record/{{ $record->id }}/edit" method="GET">
                                        {{ csrf_field() }}
                                        <button class="btn btn-xs btn-primary">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            Edit
                                        </button>
                                    </form>
                                </td>
                                <td width="50">
                                    <form action="record/{{ $record->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-xs btn-danger">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
