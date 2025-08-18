@extends('layouts.app')
@section('title', 'Invoices')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Invoices</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">Create Invoice</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Total</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td><a href="{{ route('invoices.show', $invoice) }}">{{ $invoice->id }}</a></td>
                    <td>{{ $invoice->client->name ?? '-' }}</td>
                    <td>₨ {{ number_format($invoice->total, 2) }}</td>
                    <td>
                        <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td>{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') : '-' }}</td>
                    <td>{{ $invoice->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete invoice?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $invoices->links() }}
@endsection