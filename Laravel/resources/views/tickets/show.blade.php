
@extends('layout')

@section('content')

    <h2>Ticket Details</h2>

    <p><strong>ID:</strong> {{ $ticket->id }}</p>

    <p><strong>Purchase Date:</strong> {{ $ticket->purchase_date }}</p>

    <p><strong>Price:</strong> {{ $ticket->price }}</p>

    <p><strong>Ticket Type:</strong> {{ $ticket->ticket_type }}</p>

    <p><strong>Visitor:</strong>
        {{ $ticket->visitor->first_name }} {{ $ticket->visitor->last_name }}
    </p>

    <p><strong>Exhibition:</strong> {{ $ticket->exhibition->name }}</p>

    <a href="{{ route('tickets.edit', $ticket->id) }}">Edit Ticket</a>

    <br><br>

    <a href="{{ route('tickets.index') }}">Back to Tickets</a>

@endsection
