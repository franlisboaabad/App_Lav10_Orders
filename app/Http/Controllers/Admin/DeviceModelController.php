<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceModel;
use App\Models\Brand;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deviceModels = DeviceModel::with(['brand', 'deviceType'])
            ->latest()
            ->paginate(10);
        return view('admin.device-models.index', compact('deviceModels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $deviceTypes = DeviceType::where('is_active', true)->orderBy('name')->get();
        return view('admin.device-models.create', compact('brands', 'deviceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand_id' => ['required', 'exists:brands,id'],
            'device_type_id' => ['required', 'exists:device_types,id'],
            'description' => ['nullable', 'string'],
        ]);

        DeviceModel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'brand_id' => $request->brand_id,
            'device_type_id' => $request->device_type_id,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('device-models.index')
            ->with('success', 'Modelo de dispositivo creado exitosamente.');
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
    public function edit(DeviceModel $deviceModel)
    {
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $deviceTypes = DeviceType::where('is_active', true)->orderBy('name')->get();
        return view('admin.device-models.edit', compact('deviceModel', 'brands', 'deviceTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceModel $deviceModel)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand_id' => ['required', 'exists:brands,id'],
            'device_type_id' => ['required', 'exists:device_types,id'],
            'description' => ['nullable', 'string'],
        ]);

        $deviceModel->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'brand_id' => $request->brand_id,
            'device_type_id' => $request->device_type_id,
            'description' => $request->description,
        ]);

        return redirect()->route('device-models.index')
            ->with('success', 'Modelo de dispositivo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceModel $deviceModel)
    {
        $deviceModel->delete();

        return redirect()->route('device-models.index')
            ->with('success', 'Modelo de dispositivo eliminado exitosamente.');
    }
}
