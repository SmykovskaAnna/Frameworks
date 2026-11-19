
@extends('layout')

@section('content')

    <h2>Add New Visitor</h2>

    <form action="{{ route('visitors.store') }}" method="POST">
        @csrf

        <label>First Name:</label>
        <input type="text" name="first_name" value="{{ old('first_name') }}" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="{{ old('last_name') }}" required>

        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <button type="submit">Save Visitor</button>
    </form>

    <br>

    <a href="{{ route('visitors.index') }}">Back to Visitors</a>

@endsection
