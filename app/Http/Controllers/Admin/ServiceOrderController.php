<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use App\Models\Customer;
use App\Models\DeviceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceOrders = ServiceOrder::with(['customer', 'deviceModel'])
            ->latest()
            ->paginate(10);
        return view('admin.service-orders.index', compact('serviceOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('is_active', true)->get();
        $deviceModels = DeviceModel::where('is_active', true)->get();
        return view('admin.service-orders.create', compact('customers', 'deviceModels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'device_model_id' => ['required', 'exists:device_models,id'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'problem_description' => ['required', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'estimated_cost' => ['required', 'numeric', 'min:0'],
            'final_cost' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:PENDING,IN_DIAGNOSIS,WAITING_APPROVAL,IN_REPAIR,READY,DELIVERED,CANCELLED'],
            'estimated_delivery_date' => ['nullable', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        // Generar código único para la orden
        $code = 'OS-' . strtoupper(Str::random(8));

        ServiceOrder::create([
            'code' => $code,
            'customer_id' => $request->customer_id,
            'device_model_id' => $request->device_model_id,
            'serial_number' => $request->serial_number,
            'problem_description' => $request->problem_description,
            'diagnosis' => $request->diagnosis,
            'solution' => $request->solution,
            'estimated_cost' => $request->estimated_cost,
            'final_cost' => $request->final_cost,
            'status' => $request->status,
            'estimated_delivery_date' => $request->estimated_delivery_date,
            'delivery_date' => $request->delivery_date,
            'notes' => $request->notes,
            'is_active' => true,
        ]);

        return redirect()->route('service-orders.index')
            ->with('success', 'Orden de servicio creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load(['customer', 'deviceModel']);
        return view('admin.service-orders.show', compact('serviceOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceOrder $serviceOrder)
    {
        $customers = Customer::where('is_active', true)->get();
        $deviceModels = DeviceModel::where('is_active', true)->get();
        return view('admin.service-orders.edit', compact('serviceOrder', 'customers', 'deviceModels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'device_model_id' => ['required', 'exists:device_models,id'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'problem_description' => ['required', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'estimated_cost' => ['required', 'numeric', 'min:0'],
            'final_cost' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:PENDING,IN_DIAGNOSIS,WAITING_APPROVAL,IN_REPAIR,READY,DELIVERED,CANCELLED'],
            'estimated_delivery_date' => ['nullable', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $serviceOrder->update([
            'customer_id' => $request->customer_id,
            'device_model_id' => $request->device_model_id,
            'serial_number' => $request->serial_number,
            'problem_description' => $request->problem_description,
            'diagnosis' => $request->diagnosis,
            'solution' => $request->solution,
            'estimated_cost' => $request->estimated_cost,
            'final_cost' => $request->final_cost,
            'status' => $request->status,
            'estimated_delivery_date' => $request->estimated_delivery_date,
            'delivery_date' => $request->delivery_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('service-orders.index')
            ->with('success', 'Orden de servicio actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceOrder $serviceOrder)
    {
        $serviceOrder->delete();

        return redirect()->route('service-orders.index')
            ->with('success', 'Orden de servicio eliminada exitosamente.');
    }
}
