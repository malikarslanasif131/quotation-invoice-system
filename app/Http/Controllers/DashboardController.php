<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Invoice::where('status', 'paid')->sum('total');
        $pendingPayments = Invoice::where('status', 'pending')->sum('total');
        $totalClients = Client::count();
        $totalQuotations = Quotation::count();
        $totalInvoices = Invoice::count();
        $totalItems = Item::count();

        // Recent 5 invoices and quotations
        $recentInvoices = Invoice::with('client')->latest()->take(5)->get();
        $recentQuotations = Quotation::with('client')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalRevenue',
            'pendingPayments',
            'totalClients',
            'totalQuotations',
            'totalInvoices',
            'totalItems',
            'recentInvoices',
            'recentQuotations'
        ));
    }
}