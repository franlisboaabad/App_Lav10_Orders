@extends('layouts.app')

@section('content')
<div class="row mt-5">
    <div class="col-12 grid-margin stretch-card">
        <div class="card corona-gradient-card">
            <div class="card-body py-0 px-0 px-sm-3">
                <div class="row align-items-center">
                    <div class="col-4 col-sm-3 col-xl-2">
                        @if($company && $company->logo)
                            <img src="{{ Storage::url($company->logo) }}" class="gradient-corona-img img-fluid" alt="">
                        @else
                            <img src="{{ asset('assets/images/dashboard/Group126@2x.png') }}" class="gradient-corona-img img-fluid" alt="">
                        @endif
                    </div>
                    <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                            <h6 class="mb-1 mb-sm-0">Información de la Empresa</h6>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">Detalles de la empresa</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin">
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
@endsection
