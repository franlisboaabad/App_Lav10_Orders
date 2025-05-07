@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('service-orders.index') }}">Órdenes de Servicio</a></li>
                        <li class="breadcrumb-item active">Editar Orden</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar Orden de Servicio</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('service-orders.update', $serviceOrder) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Cliente <span class="text-danger">*</span></label>
                                    <select class="form-select @error('customer_id') is-invalid @enderror form-control" id="customer_id" name="customer_id" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $serviceOrder->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="device_model_id" class="form-label">Modelo de Dispositivo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('device_model_id') is-invalid @enderror form-control" id="device_model_id" name="device_model_id" required>
                                        <option value="">Seleccione un modelo</option>
                                        @foreach($deviceModels as $model)
                                            <option value="{{ $model->id }}" {{ old('device_model_id', $serviceOrder->device_model_id) == $model->id ? 'selected' : '' }}>
                                                {{ $model->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('device_model_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="serial_number" class="form-label">Número de Serie</label>
                                    <input type="text" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" name="serial_number" value="{{ old('serial_number', $serviceOrder->serial_number) }}">
                                    @error('serial_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror form-control" id="status" name="status" required>
                                        <option value="PENDING" {{ old('status', $serviceOrder->status) == 'PENDING' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="IN_DIAGNOSIS" {{ old('status', $serviceOrder->status) == 'IN_DIAGNOSIS' ? 'selected' : '' }}>En Diagnóstico</option>
                                        <option value="WAITING_APPROVAL" {{ old('status', $serviceOrder->status) == 'WAITING_APPROVAL' ? 'selected' : '' }}>Esperando Aprobación</option>
                                        <option value="IN_REPAIR" {{ old('status', $serviceOrder->status) == 'IN_REPAIR' ? 'selected' : '' }}>En Reparación</option>
                                        <option value="READY" {{ old('status', $serviceOrder->status) == 'READY' ? 'selected' : '' }}>Listo</option>
                                        <option value="DELIVERED" {{ old('status', $serviceOrder->status) == 'DELIVERED' ? 'selected' : '' }}>Entregado</option>
                                        <option value="CANCELLED" {{ old('status', $serviceOrder->status) == 'CANCELLED' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estimated_cost" class="form-label">Costo Estimado <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control @error('estimated_cost') is-invalid @enderror" id="estimated_cost" name="estimated_cost" value="{{ old('estimated_cost', $serviceOrder->estimated_cost) }}" required>
                                    </div>
                                    @error('estimated_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="final_cost" class="form-label">Costo Final</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control @error('final_cost') is-invalid @enderror" id="final_cost" name="final_cost" value="{{ old('final_cost', $serviceOrder->final_cost) }}">
                                    </div>
                                    @error('final_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estimated_delivery_date" class="form-label">Fecha Estimada de Entrega</label>
                                    <input type="date" class="form-control @error('estimated_delivery_date') is-invalid @enderror" id="estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date', $serviceOrder->estimated_delivery_date ? $serviceOrder->estimated_delivery_date->format('Y-m-d') : '') }}">
                                    @error('estimated_delivery_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="delivery_date" class="form-label">Fecha de Entrega</label>
                                    <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $serviceOrder->delivery_date ? $serviceOrder->delivery_date->format('Y-m-d') : '') }}">
                                    @error('delivery_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="problem_description" class="form-label">Descripción del Problema <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('problem_description') is-invalid @enderror" id="problem_description" name="problem_description" rows="3" required>{{ old('problem_description', $serviceOrder->problem_description) }}</textarea>
                            @error('problem_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnóstico</label>
                            <textarea class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" rows="3">{{ old('diagnosis', $serviceOrder->diagnosis) }}</textarea>
                            @error('diagnosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="solution" class="form-label">Solución</label>
                            <textarea class="form-control @error('solution') is-invalid @enderror" id="solution" name="solution" rows="3">{{ old('solution', $serviceOrder->solution) }}</textarea>
                            @error('solution')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas Adicionales</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $serviceOrder->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('service-orders.index') }}" class="btn btn-secondary me-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Orden de Servicio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
