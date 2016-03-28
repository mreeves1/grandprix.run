@extends('layouts.app')

@section('content')
    <!-- Display Validation Errors -->
    @include('common.errors')

    <div class="container-fluid">
        <strong>Id:</strong> {{ $club->id }}<br/>
        <strong>Name:</strong> {{ $club->name }}<br/>
        <strong>City:</strong> {{ $club->city }}<br/>
        <strong>State:</strong> {{ $club->state }}<br/>
        <strong>Zip Code:</strong> {{ $club->zip_code }}<br/>
        <hr/>
        <strong>Contact Name:</strong> {{ $club->contact_name }}<br/>
        <strong>Contact Email:</strong> {{ $club->contact_email }}<br/>
        <strong>Contact Website:</strong> {{ $club->contact_website }}<br/>
        <strong>Contact Phone:</strong> {{ $club->contact_phone }}<br/>
    </div>
@endsection
