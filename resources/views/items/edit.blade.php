@extends('layouts.app')
@section('title', 'Edit Item')
@section('content')
    <h1>Edit Item</h1>
    <form method="POST" action="{{ route('items.update', $item) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $item->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Price (₨)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $item->price) }}"
                required>
        </div>
        <button type="submit" class="btn btn-success">Update Item</button>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection