
@extends('layout')

@section('content')

    <h2>Add New Exhibit</h2>

    <form action="{{ route('exhibits.store') }}" method="POST">
        @csrf

        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Description:</label>
        <textarea name="description" required>{{ old('description') }}</textarea>

        <label>Author:</label>
        <input type="text" name="author" value="{{ old('author') }}" required>

        <label>Creation Date:</label>
        <input type="date" name="creation_date" value="{{ old('creation_date') }}" required>

        <button type="submit">Save Exhibit</button>
    </form>

    <br>

    <a href="{{ route('exhibits.index') }}">Back to Exhibits</a>

@endsection
