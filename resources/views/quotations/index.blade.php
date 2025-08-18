@extends('layouts.app')
@section('title', 'Quotations')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quotations</h1>
        <a href="{{ route('quotations.create') }}" class="btn btn-primary">Create Quotation</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotations as $quotation)
                <tr>
                    <td><a href="{{ route('quotations.show', $quotation) }}">{{ $quotation->id }}</a></td>
                    <td>{{ $quotation->client->name ?? '-' }}</td>
                    <td>₨ {{ number_format($quotation->total, 2) }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($quotation->status) }}</span></td>
                    <td>{{ $quotation->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('quotations.destroy', $quotation) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete quotation?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $quotations->links() }}
@endsection