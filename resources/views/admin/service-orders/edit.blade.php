@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Editar Orden de Servicio</h4>
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
                                                {{ $model->brand->name }} - {{ $model->name }}
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
                                    <label for="status_id" class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status_id') is-invalid @enderror form-control" id="status_id" name="status_id" required>
                                        <option value="">Seleccione un estado</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id', $serviceOrder->status_id) == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="specialist_id" class="form-label">Especialista Asignado</label>
                                    <select class="form-select @error('specialist_id') is-invalid @enderror form-control" id="specialist_id" name="specialist_id">
                                        <option value="">Seleccione un especialista</option>
                                        @foreach($specialists as $specialist)
                                            <option value="{{ $specialist->id }}" {{ old('specialist_id', $serviceOrder->specialist_id) == $specialist->id ? 'selected' : '' }}>
                                                {{ $specialist->name }}
                                                @if($specialist->specialties)
                                                    ({{ implode(', ', $specialist->specialties) }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialist_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

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
                        </div>

                        <div class="row">
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

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estimated_delivery_date" class="form-label">Fecha Estimada de Entrega</label>
                                    <input type="date" class="form-control @error('estimated_delivery_date') is-invalid @enderror" id="estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date', $serviceOrder->estimated_delivery_date ? $serviceOrder->estimated_delivery_date->format('Y-m-d') : '') }}">
                                    @error('estimated_delivery_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
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

                        <div class="mb-3">
                            <h5>Productos Utilizados</h5>
                            <div id="products-container">
                                @foreach($serviceOrder->products as $index => $product)
                                    <div class="row product-row mb-2">
                                        <div class="col-md-4">
                                            <select class="form-select product-select form-control"
                                                    name="products[{{ $index }}][product_id]"
                                                    required>
                                                <option value="">Seleccione un producto</option>
                                                @foreach($products as $p)
                                                    <option value="{{ $p->id }}"
                                                        data-price="{{ $p->price }}"
                                                        data-stock="{{ $p->stock }}"
                                                        {{ $product->id == $p->id ? 'selected' : '' }}>
                                                        {{ $p->name }} (Stock: {{ $p->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control quantity-input"
                                                   name="products[{{ $index }}][quantity]"
                                                   placeholder="Cantidad"
                                                   min="1"
                                                   value="{{ $product->pivot->quantity }}"
                                                   required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control price-input"
                                                   name="products[{{ $index }}][unit_price]"
                                                   placeholder="Precio"
                                                   step="0.01"
                                                   value="{{ $product->pivot->unit_price }}"
                                                   required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control"
                                                   name="products[{{ $index }}][notes]"
                                                   placeholder="Notas"
                                                   value="{{ $product->pivot->notes }}">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-product">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-success mt-2" id="add-product">
                                <i class="ti-plus"></i> Agregar Producto
                            </button>
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

@push('scripts')
<script>
$(document).ready(function() {
    let productCount = {{ $serviceOrder->products->count() }};

    // Agregar nuevo producto
    $('#add-product').click(function() {
        const template = `
            <div class="row product-row mb-2">
                <div class="col-md-4">
                    <select class="form-select product-select form-control" name="products[${productCount}][product_id]" required>
                        <option value="">Seleccione un producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}">
                                {{ $product->name }} (Stock: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control quantity-input"
                           name="products[${productCount}][quantity]"
                           placeholder="Cantidad"
                           min="1"
                           required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control price-input"
                           name="products[${productCount}][unit_price]"
                           placeholder="Precio"
                           step="0.01"
                           required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control"
                           name="products[${productCount}][notes]"
                           placeholder="Notas">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-product">
                        <i class="ti-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#products-container').append(template);
        productCount++;
    });

    // Eliminar producto
    $(document).on('click', '.remove-product', function() {
        $(this).closest('.product-row').remove();
    });

    // Actualizar precio al seleccionar producto
    $(document).on('change', '.product-select', function() {
        const row = $(this).closest('.product-row');
        const selectedOption = $(this).find('option:selected');
        const price = selectedOption.data('price');
        const stock = selectedOption.data('stock');

        row.find('.price-input').val(price);
        row.find('.quantity-input').attr('max', stock);
    });

    // Validar cantidad contra stock
    $(document).on('change', '.quantity-input', function() {
        const row = $(this).closest('.product-row');
        const select = row.find('.product-select');
        const selectedOption = select.find('option:selected');
        const stock = selectedOption.data('stock');
        const quantity = parseInt($(this).val());

        if (quantity > stock) {
            alert('La cantidad no puede ser mayor al stock disponible');
            $(this).val(stock);
        }
    });
});
</script>
@endpush
