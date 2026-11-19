@extends('layout')
@section('content')
<h2>Exhibitions</h2>
<a href="{{ route('exhibitions.create') }}">Add New Exhibition</a>
<form method="GET" style="margin: 1em 0">
 <label>name: <input name="name" value="{{ request('name') }}"></label>  <label>description: <input name="description" value="{{ request('description') }}"></label>  <label>start_date: <input name="start_date" value="{{ request('start_date') }}"></label>  <label>end_date: <input name="end_date" value="{{ request('end_date') }}"></label>  <label>Кількість на сторінці: <input type="number" name="itemsPerPage" min="1" max="100" value="{{ request('itemsPerPage', 10) }}"></label><button>Фільтрувати</button></form>
<table><tr><th>ID</th><th>Name</th><th>Description</th><th>Start date</th><th>End date</th></tr>
@foreach($exhibitions as $exhibition)<tr><td>{{ $exhibition->id }}</td><td>{{ $exhibition->name }}</td><td>{{ $exhibition->description }}</td><td>{{ $exhibition->start_date }}</td><td>{{ $exhibition->end_date }}</td></tr>@endforeach</table>
{{ $exhibitions->links() }}
@endsection
