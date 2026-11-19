
@extends('layout')

@section('content')

    <h2>Exhibits</h2>

    <a href="{{ route('exhibits.create') }}">Add New Exhibit</a>

    <br><br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Author</th>
                <th>Creation Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($exhibits as $exhibit)
                <tr>
                    <td>{{ $exhibit->id }}</td>
                    <td>{{ $exhibit->name }}</td>
                    <td>{{ $exhibit->author }}</td>
                    <td>{{ $exhibit->creation_date }}</td>
                    <td>
                        <a href="{{ route('exhibits.show', $exhibit->id) }}">View</a>

                        <a href="{{ route('exhibits.edit', $exhibit->id) }}">Edit</a>

                        <form action="{{ route('exhibits.destroy', $exhibit->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Delete this exhibit?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No exhibits found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
