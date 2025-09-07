@extends('layouts.app')
@section('title', 'Invoice Details')
@section('content')
    <h1>Invoice Details</h1>
    <div class="card mb-4">
        <div class="card-body">
            <h4>Client: {{ $invoice->client->name ?? '-' }}</h4>
            <p><strong>Status:</strong>
                <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </p>
            <p><strong>Total:</strong> ₨ {{ number_format($invoice->total, 2) }}</p>
            <p><strong>Due Date:</strong>
                {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') : '-' }}</p>
            <p><strong>Date:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
            @if($invoice->quotation)
                <p><strong>Linked Quotation:</strong> <a
                        href="{{ route('quotations.show', $invoice->quotation) }}">#{{ $invoice->quotation->id }}</a></p>
            @endif
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
            @foreach($invoice->items as $invitem)
                <tr>
                    <td>{{ $invitem->item->name ?? '-' }}</td>
                    <td>{{ $invitem->qty }}</td>
                    <td>₨ {{ number_format($invitem->price, 2) }}</td>
                    <td>₨ {{ number_format($invitem->qty * $invitem->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success" target="_blank">Generate PDF</a>
@endsection