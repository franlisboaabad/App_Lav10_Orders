@extends('layouts.app')

@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Registros de Caja</h4>
                            <div>
                                <a href="{{ route('admin.cash-registers.report') }}" class="btn btn-info me-2">
                                    <i class="mdi mdi-file-document"></i> Reporte Diario
                                </a>
                                <a href="{{ route('admin.cash-registers.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus"></i> Abrir Caja
                                </a>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Saldo Inicial</th>
                                        <th>Ingresos</th>
                                        <th>Egresos</th>
                                        <th>Saldo Final</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cashRegisters as $register)
                                        <tr>
                                            <td>{{ $register->opening_date->format('d/m/Y H:i') }}</td>
                                            <td>{{ $register->user->name }}</td>
                                            <td>${{ number_format($register->initial_balance, 2) }}</td>
                                            <td>${{ number_format($register->total_income, 2) }}</td>
                                            <td>${{ number_format($register->total_expense, 2) }}</td>
                                            <td>
                                                @if ($register->status === 'CLOSED')
                                                    ${{ number_format($register->final_balance, 2) }}
                                                @else
                                                    ${{ number_format($register->current_balance, 2) }}
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $register->status === 'OPEN' ? 'success' : 'secondary' }}">
                                                    {{ $register->status === 'OPEN' ? 'Abierta' : 'Cerrada' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.cash-registers.show', $register) }}"
                                                        class="btn btn-info btn-sm" title="Ver detalles">
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    @if ($register->status === 'OPEN')
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            title="Cerrar caja"
                                                            onclick="openCloseModal({{ $register->id }}, {{ $register->current_balance }})">
                                                            <i class="ti-close"></i>
                                                        </button>
                                                    @endif
                                                    @if ($register->status === 'CLOSED')
                                                        <form
                                                            action="{{ route('admin.cash-registers.destroy', $register) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('¿Está seguro de eliminar esta caja?')">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No hay registros de caja</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $cashRegisters->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para cerrar caja -->
    <div class="modal fade" id="closeCashRegisterModal" tabindex="-1" aria-labelledby="closeCashRegisterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeCashRegisterModalLabel">Cerrar Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="closeCashRegisterForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <strong>Saldo Actual:</strong> <span id="currentBalance">$0.00</span>
                        </div>
                        <div class="mb-3">
                            <label for="final_amount" class="form-label">Monto Final <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control @error('final_amount') is-invalid @enderror"
                                    id="final_amount" name="final_amount" required min="0">
                            </div>
                            @error('final_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Cerrar Caja</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Función para obtener el token CSRF
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        // Función para abrir el modal
        window.openCloseModal = function(registerId, currentBalance) {
            // Actualizar el saldo actual en el modal
            document.getElementById('currentBalance').textContent = '$' + currentBalance.toFixed(2);

            // Establecer el valor inicial del monto final
            document.getElementById('final_amount').value = currentBalance;

            // Actualizar la acción del formulario
            document.getElementById('closeCashRegisterForm').action = `/admin/cash-registers/${registerId}/close`;

            // Mostrar el modal
            const closeModal = new bootstrap.Modal(document.getElementById('closeCashRegisterModal'));
            closeModal.show();
        };

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar el envío del formulario
            const closeForm = document.getElementById('closeCashRegisterForm');
            if (closeForm) {
                closeForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const csrfToken = getCsrfToken();

                    if (!csrfToken) {
                        alert('Error: No se pudo obtener el token CSRF');
                        return;
                    }

                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            alert(data.message);
                            // Recargar la página
                            window.location.reload();
                        } else {
                            // Mostrar mensaje de error
                            alert(data.message || 'Error al cerrar la caja');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al procesar la solicitud');
                    });
                });
            }
        });
    </script>
@endsection

@push('scripts')
<script>
    // Función para obtener el token CSRF
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    // Función para abrir el modal
    window.openCloseModal = function(registerId, currentBalance) {
        // Actualizar el saldo actual en el modal
        document.getElementById('currentBalance').textContent = '$' + currentBalance.toFixed(2);

        // Establecer el valor inicial del monto final
        document.getElementById('final_amount').value = currentBalance;

        // Actualizar la acción del formulario
        document.getElementById('closeCashRegisterForm').action = `/admin/cash-registers/${registerId}/close`;

        // Mostrar el modal
        const closeModal = new bootstrap.Modal(document.getElementById('closeCashRegisterModal'));
        closeModal.show();
    };
</script>
@endpush
