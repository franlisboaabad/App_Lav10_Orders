@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Reporte Diario de Caja</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.cash-registers.index') }}">Caja</a></li>
                        <li class="breadcrumb-item active">Reporte</li>
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
                        <h4 class="card-title">Filtros</h4>
                        <div>
                            <button type="button" class="btn btn-success" onclick="window.print()">
                                <i class="mdi mdi-printer"></i> Imprimir
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('admin.cash-registers.report') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Fecha</label>
                            <input type="date"
                                   class="form-control"
                                   name="date"
                                   value="{{ request('date', now()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </form>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body">
                                    <h5 class="card-title">Total Ingresos</h5>
                                    <h3 class="text-success">${{ number_format($totalIncome, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body">
                                    <h5 class="card-title">Total Egresos</h5>
                                    <h3 class="text-danger">${{ number_format($totalExpense, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body">
                                    <h5 class="card-title">Balance</h5>
                                    <h3 class="text-primary">${{ number_format($totalIncome - $totalExpense, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Movimientos del Día</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Hora</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Monto</th>
                                            <th>Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($movements as $movement)
                                        <tr>
                                            <td>{{ $movement->created_at->format('H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $movement->type === 'INCOME' ? 'success' : 'danger' }}">
                                                    {{ $movement->type === 'INCOME' ? 'Ingreso' : 'Egreso' }}
                                                </span>
                                            </td>
                                            <td>{{ $movement->description }}</td>
                                            <td>${{ number_format($movement->amount, 2) }}</td>
                                            <td>{{ $movement->user->name }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay movimientos registrados para esta fecha</td>
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
