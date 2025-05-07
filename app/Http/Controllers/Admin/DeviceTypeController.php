<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deviceTypes = DeviceType::latest()->paginate(10);
        return view('admin.device-types.index', compact('deviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.device-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        DeviceType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('device-types.index')
            ->with('success', 'Tipo de dispositivo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceType $deviceType)
    {
        return view('admin.device-types.edit', compact('deviceType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceType $deviceType)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $deviceType->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('device-types.index')
            ->with('success', 'Tipo de dispositivo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceType $deviceType)
    {
        if($deviceType->deviceModels()->exists()) {
            return redirect()->route('device-types.index')
                ->with('error', 'No se puede eliminar el tipo de dispositivo porque tiene modelos asociados.');
        }

        $deviceType->delete();

        return redirect()->route('device-types.index')
            ->with('success', 'Tipo de dispositivo eliminado exitosamente.');
    }
}
