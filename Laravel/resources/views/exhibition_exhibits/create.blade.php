
@extends('layout')

@section('content')

    <h2>Add Exhibit to Exhibition</h2>

    <form action="{{ route('exhibition-exhibits.store') }}" method="POST">
        @csrf

        <label>Exhibition:</label>
        <select name="exhibition_id" required>
            <option value="">Select Exhibition</option>

            @foreach($exhibitions as $exhibition)
                <option value="{{ $exhibition->id }}"
                    {{ old('exhibition_id') == $exhibition->id ? 'selected' : '' }}>
                    {{ $exhibition->name }}
                </option>
            @endforeach
        </select>

        <label>Exhibit:</label>
        <select name="exhibit_id" required>
            <option value="">Select Exhibit</option>

            @foreach($exhibits as $exhibit)
                <option value="{{ $exhibit->id }}"
                    {{ old('exhibit_id') == $exhibit->id ? 'selected' : '' }}>
                    {{ $exhibit->name }}
                </option>
            @endforeach
        </select>

        <label>Display Order:</label>
        <input type="number" name="display_order" min="1"
               value="{{ old('display_order') }}" required>

        <button type="submit">Save</button>
    </form>

    <br>

    <a href="{{ route('exhibition-exhibits.index') }}">Back</a>

@endsection
