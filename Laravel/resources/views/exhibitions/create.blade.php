
@extends('layout')

@section('content')

    <h2>Add New Exhibition</h2>

    <form action="{{ route('exhibitions.store') }}" method="POST">
        @csrf

        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Description:</label>
        <textarea name="description" required>{{ old('description') }}</textarea>

        <label>Start Date:</label>
        <input type="date" name="start_date" value="{{ old('start_date') }}" required>

        <label>End Date:</label>
        <input type="date" name="end_date" value="{{ old('end_date') }}" required>

        <button type="submit">Save Exhibition</button>
    </form>

    <br>

    <a href="{{ route('exhibitions.index') }}">Back to Exhibitions</a>

@endsection
