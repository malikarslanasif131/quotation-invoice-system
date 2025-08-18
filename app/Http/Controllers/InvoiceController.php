<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Item;
use App\Models\Quotation;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('client')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $items = Item::all();
        $quotations = Quotation::all();
        return view('invoices.create', compact('clients', 'items', 'quotations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'quotation_id' => 'nullable|exists:quotations,id',
            'due_date' => 'nullable|date',
            'status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'client_id' => $validated['client_id'],
                'quotation_id' => $validated['quotation_id'] ?? null,
                'due_date' => $validated['due_date'] ?? null,
                'status' => $validated['status'],
                'total' => 0, // will update after items
            ]);

            $total = 0;
            foreach ($validated['items'] as $invitem) {
                $item = Item::find($invitem['item_id']);
                $itemTotal = $item->price * $invitem['qty'];
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $item->id,
                    'qty' => $invitem['qty'],
                    'price' => $item->price,
                ]);
                $total += $itemTotal;
            }
            $invoice->update(['total' => $total]);
            DB::commit();
            return redirect()->route('invoices.index')->with('success', 'Invoice created!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['client', 'items.item', 'quotation'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        $clients = Client::all();
        $items = Item::all();
        $quotations = Quotation::all();
        return view('invoices.edit', compact('invoice', 'clients', 'items', 'quotations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'quotation_id' => 'nullable|exists:quotations,id',
            'due_date' => 'nullable|date',
            'status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $invoice->update([
                'client_id' => $validated['client_id'],
                'quotation_id' => $validated['quotation_id'] ?? null,
                'due_date' => $validated['due_date'] ?? null,
                'status' => $validated['status'],
            ]);
            // Remove old items
            InvoiceItem::where('invoice_id', $invoice->id)->delete();

            $total = 0;
            foreach ($validated['items'] as $invitem) {
                $item = Item::find($invitem['item_id']);
                $itemTotal = $item->price * $invitem['qty'];
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $item->id,
                    'qty' => $invitem['qty'],
                    'price' => $item->price,
                ]);
                $total += $itemTotal;
            }
            $invoice->update(['total' => $total]);
            DB::commit();
            return redirect()->route('invoices.index')->with('success', 'Invoice updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->items()->delete();
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted!');
    }
}