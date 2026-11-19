
@extends('layout')

@section('content')

    <h2>Visitors</h2>

    <a href="{{ route('visitors.create') }}">Add New Visitor</a>

    <br><br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($visitors as $visitor)
                <tr>
                    <td>{{ $visitor->id }}</td>
                    <td>{{ $visitor->first_name }}</td>
                    <td>{{ $visitor->last_name }}</td>
                    <td>{{ $visitor->email }}</td>
                    <td>
                        <a href="{{ route('visitors.show', $visitor->id) }}">View</a>

                        <a href="{{ route('visitors.edit', $visitor->id) }}">Edit</a>

                        <form action="{{ route('visitors.destroy', $visitor->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Delete this visitor?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No visitors found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
 