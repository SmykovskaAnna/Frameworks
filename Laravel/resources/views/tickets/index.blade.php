
@extends('layout')

@section('content')

    <h2>Tickets</h2>

    <a href="{{ route('tickets.create') }}">Add New Ticket</a>

    <br><br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Purchase Date</th>
                <th>Price</th>
                <th>Ticket Type</th>
                <th>Visitor</th>
                <th>Exhibition</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->purchase_date }}</td>
                    <td>{{ $ticket->price }}</td>
                    <td>{{ $ticket->ticket_type }}</td>
                    <td>{{ $ticket->visitor->first_name }} {{ $ticket->visitor->last_name }}</td>
                    <td>{{ $ticket->exhibition->name }}</td>
                    <td>
                        <a href="{{ route('tickets.show', $ticket->id) }}">View</a>

                        <a href="{{ route('tickets.edit', $ticket->id) }}">Edit</a>

                        <form action="{{ route('tickets.destroy', $ticket->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Delete this ticket?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No tickets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
