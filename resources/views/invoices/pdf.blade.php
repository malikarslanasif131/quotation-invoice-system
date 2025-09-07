<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .table { width: 100%; border-collapse: collapse;}
        .table th, .table td { border: 1px solid #333; padding: 8px; }
        .table th { background: #eee; }
    </style>
</head>
<body>
    <h2>Invoice #{{ $invoice->id }}</h2>
    <p><strong>Client:</strong> {{ $invoice->client->name ?? '-' }}</p>
    <p><strong>Email:</strong> {{ $invoice->client->email ?? '-' }}</p>
    <p><strong>Phone:</strong> {{ $invoice->client->phone ?? '-' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
    <p><strong>Due Date:</strong> {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') : '-' }}</p>
    <hr>
    <table class="table">
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
    <h3>Total: ₨ {{ number_format($invoice->total, 2) }}</h3>
    <hr>
    <p><small>Generated on {{ now()->format('d M Y') }}</small></p>
</body>
</html>