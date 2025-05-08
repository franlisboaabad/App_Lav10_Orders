@extends('layouts.app')

@section('content')

<div class="content-wrapper">

<div class="row">
    <div class="col-6 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Información del Modelo de Dispositivo</h4>
                <form action="{{ route('device-models.update', $deviceModel) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $deviceModel->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="brand_id">Marca</label>
                        <select class="form-control @error('brand_id') is-invalid @enderror"
                                id="brand_id" name="brand_id" required>
                            <option value="">Seleccione una marca</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id', $deviceModel->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="device_type_id">Tipo de Dispositivo</label>
                        <select class="form-control @error('device_type_id') is-invalid @enderror"
                                id="device_type_id" name="device_type_id" required>
                            <option value="">Seleccione un tipo</option>
                            @foreach($deviceTypes as $deviceType)
                                <option value="{{ $deviceType->id }}"
                                    {{ old('device_type_id', $deviceModel->device_type_id) == $deviceType->id ? 'selected' : '' }}>
                                    {{ $deviceType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('device_type_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4">{{ old('description', $deviceModel->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                       {{ old('is_active', $deviceModel->is_active) ? 'checked' : '' }}>
                                Activo
                            </label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
                        <a href="{{ route('device-models.index') }}" class="btn btn-light">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
