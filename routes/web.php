<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clients
    Route::resource('clients', ClientController::class);

    // Items
    Route::resource('items', ItemController::class);

    // Quotations
    Route::resource('quotations', QuotationController::class);

    // Convert Quotation to Invoice
    Route::post('quotations/{quotation}/convert', [QuotationController::class, 'convertToInvoice'])
        ->name('quotations.convert');

    // Invoices
    Route::resource('invoices', InvoiceController::class);

    // Download Invoice PDF
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'downloadPDF'])
        ->name('invoices.download');
});

// Auth scaffolding (Breeze)
require __DIR__ . '/auth.php';