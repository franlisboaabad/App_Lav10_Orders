@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card corona-gradient-card">
            <div class="card-body py-0 px-0 px-sm-3">
                <div class="row align-items-center">
                    <div class="col-4 col-sm-3 col-xl-2">
                        <img src="{{ asset('assets/images/dashboard/Group126@2x.png') }}" class="gradient-corona-img img-fluid" alt="">
                    </div>
                    <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                            <h6 class="mb-1 mb-sm-0">Gestión de Tipos de Dispositivos</h6>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">Lista de tipos registrados</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <h4 class="card-title">Tipos de Dispositivos</h4>
                    <a href="{{ route('device-types.create') }}" class="btn btn-primary">
                        <i class="icon-plus"></i> Nuevo Tipo
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deviceTypes as $deviceType)
                                <tr>
                                    <td>{{ $deviceType->id }}</td>
                                    <td>{{ $deviceType->name }}</td>
                                    <td>{{ Str::limit($deviceType->description, 50) }}</td>
                                    <td>
                                        <span class="badge {{ $deviceType->is_active ? 'badge-success' : 'badge-danger' }}">
                                            {{ $deviceType->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ $deviceType->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('device-types.edit', $deviceType) }}" class="btn btn-primary btn-sm">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <form action="{{ route('device-types.destroy', $deviceType) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este tipo de dispositivo?')">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay tipos de dispositivos registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $deviceTypes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
