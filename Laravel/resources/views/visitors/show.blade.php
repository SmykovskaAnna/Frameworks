
@extends('layout')

@section('content')

    <h2>Visitor Details</h2>

    <p><strong>ID:</strong> {{ $visitor->id }}</p>

    <p><strong>First Name:</strong> {{ $visitor->first_name }}</p>

    <p><strong>Last Name:</strong> {{ $visitor->last_name }}</p>

    <p><strong>Email:</strong> {{ $visitor->email }}</p>

    <a href="{{ route('visitors.edit', $visitor->id) }}">Edit Visitor</a>

    <br><br>

    <a href="{{ route('visitors.index') }}">Back to Visitors</a>

@endsection
