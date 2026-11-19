
@extends('layout')

@section('content')

    <h2>Exhibition Exhibit Details</h2>

    <p><strong>ID:</strong> {{ $exhibitionExhibit->id }}</p>

    <p><strong>Exhibition:</strong> {{ $exhibitionExhibit->exhibition->name }}</p>

    <p><strong>Exhibit:</strong> {{ $exhibitionExhibit->exhibit->name }}</p>

    <p><strong>Display Order:</strong> {{ $exhibitionExhibit->display_order }}</p>

    <a href="{{ route('exhibition-exhibits.edit', $exhibitionExhibit->id) }}">Edit</a>

    <br><br>

    <a href="{{ route('exhibition-exhibits.index') }}">Back</a>

@endsection
