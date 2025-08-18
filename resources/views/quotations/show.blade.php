@extends('layouts.app')
@section('title', 'Quotation Details')
@section('content')
    <h1>Quotation Details</h1>
    <div class="card mb-4">
        <div class="card-body">
            <h4>Client: {{ $quotation->client->name ?? '-' }}</h4>
            <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($quotation->status) }}</span></p>
            <p><strong>Total:</strong> ₨ {{ number_format($quotation->total, 2) }}</p>
            <p><strong>Date:</strong> {{ $quotation->created_at->format('d M Y') }}</p>
        </div>
    </div>
    <h5>Items</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $qitem)
                <tr>
                    <td>{{ $qitem->item->name ?? '-' }}</td>
                    <td>{{ $qitem->qty }}</td>
                    <td>₨ {{ number_format($qitem->price, 2) }}</td>
                    <td>₨ {{ number_format($qitem->qty * $qitem->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Back to List</a>
@endsection