@extends('layouts.app')

@section('content')
<div class="content-wrapper">


    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Registrar Movimiento</h4>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.cash-movements.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Movimiento</label>
                                    <select class="form-select @error('type') is-invalid @enderror form-control"
                                            name="type"
                                            required>
                                        <option value="">Seleccione un tipo</option>
                                        <option value="INCOME" {{ old('type') === 'INCOME' ? 'selected' : '' }}>Ingreso</option>
                                        <option value="EXPENSE" {{ old('type') === 'EXPENSE' ? 'selected' : '' }}>Egreso</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Monto</label>
                                    <input type="number"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           name="amount"
                                           step="0.01"
                                           min="0.01"
                                           value="{{ old('amount') }}"
                                           required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                              rows="3"
                                              required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
                                <a href="{{ route('admin.cash-registers.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
