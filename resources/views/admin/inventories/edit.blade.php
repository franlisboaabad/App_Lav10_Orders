@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Editar Inventario</h4>

                    <form action="{{ route('inventories.update', $inventory) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Producto</label>
                                    <input type="text" class="form-control" value="{{ $inventory->product->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Código</label>
                                    <input type="text" class="form-control" value="{{ $inventory->product->code }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                           id="quantity" name="quantity"
                                           value="{{ old('quantity', $inventory->quantity) }}"
                                           min="0" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="min_stock" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('min_stock') is-invalid @enderror"
                                           id="min_stock" name="min_stock"
                                           value="{{ old('min_stock', $inventory->min_stock) }}"
                                           min="0" required>
                                    @error('min_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="max_stock" class="form-label">Stock Máximo <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('max_stock') is-invalid @enderror"
                                           id="max_stock" name="max_stock"
                                           value="{{ old('max_stock', $inventory->max_stock) }}"
                                           min="0" required>
                                    @error('max_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="adjustment_notes" class="form-label">Notas del Ajuste</label>
                            <textarea class="form-control @error('adjustment_notes') is-invalid @enderror"
                                      id="adjustment_notes" name="adjustment_notes"
                                      rows="3">{{ old('adjustment_notes') }}</textarea>
                            <small class="text-muted">Obligatorio si se modifica el stock actual</small>
                            @error('adjustment_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('inventories.show', $inventory) }}" class="btn btn-secondary me-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Inventario</button>
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
    // Validar que el stock máximo sea mayor que el mínimo
    $('#max_stock').on('change', function() {
        const minStock = parseInt($('#min_stock').val());
        const maxStock = parseInt($(this).val());

        if (maxStock <= minStock) {
            alert('El stock máximo debe ser mayor que el stock mínimo');
            $(this).val(minStock + 1);
        }
    });

    // Validar que el stock mínimo sea menor que el máximo
    $('#min_stock').on('change', function() {
        const minStock = parseInt($(this).val());
        const maxStock = parseInt($('#max_stock').val());

        if (minStock >= maxStock) {
            alert('El stock mínimo debe ser menor que el stock máximo');
            $(this).val(maxStock - 1);
        }
    });
});
</script>
@endpush
