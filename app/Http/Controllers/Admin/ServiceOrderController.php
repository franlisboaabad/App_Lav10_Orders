<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\DeviceModel;
use Illuminate\Support\Str;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Models\ServiceOrderStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ServiceOrderController extends Controller
{
    public function index()
    {
        $serviceOrders = ServiceOrder::with(['customer', 'deviceModel', 'status'])
            ->latest()
            ->paginate(10);

        return view('admin.service-orders.index', compact('serviceOrders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $deviceModels = DeviceModel::with('brand')->orderBy('name')->get();
        $statuses = ServiceOrderStatus::where('is_active', true)->orderBy('name')->get();

        return view('admin.service-orders.create', compact('customers', 'deviceModels', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_model_id' => 'required|exists:device_models,id',
            'serial_number' => 'nullable|string|max:100',
            'status_id' => 'required|exists:service_order_statuses,id',
            'problem_description' => 'required|string',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'estimated_cost' => 'required|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
            'estimated_delivery_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Generar el número de orden
            $lastOrder = ServiceOrder::latest()->first();
            $orderNumber = $lastOrder ? $lastOrder->id + 1 : 1;
            $orderNumber = str_pad($orderNumber, 6, '0', STR_PAD_LEFT);

            // Crear la orden con los datos validados y el número de orden
            $serviceOrder = ServiceOrder::create([
                'order_number' => $orderNumber,
                'customer_id' => $validated['customer_id'],
                'device_model_id' => $validated['device_model_id'],
                'serial_number' => $validated['serial_number'],
                'status_id' => $validated['status_id'],
                'problem_description' => $validated['problem_description'],
                'diagnosis' => $validated['diagnosis'],
                'solution' => $validated['solution'],
                'estimated_cost' => $validated['estimated_cost'],
                'final_cost' => $validated['final_cost'] ?? null,
                'estimated_delivery_date' => $validated['estimated_delivery_date'],
                'delivery_date' => $validated['delivery_date'] ?? null,
                'notes' => $validated['notes'],
                'user_id' => auth()->id(), // Asignar el usuario actual
            ]);

            DB::commit();

            return redirect()
                ->route('service-orders.show', $serviceOrder)
                ->with('success', 'Orden de servicio creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear la orden de servicio: ' . $e->getMessage());
        }
    }

    public function show(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load(['customer', 'deviceModel.brand', 'status']);
        return view('admin.service-orders.show', compact('serviceOrder'));
    }

    public function edit(ServiceOrder $serviceOrder)
    {
        $customers = Customer::orderBy('name')->get();
        $deviceModels = DeviceModel::with('brand')->orderBy('name')->get();
        $statuses = ServiceOrderStatus::where('is_active', true)->orderBy('name')->get();

        return view('admin.service-orders.edit', compact('serviceOrder', 'customers', 'deviceModels', 'statuses'));
    }

    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_model_id' => 'required|exists:device_models,id',
            'serial_number' => 'nullable|string|max:100',
            'status_id' => 'required|exists:service_order_statuses,id',
            'problem_description' => 'required|string',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'estimated_cost' => 'required|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
            'estimated_delivery_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $serviceOrder->update($validated);

            DB::commit();

            return redirect()
                ->route('service-orders.show', $serviceOrder)
                ->with('success', 'Orden de servicio actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la orden de servicio: ' . $e->getMessage());
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
