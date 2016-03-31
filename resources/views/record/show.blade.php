@extends('layouts.app')

@section('content')
    <!-- Display Validation Errors -->
    @include('common.errors')

    <div class="container-fluid">
        <h4>Athlete Info:</h4>
        <strong>Id:</strong> {{ $record->id }}<br/>
        <strong>First Name:</strong> {{ $record->first_name }}<br/>
        <strong>Last Name:</strong> {{ $record->last_name }}<br/>
        <strong>Gender:</strong> {!! $genders[$record->gender_id] !!}<br/>
        <strong>Age:</strong> {{ $record->age }}<br/>
        <strong>Birth Date:</strong> {{ $record->birth_date }}<br/>
        <hr/>
        <h4>Race Info:</h4>
        <strong>Race Name:</strong> {{ $record->race_name }}<br/>
        <strong>Race Date:</strong> {{ $record->race_date }}<br/>
        <strong>Race Location:</strong> {{ $record->race_location }}<br/>
        <strong>Race Notes:</strong> {{ $record->race_notes }}<br/>
        <strong>Distance:</strong> {!! $distances[$record->distance_id] !!}<br/>
        <strong>Active:</strong> {!! $status[$record->active] !!}<br/>
    </div>
@endsection
