<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with('item')->paginate(10);
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create', [
            'items' => Item::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request, true);

        try {
            DB::beginTransaction();

            $item = $this->addItem($data);
            $this->addMedicine($item->id, $data);
            $this->logStockChange($item->id, $data['quantity'], 'in', 'Stok awal obat ditambahkan');

            DB::commit();

            return redirect()->route('medicines.index')->with('success', 'Obat berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan obat: ' . $e->getMessage());
        }
    }

    public function show(Medicine $medicine)
    {
        $medicine->load('item');
        return view('medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        $medicine->load('item');
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $data = $this->validateRequest($request);

        try {
            DB::beginTransaction();

            $item = $medicine->item;
            $oldQty = $item->quantity;
            $newQty = $data['quantity'] ?? $oldQty;

            $item->update([
                'name' => $data['name'] ?? $item->name,
                'price' => $data['price'] ?? $item->price,
                'quantity' => $newQty,
            ]);

            $medicine->update([
                'dosage' => $data['dosage'] ?? $medicine->dosage,
                'expiry_date' => $data['expiry_date'] ?? $medicine->expiry_date,
                'requires_prescription' => $data['requires_prescription'] ?? $medicine->requires_prescription,
            ]);

            if ($newQty !== $oldQty) {
                $type = $newQty > $oldQty ? 'in' : 'out';
                $note = $type === 'in' ? 'Stok ditambah' : 'Stok dikurangi';
                $this->logStockChange($item->id, abs($newQty - $oldQty), $type, $note);
            }

            DB::commit();
            return redirect()->route('medicines.index')->with('success', 'Obat berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui obat: ' . $e->getMessage());
        }
    }

    public function destroy(Medicine $medicine)
    {
        try {
            DB::beginTransaction();

            $item = $medicine->item;

            if ($item->quantity > 0) {
                $this->logStockChange($item->id, $item->quantity, 'out', 'Stok dihapus karena item dihapus');
            }

            StockTransaction::where('item_id', $item->id)->delete();
            $medicine->delete();
            $item->delete();

            DB::commit();

            return redirect()->route('medicines.index')->with('success', 'Obat berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('medicines.index')->with('error', 'Gagal menghapus obat: ' . $e->getMessage());
        }
    }

    private function validateRequest(Request $request, $isNew = false)
    {
        $rules = [
            'name' => $isNew ? 'required|string|max:255' : 'sometimes|string|max:255',
            'quantity' => $isNew ? 'required|integer|min:0' : 'sometimes|integer|min:0',
            'price' => $isNew ? 'required|numeric|min:0' : 'sometimes|numeric|min:0',
            'dosage' => $isNew ? 'required|string|max:255' : 'sometimes|string|max:255',
            'expiry_date' => $isNew ? 'required|date|after:today' : 'sometimes|date',
            'requires_prescription' => 'sometimes|boolean',
        ];

        return $request->validate($rules);
    }

    private function logStockChange($itemId, $qty, $type, $note = '')
    {
        StockTransaction::create([
            'item_id' => $itemId,
            'user_id' => Auth::id() ?? 1,
            'quantity' => $qty,
            'transaction_type' => $type,
            'transaction_date' => now(),
            'notes' => $note,
        ]);
    }

    private function addItem($data)
    {
        return Item::create([
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'item_type' => 'medicine',
        ]);
    }

    private function addMedicine($itemId, $data)
    {
        return Medicine::create([
            'item_id' => $itemId,
            'dosage' => $data['dosage'],
            'expiry_date' => $data['expiry_date'],
            'requires_prescription' => $data['requires_prescription'] ?? false,
        ]);
    }
}
