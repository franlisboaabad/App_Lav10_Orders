<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashRegister;
use App\Models\CashMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashRegisters = CashRegister::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.cash-registers.index', compact('cashRegisters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar si hay una caja abierta
        $openRegister = CashRegister::open()->first();
        if ($openRegister) {
            return redirect()->route('cash-registers.show', $openRegister)
                ->with('warning', 'Ya existe una caja abierta. Debe cerrarla antes de abrir una nueva.');
        }

        return view('admin.cash-registers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'initial_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $cashRegister = CashRegister::create([
                'user_id' => auth()->id(),
                'initial_balance' => $request->initial_balance,
                'opening_date' => now(),
                'notes' => $request->notes
            ]);

            DB::commit();

            return redirect()->route('admin.cash-registers.show', $cashRegister)
                ->with('success', 'Caja abierta exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al abrir la caja: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CashRegister $cashRegister)
    {
        $cashRegister->load(['user', 'movements.user']);

        $movements = $cashRegister->movements()
            ->latest()
            ->paginate(10);

        return view('admin.cash-registers.show', compact('cashRegister', 'movements'));
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
    public function destroy(CashRegister $cashRegister)
    {
        // Verificar si la caja está cerrada
        if ($cashRegister->status !== 'closed') {
            return redirect()->back()->with('error', 'No se puede eliminar una caja que está abierta.');
        }

        // Verificar si hay movimientos asociados
        if ($cashRegister->movements()->exists()) {
            return redirect()->back()->with('error', 'No se puede eliminar una caja que tiene movimientos asociados.');
        }

        $cashRegister->delete();

        return redirect()->route('admin.cash-registers.index')
            ->with('success', 'Caja eliminada exitosamente.');
    }

    public function close(Request $request, CashRegister $cashRegister)
    {
        if ($cashRegister->status === 'closed') {
            return redirect()->back()->with('error', 'Esta caja ya está cerrada.');
        }

        $request->validate([
            'final_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $cashRegister->update([
                'status' => 'closed',
                'closed_at' => now(),
                'closed_by' => auth()->id(),
                'final_balance' => $request->final_balance,
                'closing_notes' => $request->notes
            ]);

            DB::commit();

            return redirect()->route('admin.cash-registers.index')
                ->with('success', 'Caja cerrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al cerrar la caja: ' . $e->getMessage());
        }
    }

    public function report(Request $request)
    {
        $date = $request->date ? \Carbon\Carbon::parse($request->date) : now();

        // Buscar la caja que se abrió en la fecha seleccionada
        $cashRegister = CashRegister::whereDate('opening_date', $date)
            ->with([
                'user',
                'movements' => function($query) use ($date) {
                    $query->whereDate('created_at', $date)
                        ->where('is_active', 1)
                        ->with('user')
                        ->orderBy('created_at', 'desc');
                }
            ])
            ->orderBy('opening_date', 'desc') // o ->orderBy('id', 'desc')
            ->first();


        if (!$cashRegister) {
            return back()->with('error', 'No hay registros de caja para la fecha seleccionada.');
        }

        // Obtener los movimientos del día
        $movements = $cashRegister->movements;

        // Calcular totales
        $totalIncome = $movements->where('type', 'INCOME')->sum('amount');
        $totalExpense = $movements->where('type', 'EXPENSE')->sum('amount');

        // Para depuración
        \Log::info('Reporte de Caja', [
            'fecha' => $date->format('Y-m-d'),
            'caja_id' => $cashRegister->id,
            'movimientos_count' => $movements->count(),
            'total_ingresos' => $totalIncome,
            'total_egresos' => $totalExpense
        ]);

        return view('admin.cash-registers.report', compact(
            'cashRegister',
            'movements',
            'totalIncome',
            'totalExpense',
            'date'
        ));
    }
}
