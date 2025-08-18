@extends('layouts.app')
@section('title', 'Item Details')
@section('content')
    <h1>Item Details</h1>
    <div class="card mb-4">
        <div class="card-body">
            <h4>{{ $item->name }}</h4>
            <p><strong>Description:</strong> {{ $item->description }}</p>
            <p><strong>Price:</strong> ₨ {{ number_format($item->price, 2) }}</p>
        </div>
    </div>
    <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('items.index') }}" class="btn btn-secondary">Back to List</a>
@endsection