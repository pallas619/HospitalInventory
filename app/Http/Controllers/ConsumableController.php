<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsumableController extends Controller
{
    public function index()
    {
        $consumables = Consumable::with('item')->get();
        return view('consumables.index', compact('consumables'));
    }

    public function create()
    {
        $items = Item::all();
        return view('consumables.create', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'usage_type' => 'required|string|max:255',
            'sterilization_status' => 'required|in:Sterilized,Not Sterilized',
            'expiry_date' => 'required|date',
        ]);

        DB::transaction(function () use ($data) {
            $item = Item::create([
                'name' => $data['name'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'item_type' => 'consumable',
            ]);

            Consumable::create([
                'item_id' => $item->id,
                'usage_type' => $data['usage_type'],
                'sterilization_status' => $data['sterilization_status'],
                'expiry_date' => $data['expiry_date'],
            ]);

            $this->recordStockTransaction($item->id, $data['quantity'], 'in');
        });

        return redirect()->route('consumables.index')->with('message', 'Barang habis pakai berhasil ditambahkan');
    }

    public function show($id)
    {
        $consumable = Consumable::with('item')->findOrFail($id);
        return response()->json($consumable);
    }

    public function edit($id)
    {
        $consumable = Consumable::with('item')->findOrFail($id);
        $items = Item::all();
        return view('consumables.edit', compact('consumable', 'items'));
    }

    public function update(Request $request, $id)
    {
        $consumable = Consumable::findOrFail($id);
        $item = Item::findOrFail($consumable->item_id);

        $data = $request->validate([
            'name' => 'string|max:255',
            'quantity' => 'integer',
            'price' => 'decimal:0,2',
            'usage_type' => 'string|max:255',
            'sterilization_status' => 'in:Sterilized,Not Sterilized',
            'expiry_date' => 'date',
        ]);

        DB::transaction(function () use ($data, $item, $consumable) {
            $quantityDiff = $data['quantity'] - $item->quantity;

            $item->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
            ]);

            $consumable->update([
                'usage_type' => $data['usage_type'],
                'sterilization_status' => $data['sterilization_status'],
                'expiry_date' => $data['expiry_date'],
            ]);

            if ($quantityDiff != 0) {
                $this->recordStockTransaction($item->id, abs($quantityDiff), $quantityDiff > 0 ? 'in' : 'out');
            }
        });

        return redirect()->route('consumables.index')->with('message', 'Barang habis pakai berhasil diperbarui');
    }

    public function destroy($id)
    {
        $consumable = Consumable::findOrFail($id);
        $item = Item::findOrFail($consumable->item_id);

        try {
            DB::transaction(function () use ($item, $consumable) {
                if ($item->quantity > 0) {
                    $this->recordStockTransaction($item->id, $item->quantity, 'out', 'Penghapusan item barang habis pakai');
                }

                StockTransaction::where('item_id', $item->id)->delete();
                $consumable->delete();
                $item->delete();
            });

            return redirect()->route('consumables.index')->with('message', 'Barang habis pakai berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('consumables.index')->with('error', 'Gagal menghapus barang habis pakai: ' . $e->getMessage());
        }
    }

    private function recordStockTransaction($itemId, $quantity, $type, $notes = null)
    {
        StockTransaction::create([
            'item_id' => $itemId,
            'user_id' => Auth::user()->id ?? 1, // Gunakan auth jika tersedia, fallback ke 1
            'quantity' => $quantity,
            'transaction_type' => $type,
            'transaction_date' => now(),
            'notes' => $notes,
        ]);
    }
}
