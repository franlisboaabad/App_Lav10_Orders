<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\DeviceType;
use App\Models\Specialist;
use App\Models\DeviceModel;
use Illuminate\Support\Str;
use App\Models\CashMovement;
use App\Models\CashRegister;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Models\ServiceOrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ServiceOrderController extends Controller
{
    public function index()
    {
        $serviceOrders = ServiceOrder::with(['customer', 'deviceModel', 'status'])
            ->latest()
            ->paginate(10);

        $statuses = ServiceOrderStatus::all();

        return view('admin.service-orders.index', compact('serviceOrders', 'statuses'));
    }

    public function create()
    {
        $customers = Customer::active()->get();
        $deviceTypes = DeviceType::active()->get();
        $deviceModels = DeviceModel::active()->get();
        $statuses = ServiceOrderStatus::all();
        $specialists = Specialist::active()->get();
        $products = Product::active()->get();

        return view('admin.service-orders.create', compact(
            'customers',
            'deviceTypes',
            'deviceModels',
            'statuses',
            'specialists',
            'products'
        ));
    }

    public function store(Request $request)
    {
        Log::info($request->all());

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_model_id' => 'required|exists:device_models,id',
            'serial_number' => 'required|string',
            'status_id' => 'required|exists:service_order_statuses,id',
            'problem_description' => 'required|string',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
            'estimated_delivery_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'specialist_id' => 'nullable|exists:specialists,id',
            'products' => 'nullable|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
            'products.*.notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $serviceOrder = ServiceOrder::create([
                'order_number' => ServiceOrder::generateOrderNumber(),
                'customer_id' => $request->customer_id,
                'device_model_id' => $request->device_model_id,
                'serial_number' => $request->serial_number,
                'status_id' => $request->status_id,
                'problem_description' => $request->problem_description,
                'diagnosis' => $request->diagnosis,
                'solution' => $request->solution,
                'estimated_cost' => $request->estimated_cost,
                'final_cost' => $request->final_cost,
                'estimated_delivery_date' => $request->estimated_delivery_date,
                'delivery_date' => $request->delivery_date,
                'notes' => $request->notes,
                'specialist_id' => $request->specialist_id,
                'user_id' => auth()->id()
            ]);

            // Guardar productos si existen
            if ($request->has('products')) {
                foreach ($request->products as $product) {
                    $subtotal = $product['quantity'] * $product['unit_price'];
                    $serviceOrder->products()->attach($product['product_id'], [
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['unit_price'],
                        'subtotal' => $subtotal,
                        'notes' => $product['notes'] ?? null
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('service-orders.show', $serviceOrder)
                ->with('success', 'Orden de servicio creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear orden de servicio: ' . $e->getMessage());
            return back()->with('error', 'Error al crear la orden de servicio: ' . $e->getMessage());
        }
    }

    public function show(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load(['customer', 'deviceModel.brand', 'status']);
        return view('admin.service-orders.show', compact('serviceOrder'));
    }

    public function edit(ServiceOrder $serviceOrder)
    {
        $customers = Customer::active()->get();
        $deviceTypes = DeviceType::active()->get();
        $deviceModels = DeviceModel::active()->get();
        $statuses = ServiceOrderStatus::all();
        $specialists = Specialist::active()->get();
        $products = Product::active()->get();

        return view('admin.service-orders.edit', compact(
            'serviceOrder',
            'customers',
            'deviceTypes',
            'deviceModels',
            'statuses',
            'specialists',
            'products'
        ));
    }

    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        Log::info($request->all());
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_model_id' => 'required|exists:device_models,id',
            'serial_number' => 'required|string',
            'status_id' => 'required|exists:service_order_statuses,id',
            'problem_description' => 'required|string',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
            'estimated_delivery_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'specialist_id' => 'nullable|exists:specialists,id',
            'products' => 'nullable|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
            'products.*.notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $serviceOrder->update([
                'customer_id' => $request->customer_id,
                'device_model_id' => $request->device_model_id,
                'serial_number' => $request->serial_number,
                'status_id' => $request->status_id,
                'problem_description' => $request->problem_description,
                'diagnosis' => $request->diagnosis,
                'solution' => $request->solution,
                'estimated_cost' => $request->estimated_cost,
                'final_cost' => $request->final_cost,
                'estimated_delivery_date' => $request->estimated_delivery_date,
                'delivery_date' => $request->delivery_date,
                'notes' => $request->notes,
                'specialist_id' => $request->specialist_id
            ]);

            // Actualizar productos
            $serviceOrder->products()->detach();
            if ($request->has('products')) {
                foreach ($request->products as $product) {
                    $subtotal = $product['quantity'] * $product['unit_price'];
                    $serviceOrder->products()->attach($product['product_id'], [
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['unit_price'],
                        'subtotal' => $subtotal,
                        'notes' => $product['notes'] ?? null
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('service-orders.show', $serviceOrder)
                ->with('success', 'Orden de servicio actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar orden de servicio: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar la orden de servicio: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, ServiceOrder $serviceOrder)
    {
        $request->validate([
            'status_id' => 'required|exists:service_order_statuses,id'
        ]);

        try {
            DB::beginTransaction();

            if ($request->status_id == ServiceOrderStatus::ENTREGADO) {
                return response()->json([
                    'success' => true,
                    'message' => 'Para finalizar la orden de servicio, se debe registrar el pago',
                ]);
            }

            $serviceOrder->update([
                'status_id' => $request->status_id
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente',
                'status' => $serviceOrder->status
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroy(ServiceOrder $serviceOrder)
    {
        try {
            DB::beginTransaction();

            $serviceOrder->delete();

            DB::commit();

            return redirect()
                ->route('service-orders.index')
                ->with('success', 'Orden de servicio eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al eliminar la orden de servicio: ' . $e->getMessage());
        }
    }
}
