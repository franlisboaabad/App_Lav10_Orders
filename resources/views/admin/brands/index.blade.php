@extends('layouts.app')

@section('content')


<div class="content-wrapper">

    <div class="row">
        <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">

                @include('partials._validations')

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Marcas</h4>
                    <a href="{{ route('brands.create') }}" class="btn btn-primary">
                        <i class="icon-plus"></i> Nueva Marca
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-brands">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ Str::limit($brand->description, 50) }}</td>
                                    <td>
                                        <span class="badge {{ $brand->is_active ? 'badge-success' : 'badge-danger' }}">
                                            {{ $brand->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ $brand->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('brands.edit', $brand) }}" class="btn btn-primary btn-sm">
                                            <i class="ti-pencil"></i>
                                        </a>
                                        <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta marca?')">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay marcas registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#table-brands').DataTable();
    });
</script>
@endsection