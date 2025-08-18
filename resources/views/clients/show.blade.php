@extends('layouts.app')
@section('title', 'Client Details')
@section('content')
    <h1>Client Details</h1>
    <div class="card mb-4">
        <div class="card-body">
            <h4>{{ $client->name }}</h4>
            <p><strong>Email:</strong> {{ $client->email }}</p>
            <p><strong>Phone:</strong> {{ $client->phone }}</p>
            <p><strong>Address:</strong> {{ $client->address }}</p>
        </div>
    </div>
    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back to List</a>
@endsection