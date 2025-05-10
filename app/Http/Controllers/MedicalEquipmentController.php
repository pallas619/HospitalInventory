<?php

namespace App\Http\Controllers;

use App\Models\MedicalEquipment;
use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicalEquipmentController extends Controller
{
    public function index()
    {
        $equipments = MedicalEquipment::with('item')->get();
        return view('medical.index', compact('equipments'));
    }

    public function create()
    {
        return view('medical.create', [
            'items' => Item::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        try {
            DB::beginTransaction();

            $item = $this->createItem($data);
            $this->createMedicalEquipment($item->id, $data);
            $this->logStockChange($item->id, $data['quantity'], 'in', 'Penambahan awal peralatan medis');

            DB::commit();

            return redirect()->route('medical.index')->with('message', 'Medical equipment created successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create equipment: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $equipment = MedicalEquipment::with('item')->findOrFail($id);
        return view('medical.show', compact('equipment'));
    }

    public function edit($id)
    {
        $equipment = MedicalEquipment::with('item')->findOrFail($id);
        return view('medical.edit', compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        $equipment = MedicalEquipment::findOrFail($id);
        $item = $equipment->item;

        $data = $this->validateRequest($request, false);

        try {
            DB::beginTransaction();

            $oldQty = $item->quantity;
            $newQty = $data['quantity'] ?? $oldQty;

            $item->update([
                'name' => $data['name'] ?? $item->name,
                'price' => $data['price'] ?? $item->price,
                'quantity' => $newQty,
            ]);

            $equipment->update([
                'department' => $data['department'] ?? $equipment->department,
                'operational_status' => $data['operational_status'] ?? $equipment->operational_status,
                'maintenance_schedule' => $data['maintenance_schedule'] ?? $equipment->maintenance_schedule,
            ]);

            $diff = $newQty - $oldQty;
            if ($diff !== 0) {
                $this->logStockChange($item->id, abs($diff), $diff > 0 ? 'in' : 'out', 'Penyesuaian stok peralatan medis');
            }

            DB::commit();

            return redirect()->route('medical.index')->with('message', 'Medical equipment updated successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $equipment = MedicalEquipment::findOrFail($id);
        $item = $equipment->item;

        try {
            DB::beginTransaction();

            if ($item->quantity > 0) {
                $this->logStockChange($item->id, $item->quantity, 'out', 'Penghapusan peralatan medis');
            }

            StockTransaction::where('item_id', $item->id)->delete();
            $equipment->delete();
            $item->delete();

            DB::commit();

            return redirect()->route('medical.index')->with('message', 'Medical equipment deleted successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('medical.index')->with('error', 'Failed to delete medical equipment: ' . $e->getMessage());
        }
    }

    private function validateRequest(Request $request, $isNew = true)
    {
        $rules = [
            'name' => $isNew ? 'required|string|max:255' : 'sometimes|string|max:255',
            'quantity' => $isNew ? 'required|integer' : 'sometimes|integer',
            'price' => $isNew ? 'required|numeric' : 'sometimes|numeric',
            'department' => $isNew ? 'required|string|max:255' : 'sometimes|string|max:255',
            'operational_status' => $isNew ? 'required|in:Active,Maintenance,Broken' : 'sometimes|in:Active,Maintenance,Broken',
            'maintenance_schedule' => 'nullable|date',
        ];

        return $request->validate($rules);
    }

    private function createItem(array $data)
    {
        return Item::create([
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'item_type' => 'equipment',
        ]);
    }

    private function createMedicalEquipment($itemId, array $data)
    {
        return MedicalEquipment::create([
            'item_id' => $itemId,
            'department' => $data['department'],
            'operational_status' => $data['operational_status'],
            'maintenance_schedule' => $data['maintenance_schedule'] ?? null,
        ]);
    }

    private function logStockChange($itemId, $quantity, $type, $note = '')
    {
        StockTransaction::create([
            'item_id' => $itemId,
            'user_id' => Auth::User()->id ?? 1,
            'quantity' => $quantity,
            'transaction_type' => $type,
            'transaction_date' => now(),
            'notes' => $note,
        ]);
    }
}
