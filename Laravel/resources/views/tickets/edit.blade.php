
@extends('layout')

@section('content')

    <h2>Edit Ticket</h2>

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Purchase Date:</label>
        <input type="datetime-local" name="purchase_date"
               value="{{ old('purchase_date', $ticket->purchase_date->format('Y-m-d\TH:i')) }}"
               required>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" min="0"
               value="{{ old('price', $ticket->price) }}" required>

        <label>Ticket Type:</label>
        <input type="text" name="ticket_type"
               value="{{ old('ticket_type', $ticket->ticket_type) }}" required>

        <label>Visitor:</label>
        <select name="visitor_id" required>
            @foreach($visitors as $visitor)
                <option value="{{ $visitor->id }}"
                    {{ old('visitor_id', $ticket->visitor_id) == $visitor->id ? 'selected' : '' }}>
                    {{ $visitor->first_name }} {{ $visitor->last_name }}
                </option>
            @endforeach
        </select>

        <label>Exhibition:</label>
        <select name="exhibition_id" required>
            @foreach($exhibitions as $exhibition)
                <option value="{{ $exhibition->id }}"
                    {{ old('exhibition_id', $ticket->exhibition_id) == $exhibition->id ? 'selected' : '' }}>
                    {{ $exhibition->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Update Ticket</button>
    </form>

    <br>

    <a href="{{ route('tickets.index') }}">Back to Tickets</a>

@endsection
