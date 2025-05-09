@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Órdenes de Servicio</h5>
                    <a href="{{ route('service-orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Orden
                    </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N° Orden</th>
                                    <th>Cliente</th>
                                    <th>Dispositivo</th>
                                    <th>Estado</th>
                                    <th>Costo Est.</th>
                                    <th>Costo Final</th>
                                    <th>Fecha Entrega</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($serviceOrders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->customer->name }}</td>
                                        <td>{{ $order->deviceModel->name }}</td>
                                        <td>
                                            <span class="badge status-badge"
                                                    style="background-color: {{ $order->status->color }}"
                                                    data-order-id="{{ $order->id }}"
                                                    data-status-id="{{ $order->status_id }}">
                                                {{ $order->status->name }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($order->estimated_cost, 2) }}</td>
                                        <td>${{ $order->final_cost ? number_format($order->final_cost, 2) : '-' }}</td>
                                        <td>{{ $order->estimated_delivery_date ? $order->estimated_delivery_date->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('service-orders.show', $order) }}"
                                                   class="btn btn-sm btn-info"
                                                   title="Ver">
                                                    <i class="icon-eye"></i>
                                                </a>
                                                <a href="{{ route('service-orders.edit', $order) }}"
                                                   class="btn btn-sm btn-warning"
                                                   title="Editar">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('service-orders.destroy', $order) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Está seguro de eliminar esta orden?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger"
                                                            title="Eliminar">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No hay órdenes de servicio registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $serviceOrders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Cambiar Estado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" id="orderId">
                        <select class="form-control" id="statusSelect">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveStatusBtn">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        //console.log('ready');

        $('.status-badge').click(function() {
            const orderId = $(this).data('order-id');
            const statusId = $(this).data('status-id');
            $('#statusModal').modal('show');
            $('#statusSelect').val(statusId);
            $('#orderId').val(orderId);
        });

        $('#saveStatusBtn').click(function() {
            const orderId = $('#orderId').val();
            const statusId = $('#statusSelect').val();
            const token = $('meta[name="csrf-token"]').attr('content');
            //console.log(orderId, statusId);

            $.ajax({
                url: "{{ route('service-orders.update-status', ['serviceOrder' => ':id']) }}".replace(':id', orderId),
                type: 'POST',
                data: { status_id: statusId, _token: token },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

        });

    });
</script>
@endpush