@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Task Form -->
        <form action="/record" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="record_first_name" class="col-sm-3 control-label">First Name</label>

                <div class="col-sm-6">
                    <input type="text" name="first_name" id="record_first_name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="record_last_name" class="col-sm-3 control-label">Last Name</label>

                <div class="col-sm-6">
                    <input type="text" name="last_name" id="record_last_name" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Record
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Current Tasks -->
    @if (count($records) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Age Group Records
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Record Holder Name</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <!-- Task Name -->
                                <td class="table-text">
                                    <div>{{ $record->first_name }} {{ $record->last_name }}</div>
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
