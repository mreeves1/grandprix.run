@extends('layouts.app')

@section('content')

    <!-- Display Validation Messages and Errors -->
    @include('common.success')
    @include('common.errors')


    <div class="panel panel-default">
        <div class="panel-heading" style="">
            <h4 style="display:inline-block">Running Clubs</h4>
            <div style="float:right;">
                <form action="club/create" method="GET">
                    {{ csrf_field() }}
                    <button class="btn btn-success">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Add New Club
                    </button>
                </form>
            </div>
        </div>

        <div class="panel-body">
            @if (count($clubs) > 0)
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Name</th>
                        <th>Location</th>
                        <th colspan="3">Actions</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($clubs as $club)
                            <tr>
                                <td class="table-text">
                                    {{ $club->name }}
                                </td>
                                <td class="table-text">
                                    {{ $club->city }}, {{ $club->state }}
                                </td>
                                <td width="50">
                                    <form action="club/{{ $club->id }}" method="GET">
                                        {{ csrf_field() }}
                                        <button class="btn btn-xs btn-info">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            View
                                        </button>
                                    </form>
                                </td>
                                <td width="50">
                                    <form action="club/{{ $club->id }}/edit" method="GET">
                                        {{ csrf_field() }}
                                        <button class="btn btn-xs btn-primary">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            Edit
                                        </button>
                                    </form>
                                </td>
                                <td width="50">
                                    <form action="club/{{ $club->id }}" method="POST">
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
