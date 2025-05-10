@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Inventario</h4>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('inventories.index') }}" method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Buscar por nombre o código..."
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group float-end">
                                <a href="{{ route('inventories.index') }}"
                                   class="btn btn-outline-secondary {{ !request('stock_status') ? 'active' : '' }}">
                                    Todos
                                </a>
                                <a href="{{ route('inventories.index', ['stock_status' => 'low']) }}"
                                   class="btn btn-outline-warning {{ request('stock_status') === 'low' ? 'active' : '' }}">
                                    Stock Bajo
                                </a>
                                <a href="{{ route('inventories.index', ['stock_status' => 'over']) }}"
                                   class="btn btn-outline-info {{ request('stock_status') === 'over' ? 'active' : '' }}">
                                    Stock Excesivo
                                </a>
                            </div>
                        </div>
                    </div>

                    @include('partials._validations')

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Código</th>
                                    <th>Stock Actual</th>
                                    <th>Stock Mínimo</th>
                                    <th>Stock Máximo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inventories as $inventory)
                                    <tr>
                                        <td>{{ $inventory->product->name }}</td>
                                        <td>{{ $inventory->product->code }}</td>
                                        <td>{{ $inventory->quantity }}</td>
                                        <td>{{ $inventory->min_stock }}</td>
                                        <td>{{ $inventory->max_stock }}</td>
                                        <td>
                                            @if($inventory->isLowStock())
                                                <span class="badge bg-warning">Stock Bajo</span>
                                            @elseif($inventory->isOverStock())
                                                <span class="badge bg-info">Stock Excesivo</span>
                                            @else
                                                <span class="badge bg-success">Normal</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('inventories.show', $inventory) }}"
                                               class="btn btn-info btn-sm">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="{{ route('inventories.edit', $inventory) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay productos en inventario</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
