@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5 class="card-title">Información Personal</h5>


                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Nombre</th>
                                            <td>{{ $specialist->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $specialist->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Teléfono</th>
                                            <td>{{ $specialist->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Documento</th>
                                            <td>{{ $specialist->document_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Estado</th>
                                            <td>
                                                @if ($specialist->is_active)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title">Especialidades</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @if ($specialist->specialties)
                                            <div class="mb-3">
                                                @foreach ($specialist->specialties as $specialty)
                                                    <span class="badge bg-info me-1">{{ $specialty }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">No hay especialidades registradas</p>
                                        @endif
                                    </div>
                                </div>

                                @if ($specialist->notes)
                                    <h5 class="card-title mt-4">Notas</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            {{ $specialist->notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="card-title">Órdenes de Servicio Asignadas</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <th>Dispositivo</th>
                                                <th>Estado</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($specialist->serviceOrders as $order)
                                                <tr>
                                                    <td>{{ $order->order_number }}</td>
                                                    <td>{{ $order->customer->name }}</td>
                                                    <td>{{ $order->deviceModel->brand->name }} -
                                                        {{ $order->deviceModel->name }}</td>
                                                    <td>
                                                        <span class="badge"
                                                            style="background-color: {{ $order->status->color }}">
                                                            {{ $order->status->name }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('service-orders.show', $order) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="ti-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No hay órdenes de servicio
                                                        asignadas</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="text-end">
                                    <a href="{{ route('admin.specialists.index') }}"
                                        class="btn btn-secondary me-1">Volver</a>
                                    <a href="{{ route('admin.specialists.edit', $specialist) }}"
                                        class="btn btn-primary">Editar Especialista</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
