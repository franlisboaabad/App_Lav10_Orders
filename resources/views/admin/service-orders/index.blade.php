@extends('layouts.app')

@section('content')
<div class="row mt-5">
    <div class="col-12 grid-margin stretch-card">
        <div class="card corona-gradient-card">
            <div class="card-body py-0 px-0 px-sm-3">
                <div class="row align-items-center">
                    <div class="col-4 col-sm-3 col-xl-2">
                        <img src="{{ asset('assets/images/dashboard/Group126@2x.png') }}" class="gradient-corona-img img-fluid" alt="">
                    </div>
                    <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                            <h6 class="mb-1 mb-sm-0">Nueva Orden de Servicio</h6>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">Registrar una nueva orden de servicio</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                    <span class="badge bg-{{ $order->status_color }} text-white">
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
                                            <i class="icon-eye"></i>
                                        </a>
                                        <a href="{{ route('service-orders.edit', $order) }}"
                                           class="btn btn-primary btn-sm"
                                           title="Editar">
                                            <i class="icon-book"></i>
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
                                                <i class="icon-trash"></i>
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
@endsection
