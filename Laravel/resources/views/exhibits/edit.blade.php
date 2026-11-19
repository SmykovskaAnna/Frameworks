
@extends('layout')

@section('content')

    <h2>Edit Exhibit</h2>

    <form action="{{ route('exhibits.update', $exhibit->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name', $exhibit->name) }}" required>

        <label>Description:</label>
        <textarea name="description" required>{{ old('description', $exhibit->description) }}</textarea>

        <label>Author:</label>
        <input type="text" name="author" value="{{ old('author', $exhibit->author) }}" required>

        <label>Creation Date:</label>
        <input type="date" name="creation_date" value="{{ old('creation_date', $exhibit->creation_date) }}" required>

        <button type="submit">Update Exhibit</button>
    </form>

    <br>

    <a href="{{ route('exhibits.index') }}">Back to Exhibits</a>

@endsection
