@extends('layouts.app')

@section('content')

<div class="content-wrapper">
<div class="row">
    <div class="col-12 grid-margin">

        <div class="card">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Modelos de Dispositivos</h4>
                    <a href="{{ route('device-models.create') }}" class="btn btn-primary">
                        <i class="icon-plus"></i> Nuevo Modelo
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deviceModels as $deviceModel)
                                <tr>
                                    <td>{{ $deviceModel->id }}</td>
                                    <td>{{ $deviceModel->name }}</td>
                                    <td>{{ $deviceModel->brand->name }}</td>
                                    <td>{{ $deviceModel->deviceType->name }}</td>
                                    <td>{{ Str::limit($deviceModel->description, 50) }}</td>
                                    <td>
                                        <span class="badge {{ $deviceModel->is_active ? 'badge-success' : 'badge-danger' }}">
                                            {{ $deviceModel->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ $deviceModel->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('device-models.edit', $deviceModel) }}" class="btn btn-primary btn-sm">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <form action="{{ route('device-models.destroy', $deviceModel) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este modelo de dispositivo?')">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No hay modelos de dispositivos registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $deviceModels->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
