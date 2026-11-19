
@extends('layout')

@section('content')

    <h2>Edit Exhibition</h2>

    <form action="{{ route('exhibitions.update', $exhibition->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name', $exhibition->name) }}" required>

        <label>Description:</label>
        <textarea name="description" required>{{ old('description', $exhibition->description) }}</textarea>

        <label>Start Date:</label>
        <input type="date" name="start_date" value="{{ old('start_date', $exhibition->start_date) }}" required>

        <label>End Date:</label>
        <input type="date" name="end_date" value="{{ old('end_date', $exhibition->end_date) }}" required>

        <button type="submit">Update Exhibition</button>
    </form>

    <br>

    <a href="{{ route('exhibitions.index') }}">Back to Exhibitions</a>

@endsection
