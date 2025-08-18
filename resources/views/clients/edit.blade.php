@extends('layouts.app')
@section('title', 'Edit Client')
@section('content')
    <h1>Edit Client</h1>
    <form method="POST" action="{{ route('clients.update', $client) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ old('address', $client->address) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Client</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection