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
        $customers = Customer::active()->get();
        $deviceTypes = DeviceType::active()->get();
        $deviceModels = DeviceModel::active()->get();
        $statuses = ServiceOrderStatus::all();
        $specialists = Specialist::active()->get();

        return view('admin.service-orders.create', compact(
            'customers',
            'deviceTypes',
            'deviceModels',
            'statuses',
            'specialists'
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
            'specialist_id' => 'nullable|exists:specialists,id'
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

        return view('admin.service-orders.edit', compact(
            'serviceOrder',
            'customers',
            'deviceTypes',
            'deviceModels',
            'statuses',
            'specialists'
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
            'specialist_id' => 'nullable|exists:specialists,id'
        ]);

        try {
            DB::beginTransaction();
            //si la orden de servicio esta en estado 6, se deberia crear un movimiento de caja
            $cashRegister = CashRegister::open()->first();
            if ($request->status_id == ServiceOrderStatus::ENTREGADO) {
                // Verificar que haya caja abierta antes de actualizar la orden
                if (!$cashRegister) {
                    Log::info('No hay caja abierta');
                    return redirect()
                        ->route('service-orders.show', $serviceOrder)
                        ->with('error', 'No hay caja abierta, para finalizar la orden de servicio');
                }
            }

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

            // Si el estado es 6 (pagado), registrar el movimiento de caja
            if ($request->status_id == ServiceOrderStatus::ENTREGADO) {
                $cashMovement = CashMovement::create([
                    'cash_register_id' => $cashRegister->id,
                    'user_id' => auth()->id(),
                    'type' => CashMovement::INGRESO,
                    'amount' => $request->final_cost, // Mejor usar el request aquí
                    'description' => 'Pago de orden de servicio',
                    'date' => now(),
                    'reference' => $serviceOrder->order_number,
                    'payment_method' => CashMovement::EFECTIVO,
                    'notes' => 'Pago de orden de servicio',
                    'is_active' => true
                ]);

                Log::info($cashMovement);
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
