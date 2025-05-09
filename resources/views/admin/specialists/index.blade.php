@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Especialistas</h4>
                        <a href="{{ route('admin.specialists.create') }}" class="btn btn-primary">
                            <i class="ti-plus"></i> Nuevo Especialista
                        </a>
                    </div>

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

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Documento</th>
                                    <th>Órdenes Asignadas</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($specialists as $specialist)
                                    <tr>
                                        <td>{{ $specialist->name }}</td>
                                        <td>{{ $specialist->email }}</td>
                                        <td>{{ $specialist->phone ?? 'N/A' }}</td>
                                        <td>{{ $specialist->document_number ?? 'N/A' }}</td>
                                        <td>{{ $specialist->service_orders_count }}</td>
                                        <td>
                                            <span class="badge badge-{{ $specialist->is_active ? 'success' : 'danger' }}">
                                                {{ $specialist->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.specialists.show', $specialist) }}"
                                                   class="btn btn-info btn-sm"
                                                   title="Ver detalles">
                                                    <i class="ti-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.specialists.edit', $specialist) }}"
                                                   class="btn btn-warning btn-sm"
                                                   title="Editar">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.specialists.destroy', $specialist) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Está seguro de eliminar este especialista?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Eliminar">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay especialistas registrados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $specialists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
