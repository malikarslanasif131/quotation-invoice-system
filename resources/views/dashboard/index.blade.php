@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h2 class="text-success">₨ {{ number_format($totalRevenue, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Pending Payments</h5>
                    <h2 class="text-danger">₨ {{ number_format($pendingPayments, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Clients</h5>
                    <h2>{{ $totalClients }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Quotations</h5>
                    <h2>{{ $totalQuotations }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Invoices</h5>
                    <h2>{{ $totalInvoices }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Items</h5>
                    <h2>{{ $totalItems }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h4>Recent Invoices</h4>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentInvoices as $invoice)
                        <tr>
                            <td><a href="{{ route('invoices.show', $invoice) }}">{{ $invoice->id }}</a></td>
                            <td>{{ $invoice->client->name ?? '-' }}</td>
                            <td>₨ {{ number_format($invoice->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>{{ $invoice->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h4>Recent Quotations</h4>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentQuotations as $quotation)
                        <tr>
                            <td><a href="{{ route('quotations.show', $quotation) }}">{{ $quotation->id }}</a></td>
                            <td>{{ $quotation->client->name ?? '-' }}</td>
                            <td>₨ {{ number_format($quotation->total, 2) }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($quotation->status) }}</span>
                            </td>
                            <td>{{ $quotation->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No quotations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection