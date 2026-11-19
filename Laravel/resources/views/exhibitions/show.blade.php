
@extends('layout')

@section('content')

    <h2>Exhibition Details</h2>

    <p><strong>ID:</strong> {{ $exhibition->id }}</p>

    <p><strong>Name:</strong> {{ $exhibition->name }}</p>

    <p><strong>Description:</strong> {{ $exhibition->description }}</p>

    <p><strong>Start Date:</strong> {{ $exhibition->start_date }}</p>

    <p><strong>End Date:</strong> {{ $exhibition->end_date }}</p>

    <a href="{{ route('exhibitions.edit', $exhibition->id) }}">Edit Exhibition</a>

    <br><br>

    <a href="{{ route('exhibitions.index') }}">Back to Exhibitions</a>

@endsection
