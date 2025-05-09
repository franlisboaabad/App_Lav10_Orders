@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Editar Especialista</h4>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.specialists.update', $specialist) }}" method="POST" class="forms-sample">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $specialist->name) }}"
                                   required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $specialist->email) }}"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', $specialist->phone) }}">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="document_number">Número de Documento</label>
                            <input type="text"
                                   class="form-control @error('document_number') is-invalid @enderror"
                                   id="document_number"
                                   name="document_number"
                                   value="{{ old('document_number', $specialist->document_number) }}">
                            @error('document_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="specialties">Especialidades</label>
                            <select class="form-control @error('specialties') is-invalid @enderror"
                                    id="specialties"
                                    name="specialties[]"
                                    multiple>
                                <option value="Reparación de Celulares" {{ in_array('Reparación de Celulares', $specialist->specialties ?? []) ? 'selected' : '' }}>
                                    Reparación de Celulares
                                </option>
                                <option value="Reparación de Laptops" {{ in_array('Reparación de Laptops', $specialist->specialties ?? []) ? 'selected' : '' }}>
                                    Reparación de Laptops
                                </option>
                                <option value="Reparación de Tablets" {{ in_array('Reparación de Tablets', $specialist->specialties ?? []) ? 'selected' : '' }}>
                                    Reparación de Tablets
                                </option>
                                <option value="Reparación de Consolas" {{ in_array('Reparación de Consolas', $specialist->specialties ?? []) ? 'selected' : '' }}>
                                    Reparación de Consolas
                                </option>
                                <option value="Mantenimiento Preventivo" {{ in_array('Mantenimiento Preventivo', $specialist->specialties ?? []) ? 'selected' : '' }}>
                                    Mantenimiento Preventivo
                                </option>
                                <option value="Recuperación de Datos" {{ in_array('Recuperación de Datos', $specialist->specialties ?? []) ? 'selected' : '' }}>
                                    Recuperación de Datos
                                </option>
                            </select>
                            @error('specialties')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="notes">Notas</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes"
                                      name="notes"
                                      rows="3">{{ old('notes', $specialist->notes) }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', $specialist->is_active) ? 'checked' : '' }}>
                                    Activo
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
                        <a href="{{ route('admin.specialists.index') }}" class="btn btn-light">Cancelar</a>
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
        $('#specialties').select2({
            placeholder: 'Seleccione las especialidades',
            allowClear: true
        });
    });
</script>
@endpush
