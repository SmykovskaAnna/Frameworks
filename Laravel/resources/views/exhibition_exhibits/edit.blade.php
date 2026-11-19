
@extends('layout')

@section('content')

    <h2>Edit Exhibition Exhibit</h2>

    <form action="{{ route('exhibition-exhibits.update', $exhibitionExhibit->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Exhibition:</label>
        <select name="exhibition_id" required>
            @foreach($exhibitions as $exhibition)
                <option value="{{ $exhibition->id }}"
                    {{ old('exhibition_id', $exhibitionExhibit->exhibition_id) == $exhibition->id ? 'selected' : '' }}>
                    {{ $exhibition->name }}
                </option>
            @endforeach
        </select>

        <label>Exhibit:</label>
        <select name="exhibit_id" required>
            @foreach($exhibits as $exhibit)
                <option value="{{ $exhibit->id }}"
                    {{ old('exhibit_id', $exhibitionExhibit->exhibit_id) == $exhibit->id ? 'selected' : '' }}>
                    {{ $exhibit->name }}
                </option>
            @endforeach
        </select>

        <label>Display Order:</label>
        <input type="number" name="display_order" min="1"
               value="{{ old('display_order', $exhibitionExhibit->display_order) }}" required>

        <button type="submit">Update</button>
    </form>

    <br>

    <a href="{{ route('exhibition-exhibits.index') }}">Back</a>

@endsection
