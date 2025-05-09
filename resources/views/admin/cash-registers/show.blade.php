@extends('layouts.app')

@section('content')

  <div class="content-wrapper">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="card-title">Información de la Caja</h4>
                        <div>
                            @if($cashRegister->status === 'OPEN')
                                <a href="{{ route('admin.cash-movements.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus"></i> Nuevo Movimiento
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="ps-0" scope="row">Estado:</th>
                                            <td class="text-muted">
                                                <span class="badge bg-{{ $cashRegister->status === 'OPEN' ? 'success' : 'secondary' }}">
                                                    {{ $cashRegister->status === 'OPEN' ? 'Abierta' : 'Cerrada' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Fecha de Apertura:</th>
                                            <td class="text-muted">{{ $cashRegister->opening_date->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Usuario:</th>
                                            <td class="text-muted">{{ $cashRegister->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Saldo Inicial:</th>
                                            <td class="text-muted">${{ number_format($cashRegister->initial_balance, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="ps-0" scope="row">Total Ingresos:</th>
                                            <td class="text-muted">${{ number_format($cashRegister->total_income, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Total Egresos:</th>
                                            <td class="text-muted">${{ number_format($cashRegister->total_expense, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0" scope="row">Saldo Actual:</th>
                                            <td class="text-muted">${{ number_format($cashRegister->current_balance, 2) }}</td>
                                        </tr>
                                        @if($cashRegister->status === 'CLOSED')
                                            <tr>
                                                <th class="ps-0" scope="row">Fecha de Cierre:</th>
                                                <td class="text-muted">
                                                    @if($cashRegister->status === 'CLOSED' && $cashRegister->closing_date)
                                                        {{ $cashRegister->closing_date->format('d/m/Y H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="ps-0" scope="row">Saldo Final:</th>
                                                <td class="text-muted">${{ number_format($cashRegister->final_balance, 2) }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($cashRegister->notes)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Notas:</h5>
                                <p class="text-muted">{{ $cashRegister->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Movimientos</h5>
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Referencia</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Monto</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cashRegister->movements as $movement)
                                        <tr>
                                            <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $movement->reference }}</td>
                                            <td>
                                                <span class="badge bg-{{ $movement->type === 'INCOME' ? 'success' : 'danger' }}">
                                                    {{ $movement->type === 'INCOME' ? 'Ingreso' : 'Egreso' }}
                                                </span>
                                            </td>
                                            <td>{{ $movement->description }}</td>
                                            <td>${{ number_format($movement->amount, 2) }}</td>
                                            <td>{{ $movement->user->name }}</td>
                                            <td>
                                                @if($cashRegister->status === 'OPEN')
                                                    <form action="{{ route('admin.cash-movements.destroy', $movement) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('¿Está seguro de eliminar este movimiento?');">
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
                                            <td colspan="6" class="text-center">No hay movimientos registrados</td>
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

@endsection
