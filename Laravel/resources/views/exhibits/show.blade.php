
@extends('layout')

@section('content')

    <h2>Exhibit Details</h2>

    <p><strong>ID:</strong> {{ $exhibit->id }}</p>

    <p><strong>Name:</strong> {{ $exhibit->name }}</p>

    <p><strong>Description:</strong> {{ $exhibit->description }}</p>

    <p><strong>Author:</strong> {{ $exhibit->author }}</p>

    <p><strong>Creation Date:</strong> {{ $exhibit->creation_date }}</p>

    <a href="{{ route('exhibits.edit', $exhibit->id) }}">Edit Exhibit</a>

    <br><br>

    <a href="{{ route('exhibits.index') }}">Back to Exhibits</a>

@endsection
