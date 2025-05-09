<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecialistController extends Controller
{
    public function index()
    {
        $specialists = Specialist::withCount('serviceOrders')
            ->latest()
            ->paginate(10);

        return view('admin.specialists.index', compact('specialists'));
    }

    public function create()
    {
        return view('admin.specialists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:specialists,email',
            'phone' => 'nullable|string|max:20',
            'document_number' => 'nullable|string|max:20',
            'specialties' => 'nullable|array',
            'specialties.*' => 'string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $specialist = Specialist::create($request->all());

            DB::commit();

            return redirect()
                ->route('admin.specialists.index')
                ->with('success', 'Especialista creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear especialista: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el especialista: ' . $e->getMessage());
        }
    }

    public function show(Specialist $specialist)
    {
        $specialist->load(['serviceOrders' => function($query) {
            $query->latest()->paginate(10);
        }]);

        return view('admin.specialists.show', compact('specialist'));
    }

    public function edit(Specialist $specialist)
    {
        return view('admin.specialists.edit', compact('specialist'));
    }

    public function update(Request $request, Specialist $specialist)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:specialists,email,' . $specialist->id,
            'phone' => 'nullable|string|max:20',
            'document_number' => 'nullable|string|max:20',
            'specialties' => 'nullable|array',
            'specialties.*' => 'string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $specialist->update($request->all());

            DB::commit();

            return redirect()
                ->route('admin.specialists.index')
                ->with('success', 'Especialista actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar especialista: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el especialista: ' . $e->getMessage());
        }
    }

    public function destroy(Specialist $specialist)
    {
        try {
            DB::beginTransaction();

            // Verificar si tiene órdenes de servicio asignadas
            if ($specialist->serviceOrders()->exists()) {
                return back()->with('error', 'No se puede eliminar el especialista porque tiene órdenes de servicio asignadas.');
            }

            $specialist->delete();

            DB::commit();

            return redirect()
                ->route('admin.specialists.index')
                ->with('success', 'Especialista eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar especialista: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el especialista: ' . $e->getMessage());
        }
    }
}