<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Client;
use App\Models\Item;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::with('client')->latest()->paginate(10);
        return view('quotations.index', compact('quotations'));
    }

    public function create()
    {
        $clients = Client::all();
        $items = Item::all();
        return view('quotations.create', compact('clients', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $quotation = Quotation::create([
                'client_id' => $validated['client_id'],
                'status' => 'draft',
                'total' => 0, // Will update after items
            ]);

            $total = 0;
            foreach ($validated['items'] as $qitem) {
                $item = Item::find($qitem['item_id']);
                $itemTotal = $item->price * $qitem['qty'];
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'item_id' => $item->id,
                    'qty' => $qitem['qty'],
                    'price' => $item->price,
                ]);
                $total += $itemTotal;
            }
            $quotation->update(['total' => $total]);
            DB::commit();
            return redirect()->route('quotations.index')->with('success', 'Quotation created!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating quotation: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $quotation = Quotation::with(['client', 'items.item'])->findOrFail($id);
        return view('quotations.show', compact('quotation'));
    }

    public function edit($id)
    {
        $quotation = Quotation::with(['items'])->findOrFail($id);
        $clients = Client::all();
        $items = Item::all();
        return view('quotations.edit', compact('quotation', 'clients', 'items'));
    }

    public function update(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $quotation->update([
                'client_id' => $validated['client_id'],
                'status' => $quotation->status,
            ]);
            // Remove old items
            QuotationItem::where('quotation_id', $quotation->id)->delete();

            $total = 0;
            foreach ($validated['items'] as $qitem) {
                $item = Item::find($qitem['item_id']);
                $itemTotal = $item->price * $qitem['qty'];
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'item_id' => $item->id,
                    'qty' => $qitem['qty'],
                    'price' => $item->price,
                ]);
                $total += $itemTotal;
            }
            $quotation->update(['total' => $total]);
            DB::commit();
            return redirect()->route('quotations.index')->with('success', 'Quotation updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating quotation: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->items()->delete();
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', 'Quotation deleted!');
    }
}
