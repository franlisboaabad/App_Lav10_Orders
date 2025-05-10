@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detalle de Inventario</h4>

                    @include('partials._validations')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Producto</th>
                                        <td>{{ $inventory->product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Código</th>
                                        <td>{{ $inventory->product->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stock Actual</th>
                                        <td>
                                            <span class="badge {{ $inventory->isLowStock() ? 'bg-warning' : ($inventory->isOverStock() ? 'bg-info' : 'bg-success') }}">
                                                {{ $inventory->quantity }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Stock Mínimo</th>
                                        <td>{{ $inventory->min_stock }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stock Máximo</th>
                                        <td>{{ $inventory->max_stock }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Resumen de Movimientos</h5>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <h3>{{ $inventory->movements->where('type', 'entry')->sum('quantity') }}</h3>
                                            <p class="text-muted">Entradas</p>
                                        </div>
                                        <div class="col-4">
                                            <h3>{{ $inventory->movements->where('type', 'exit')->sum('quantity') }}</h3>
                                            <p class="text-muted">Salidas</p>
                                        </div>
                                        <div class="col-4">
                                            <h3>{{ $inventory->movements->where('type', 'adjustment')->count() }}</h3>
                                            <p class="text-muted">Ajustes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Historial de Movimientos</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Cantidad</th>
                                            <th>Stock Anterior</th>
                                            <th>Stock Actual</th>
                                            <th>Referencia</th>
                                            <th>Notas</th>
                                            <th>Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inventory->movements as $movement)
                                            <tr>
                                                <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if($movement->type === 'entry')
                                                        <span class="badge bg-success">Entrada</span>
                                                    @elseif($movement->type === 'exit')
                                                        <span class="badge bg-danger">Salida</span>
                                                    @else
                                                        <span class="badge bg-warning">Ajuste</span>
                                                    @endif
                                                </td>
                                                <td>{{ $movement->quantity }}</td>
                                                <td>{{ $movement->previous_quantity }}</td>
                                                <td>{{ $movement->current_quantity }}</td>
                                                <td>
                                                    @if($movement->reference)
                                                        {{ class_basename($movement->reference_type) }} #{{ $movement->reference_id }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $movement->notes ?: '-' }}</td>
                                                <td>{{ $movement->user->name }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No hay movimientos registrados</td>
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
                                <a href="{{ route('inventories.index') }}" class="btn btn-secondary me-1">Volver</a>
                                <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-primary">
                                    Editar Inventario
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
