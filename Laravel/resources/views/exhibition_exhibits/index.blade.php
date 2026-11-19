
@extends('layout')

@section('content')

    <h2>Exhibition Exhibits</h2>

    <a href="{{ route('exhibition-exhibits.create') }}">Add Exhibit to Exhibition</a>

    <br><br>

    <form method="GET" style="margin: 1em 0">
 <label>display_order: <input name="display_order" value="{{ request('display_order') }}"></label>  <label>exhibition_id: <input name="exhibition_id" value="{{ request('exhibition_id') }}"></label>  <label>exhibit_id: <input name="exhibit_id" value="{{ request('exhibit_id') }}"></label>  <label>Кількість на сторінці: <input type="number" name="itemsPerPage" min="1" max="100" value="{{ request('itemsPerPage', 10) }}"></label><button>Фільтрувати</button></form>
<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Exhibition</th>
                <th>Exhibit</th>
                <th>Display Order</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($exhibitionExhibits as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->exhibition->name }}</td>
                    <td>{{ $item->exhibit->name }}</td>
                    <td>{{ $item->display_order }}</td>
                    <td>
                        <a href="{{ route('exhibition-exhibits.show', $item->id) }}">View</a>

                        <a href="{{ route('exhibition-exhibits.edit', $item->id) }}">Edit</a>

                        <form action="{{ route('exhibition-exhibits.destroy', $item->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Delete this record?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

{{ $exhibitionExhibits->links() }}
@endsection
