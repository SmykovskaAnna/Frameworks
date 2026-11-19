
@extends('layout')

@section('content')

    <h2>Exhibits</h2>

    <a href="{{ route('exhibits.create') }}">Add New Exhibit</a>

    <br><br>

    <form method="GET" style="margin: 1em 0">
 <label>name: <input name="name" value="{{ request('name') }}"></label>  <label>description: <input name="description" value="{{ request('description') }}"></label>  <label>author: <input name="author" value="{{ request('author') }}"></label>  <label>creation_date: <input name="creation_date" value="{{ request('creation_date') }}"></label>  <label>Кількість на сторінці: <input type="number" name="itemsPerPage" min="1" max="100" value="{{ request('itemsPerPage', 10) }}"></label><button>Фільтрувати</button></form>
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

{{ $exhibits->links() }}
@endsection
