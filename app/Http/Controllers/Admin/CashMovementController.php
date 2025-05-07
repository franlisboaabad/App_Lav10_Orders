<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashMovement;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = CashMovement::with(['cashRegister', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.cash-movements.index', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar si hay una caja abierta
        $cashRegister = CashRegister::where('status', 'OPEN')->first();

        if (!$cashRegister) {
            return redirect()->route('admin.cash-registers.index')
                ->with('error', 'No hay una caja abierta para registrar movimientos.');
        }

        return view('admin.cash-movements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:INCOME,EXPENSE',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255'
        ]);

        // Verificar si hay una caja abierta
        $cashRegister = CashRegister::where('status', 'OPEN')->first();

        if (!$cashRegister) {
            return redirect()->route('admin.cash-registers.index')
                ->with('error', 'No hay una caja abierta para registrar movimientos.');
        }

        try {
            DB::beginTransaction();

            // Crear el movimiento
            $movement = CashMovement::create([
                'cash_register_id' => $cashRegister->id,
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
                'user_id' => auth()->id()
            ]);

            DB::commit();

            return redirect()->route('admin.cash-registers.show', $cashRegister)
                ->with('success', 'Movimiento registrado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar el movimiento: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CashMovement $cashMovement)
    {
        $cashMovement->load(['cashRegister', 'user']);
        return view('admin.cash-movements.show', compact('cashMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashMovement $cashMovement)
    {
        // Verificar si la caja está abierta
        if ($cashMovement->cashRegister->status !== 'OPEN') {
            return redirect()->back()->with('error', 'No se puede eliminar un movimiento de una caja cerrada.');
        }

        try {
            DB::beginTransaction();

            $cashMovement->is_active = false;
            $cashMovement->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Movimiento eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el movimiento: ' . $e->getMessage());
        }
    }
}
