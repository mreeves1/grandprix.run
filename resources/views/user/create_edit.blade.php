@extends('layouts.app')

@section('content')

    <!-- Display Validation Errors -->
    @include('common.errors')

    <div class="container-fluid">

        <!-- New Task Form -->
        @if (isset($user))
            {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}
        @else
            {!! Form::open(['route' => 'user.store', 'class' => 'form-horizontal']) !!}
        @endif

            <div class="form-group">
                {!! Form::label('first_name', 'First Name', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password_raw', 'Password', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::password('password_raw', old('password_raw'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password_confirm', 'Password Confirm', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::password('password_confirm', old('password_confirm'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('birth_date', 'Birth Date', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::date('birth_date', old('birth_date'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('role_id', 'Role', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('gender_id', 'Gender', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('gender_id', $genders, old('gender_id'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
               {!! Form::label('club_id', 'Club', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('club_id', $clubs, old('club_id'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
               {!! Form::label('active', 'Status', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('active', $status, old('active'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> @if (isset($user)) Edit @else Add @endif User
                    </button>
                    <a role="button" class="btn btn-link" href="{{ URL::route('user.index') }}">Cancel</a>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection
