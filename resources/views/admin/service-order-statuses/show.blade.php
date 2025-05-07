@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detalles del Estado</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre:</label>
                        <p>{{ $serviceOrderStatus->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Color:</label>
                        <p>
                            <span class="badge" style="background-color: {{ $serviceOrderStatus->color }}">
                                {{ $serviceOrderStatus->color }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción:</label>
                        <p>{{ $serviceOrderStatus->description ?: 'Sin descripción' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Estado:</label>
                        <p>
                            <span class="badge {{ $serviceOrderStatus->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $serviceOrderStatus->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha de Creación:</label>
                        <p>{{ $serviceOrderStatus->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Última Actualización:</label>
                        <p>{{ $serviceOrderStatus->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('service-order-statuses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <div>
                            <a href="{{ route('service-order-statuses.edit', $serviceOrderStatus) }}"
                               class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('service-order-statuses.destroy', $serviceOrderStatus) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Está seguro de eliminar este estado?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
