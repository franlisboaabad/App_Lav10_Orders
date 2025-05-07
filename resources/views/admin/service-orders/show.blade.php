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
                                <h6 class="mb-1 mb-sm-0">Detalles de Orden de Servicio</h6>
                                <p class="mb-0 font-weight-normal d-none d-sm-block">Ver los detalles de una orden de servicio</p>
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="card-title">Información de la Orden</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Código</th>
                                        <td>{{ $serviceOrder->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Estado</th>
                                        <td>
                                            <span class="badge bg-{{ $serviceOrder->status_color }}">
                                                {{ $serviceOrder->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Cliente</th>
                                        <td>{{ $serviceOrder->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Modelo de Dispositivo</th>
                                        <td>{{ $serviceOrder->deviceModel->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Serie</th>
                                        <td>{{ $serviceOrder->serial_number ?? 'No especificado' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Información de Costos y Fechas</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Costo Estimado</th>
                                        <td>${{ number_format($serviceOrder->estimated_cost, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Costo Final</th>
                                        <td>{{ $serviceOrder->final_cost ? '$' . number_format($serviceOrder->final_cost, 2) : 'No definido' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha Estimada de Entrega</th>
                                        <td>{{ $serviceOrder->estimated_delivery_date ? $serviceOrder->estimated_delivery_date->format('d/m/Y') : 'No definida' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de Entrega</th>
                                        <td>{{ $serviceOrder->delivery_date ? $serviceOrder->delivery_date->format('d/m/Y') : 'No entregado' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="card-title">Descripción del Problema</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $serviceOrder->problem_description }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($serviceOrder->diagnosis)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5 class="card-title">Diagnóstico</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $serviceOrder->diagnosis }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($serviceOrder->solution)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5 class="card-title">Solución</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $serviceOrder->solution }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($serviceOrder->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5 class="card-title">Notas Adicionales</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $serviceOrder->notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="text-end">
                                <a href="{{ route('service-orders.index') }}" class="btn btn-secondary me-1">Volver</a>
                                <a href="{{ route('service-orders.edit', $serviceOrder) }}" class="btn btn-primary">Editar Orden</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection