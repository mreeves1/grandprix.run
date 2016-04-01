@extends('layouts.app')

@section('content')

    <!-- Display Validation Messages and Errors -->
    @include('common.success')
    @include('common.errors')


    <div class="panel panel-default">
        <div class="panel-heading" style="">
            <h4 style="display:inline-block">Users</h4>
            <div style="float:right;">
                <form action="user/create" method="GET">
                    {{ csrf_field() }}
                    <button class="btn btn-success">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Add New User
                    </button>
                </form>
            </div>
        </div>

        <div class="panel-body">
            @if (count($users) > 0)
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Name</th>
                        <th>Club</th>
                        <th>Role</th>
                        <th colspan="3">Actions</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="table-text">
                                    <a href="mailto:{{ $user->email }}">{{ $user->first_name }} {{ $user->last_name }}</a>
                                </td>
                                <td class="table-text">
                                    {!! $clubs[$user->club_id] !!}
                                </td>
                                <td class="table-text">
                                    {!! $roles[$user->role_id] !!}
                                </td>
                                <td width="50">
                                    <form action="user/{{ $user->id }}" method="GET">
                                        {{ csrf_field() }}
                                        <button class="btn btn-xs btn-info">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            View
                                        </button>
                                    </form>
                                </td>
                                <td width="50">
                                    <form action="user/{{ $user->id }}/edit" method="GET">
                                        {{ csrf_field() }}
                                        <button class="btn btn-xs btn-primary">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            Edit
                                        </button>
                                    </form>
                                </td>
                                <td width="50">
                                    <form action="user/{{ $user->id }}" method="POST">
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
