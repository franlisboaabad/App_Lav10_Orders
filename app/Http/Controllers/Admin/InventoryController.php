<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with(['product'])
            ->when(request('search'), function($query, $search) {
                $query->whereHas('product', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when(request('stock_status'), function($query, $status) {
                if ($status === 'low') {
                    $query->lowStock();
                } elseif ($status === 'over') {
                    $query->overStock();
                }
            })
            ->latest()
            ->paginate(10);

        return view('admin.inventories.index', compact('inventories'));
    }

    public function show(Inventory $inventory)
    {
        $inventory->load(['product', 'movements' => function($query) {
            $query->with('user')->latest()->paginate(10);
        }]);

        return view('admin.inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        return view('admin.inventories.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0|gt:min_stock',
            'quantity' => 'required|integer|min:0',
            'adjustment_notes' => 'required_if:quantity,' . $inventory->quantity . '|nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Si la cantidad cambió, registrar un ajuste
            if ($request->quantity != $inventory->quantity) {
                $inventory->movements()->create([
                    'type' => 'adjustment',
                    'quantity' => abs($request->quantity - $inventory->quantity),
                    'previous_quantity' => $inventory->quantity,
                    'current_quantity' => $request->quantity,
                    'notes' => $request->adjustment_notes,
                    'user_id' => auth()->id()
                ]);
            }

            $inventory->update([
                'min_stock' => $request->min_stock,
                'max_stock' => $request->max_stock,
                'quantity' => $request->quantity
            ]);

            DB::commit();

            return redirect()
                ->route('inventories.show', $inventory)
                ->with('success', 'Inventario actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el inventario: ' . $e->getMessage());
        }
    }
}