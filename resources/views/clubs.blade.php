@extends('layouts.app')

@section('content')

    <!-- Display Validation Errors -->
    @include('common.errors')

    <div class="container-fluid">

        <!-- New Task Form -->
        <form action="/club" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="club_name" class="col-sm-3 control-label">Name</label>

                <div class="col-sm-6">
                    <input type="text" name="club_name" id="club_name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="club_city" class="col-sm-3 control-label">City</label>

                <div class="col-sm-6">
                    <input type="text" name="club_city" id="club_city" class="form-control">
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
                                    <!-- TODO: Delete Button -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
