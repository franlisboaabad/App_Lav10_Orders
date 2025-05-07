<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use App\Models\CashRegister;
use App\Models\CashMovement;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['user', 'cashRegister'])
            ->latest()
            ->paginate(10);

        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar si hay una caja abierta
        $cashRegister = CashRegister::open()->first();
        if (!$cashRegister) {
            return redirect()->route('admin.cash-registers.index')
                ->with('error', 'Debe abrir una caja antes de realizar una venta.');
        }

        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        $customers = Customer::orderBy('name')->get();

        return view('admin.sales.create', compact('cashRegister', 'products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cash_register_id' => 'required|exists:cash_registers,id',
            'customer_id' => 'nullable|exists:customers,id',
            'products' => 'required|string',
            'payment_method' => 'required|in:CASH,CARD,TRANSFER',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Decodificar el JSON de productos
            $products = json_decode($request->products, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error al procesar los productos');
            }

            // Calcular totales
            $totalAmount = 0;
            $discountAmount = 0;

            foreach ($products as $item) {
                $product = Product::findOrFail($item['id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;
            }

            $finalAmount = $totalAmount - $discountAmount;

            // Crear la venta
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'cash_register_id' => $request->cash_register_id,
                'customer_id' => $request->customer_id,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'COMPLETED',
                'notes' => $request->notes
            ]);

            // Crear los detalles de la venta
            foreach ($products as $item) {
                $product = Product::findOrFail($item['id']);
                $subtotal = $product->price * $item['quantity'];

                $sale->details()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'total' => $subtotal
                ]);

                // Actualizar el stock del producto
                $product->decrement('stock', $item['quantity']);
            }

            // Registrar el movimiento en caja
            CashMovement::create([
                'cash_register_id' => $request->cash_register_id,
                'user_id' => auth()->id(),
                'type' => 'INCOME',
                'amount' => $finalAmount,
                'description' => 'Venta #' . $sale->id,
                'is_active' => true
            ]);

            DB::commit();

            return redirect()->route('admin.sales.show', $sale)
                ->with('success', 'Venta registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['user', 'cashRegister', 'details.product']);
        return view('admin.sales.show', compact('sale'));
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
    public function destroy(Sale $sale)
    {
        if ($sale->status === 'CANCELLED') {
            return back()->with('error', 'Esta venta ya está anulada.');
        }

        try {
            DB::beginTransaction();

            // Restaurar el stock de los productos
            foreach ($sale->details as $detail) {
                $detail->product->increment('stock', $detail->quantity);
            }

            // Anular el movimiento en caja
            CashMovement::create([
                'cash_register_id' => $sale->cash_register_id,
                'user_id' => auth()->id(),
                'type' => 'EXPENSE',
                'amount' => $sale->final_amount,
                'description' => 'Anulación de venta #' . $sale->id,
                'is_active' => true
            ]);

            // Marcar la venta como anulada
            $sale->update(['status' => 'CANCELLED']);

            DB::commit();

            return redirect()->route('admin.sales.index')
                ->with('success', 'Venta anulada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al anular la venta: ' . $e->getMessage());
        }
    }
}
