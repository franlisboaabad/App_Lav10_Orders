<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceOrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceOrderStatusController extends Controller
{
    public function index()
    {
        $statuses = ServiceOrderStatus::latest()->paginate(10);
        return view('admin.service-order-statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.service-order-statuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_order_statuses',
            'color' => 'required|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        ServiceOrderStatus::create($validated);

        return redirect()->route('admin.service-order-statuses.index')
            ->with('success', 'Estado creado exitosamente.');
    }

    public function show(ServiceOrderStatus $serviceOrderStatus)
    {
        return view('admin.service-order-statuses.show', compact('serviceOrderStatus'));
    }

    public function edit(ServiceOrderStatus $serviceOrderStatus)
    {
        return view('admin.service-order-statuses.edit', compact('serviceOrderStatus'));
    }

    public function update(Request $request, ServiceOrderStatus $serviceOrderStatus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_order_statuses,name,' . $serviceOrderStatus->id,
            'color' => 'required|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $serviceOrderStatus->update($validated);

        return redirect()->route('admin.service-order-statuses.index')
            ->with('success', 'Estado actualizado exitosamente.');
    }

    public function destroy(ServiceOrderStatus $serviceOrderStatus)
    {
        if ($serviceOrderStatus->serviceOrders()->exists()) {
            return redirect()->route('admin.service-order-statuses.index')
                ->with('error', 'No se puede eliminar el estado porque tiene órdenes de servicio asociadas.');
        }

        $serviceOrderStatus->delete();

        return redirect()->route('admin.service-order-statuses.index')
            ->with('success', 'Estado eliminado exitosamente.');
    }
}
