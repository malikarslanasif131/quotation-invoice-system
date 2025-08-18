@extends('layouts.app')
@section('title', 'Items')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Items</h1>
        <a href="{{ route('items.create') }}" class="btn btn-primary">Add Item</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price (₨)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td><a href="{{ route('items.show', $item) }}">{{ $item->name }}</a></td>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
@endsection