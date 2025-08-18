@extends('layouts.app')
@section('title', 'Clients')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Clients</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">Add Client</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td><a href="{{ route('clients.show', $client) }}">{{ $client->name }}</a></td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->address }}</td>
                    <td>
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete client?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->links() }}
@endsection