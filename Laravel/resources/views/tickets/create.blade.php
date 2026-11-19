
@extends('layout')

@section('content')

    <h2>Add New Ticket</h2>

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf

        <label>Purchase Date:</label>
        <input type="datetime-local" name="purchase_date"
               value="{{ old('purchase_date') }}" required>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" min="0"
               value="{{ old('price') }}" required>

        <label>Ticket Type:</label>
        <input type="text" name="ticket_type"
               value="{{ old('ticket_type') }}" required>

        <label>Visitor:</label>
        <select name="visitor_id" required>
            <option value="">Select Visitor</option>
            @foreach($visitors as $visitor)
                <option value="{{ $visitor->id }}"
                    {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}>
                    {{ $visitor->first_name }} {{ $visitor->last_name }}
                </option>
            @endforeach
        </select>

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

        <button type="submit">Save Ticket</button>
    </form>

    <br>

    <a href="{{ route('tickets.index') }}">Back to Tickets</a>

@endsection
