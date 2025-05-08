@extends('layouts.app')

@section('content')
<div class="content-wrapper">


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="card-title">Lista de Ventas</h4>
                        <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Nueva Venta
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Total</th>
                                    <th>Método de Pago</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                <tr>
                                    <td>#{{ $sale->id }}</td>
                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $sale->user->name }}</td>
                                    <td>${{ number_format($sale->final_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $sale->status === 'COMPLETED' ? 'success' : 'danger' }}">
                                            {{ $sale->status === 'COMPLETED' ? 'Completada' : 'Anulada' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.sales.show', $sale) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="icon-eye"></i>
                                        </a>
                                        @if($sale->status === 'COMPLETED')
                                        <form action="{{ route('admin.sales.destroy', $sale) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de anular esta venta?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay ventas registradas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
