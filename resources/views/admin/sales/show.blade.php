@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Detalle de Venta</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sales.index') }}">Ventas</a></li>
                        <li class="breadcrumb-item active">Detalle</li>
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
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="card-title">Venta #{{ $sale->id }}</h4>
                        <div>
                            <button type="button" class="btn btn-success" onclick="window.print()">
                                <i class="mdi mdi-printer"></i> Imprimir
                            </button>
                            @if($sale->status === 'COMPLETED')
                            <form action="{{ route('admin.sales.destroy', $sale) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Está seguro de anular esta venta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="mdi mdi-close"></i> Anular Venta
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Información de la Venta</h5>
                            <table class="table">
                                <tr>
                                    <th>Fecha:</th>
                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Usuario:</th>
                                    <td>{{ $sale->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Método de Pago:</th>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        <span class="badge bg-{{ $sale->status === 'COMPLETED' ? 'success' : 'danger' }}">
                                            {{ $sale->status === 'COMPLETED' ? 'Completada' : 'Anulada' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Totales</h5>
                            <table class="table">
                                <tr>
                                    <th>Subtotal:</th>
                                    <td class="text-end">${{ number_format($sale->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Descuento:</th>
                                    <td class="text-end">${{ number_format($sale->discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-end"><strong>${{ number_format($sale->final_amount, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Vendedor:</strong> {{ $sale->user->name }}</p>
                            <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Estado:</strong>
                                <span class="badge bg-{{ $sale->status === 'COMPLETED' ? 'success' : 'danger' }}">
                                    {{ $sale->status === 'COMPLETED' ? 'Completada' : 'Anulada' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Cliente:</strong> {{ $sale->customer ? $sale->customer->name : 'Cliente General' }}</p>
                            <p><strong>Método de Pago:</strong> {{ $sale->payment_method }}</p>
                            <p><strong>Notas:</strong> {{ $sale->notes ?? 'Sin notas' }}</p>
                        </div>
                    </div>

                    <h5>Productos</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->details as $detail)
                                <tr>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                                    <td>${{ number_format($detail->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($sale->notes)
                    <div class="mt-4">
                        <h5>Notas</h5>
                        <p>{{ $sale->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .page-title-box, .btn, form {
            display: none !important;
        }
        .card {
            border: none !important;
        }
        .card-body {
            padding: 0 !important;
        }
    }
</style>
@endpush
@endsection
