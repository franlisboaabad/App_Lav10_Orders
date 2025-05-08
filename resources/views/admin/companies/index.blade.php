@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="row">
        <div class="col-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($company)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Campo</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Nombre</strong></td>
                                        <td>{{ $company->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>RUC</strong></td>
                                        <td>{{ $company->ruc }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dirección</strong></td>
                                        <td>{{ $company->address }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Teléfono</strong></td>
                                        <td>{{ $company->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>{{ $company->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Descripción</strong></td>
                                        <td>{{ $company->description }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Logo</strong></td>
                                        <td>
                                            @if($company->logo)
                                                <img src="{{ Storage::url($company->logo) }}" alt="Logo de la empresa" class="img-thumbnail" style="max-height: 100px;">
                                            @else
                                                <span class="text-muted">No hay logo</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Acciones</strong></td>
                                        <td>
                                            <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary btn-sm">
                                                <i class="icon-pencil"></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="alert alert-info mb-4">
                                No hay información de la empresa registrada.
                            </div>
                            <a href="{{ route('companies.edit', 1) }}" class="btn btn-primary">
                                <i class="icon-plus"></i> Registrar Información de la Empresa
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>




@endsection
