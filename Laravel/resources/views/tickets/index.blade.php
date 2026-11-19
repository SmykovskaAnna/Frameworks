
@extends('layout')

@section('content')

    <h2>Tickets</h2>

    <a href="{{ route('tickets.create') }}">Add New Ticket</a>

    <br><br>

    <form method="GET" style="margin: 1em 0">
 <label>purchase_date: <input name="purchase_date" value="{{ request('purchase_date') }}"></label>  <label>price: <input name="price" value="{{ request('price') }}"></label>  <label>ticket_type: <input name="ticket_type" value="{{ request('ticket_type') }}"></label>  <label>visitor_id: <input name="visitor_id" value="{{ request('visitor_id') }}"></label>  <label>exhibition_id: <input name="exhibition_id" value="{{ request('exhibition_id') }}"></label>  <label>Кількість на сторінці: <input type="number" name="itemsPerPage" min="1" max="100" value="{{ request('itemsPerPage', 10) }}"></label><button>Фільтрувати</button></form>
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

{{ $tickets->links() }}
@endsection
