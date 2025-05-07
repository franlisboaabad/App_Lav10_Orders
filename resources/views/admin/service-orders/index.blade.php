@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Órdenes de Servicio</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Órdenes de Servicio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="card-title">Listado de Órdenes de Servicio</h4>
                        <a href="{{ route('service-orders.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Nueva Orden
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Cliente</th>
                                    <th>Dispositivo</th>
                                    <th>Estado</th>
                                    <th>Costo Estimado</th>
                                    <th>Fecha Estimada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($serviceOrders as $order)
                                <tr>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->deviceModel->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_color }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($order->estimated_cost, 2) }}</td>
                                    <td>{{ $order->estimated_delivery_date ? $order->estimated_delivery_date->format('d/m/Y') : 'No definida' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('service-orders.show', $order) }}"
                                               class="btn btn-info btn-sm"
                                               title="Ver detalles">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="{{ route('service-orders.edit', $order) }}"
                                               class="btn btn-primary btn-sm"
                                               title="Editar">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <form action="{{ route('service-orders.destroy', $order) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar esta orden de servicio?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Eliminar">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay órdenes de servicio registradas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $serviceOrders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
