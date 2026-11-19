
@extends('layout')

@section('content')

    <h2>Edit Visitor</h2>

    <form action="{{ route('visitors.update', $visitor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>First Name:</label>
        <input type="text" name="first_name"
               value="{{ old('first_name', $visitor->first_name) }}" required>

        <label>Last Name:</label>
        <input type="text" name="last_name"
               value="{{ old('last_name', $visitor->last_name) }}" required>

        <label>Email:</label>
        <input type="email" name="email"
               value="{{ old('email', $visitor->email) }}" required>

        <button type="submit">Update Visitor</button>
    </form>

    <br>

    <a href="{{ route('visitors.index') }}">Back to Visitors</a>

@endsection
