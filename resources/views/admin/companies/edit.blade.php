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
                            <h6 class="mb-1 mb-sm-0">Editar Información de la Empresa</h6>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">Actualizar datos de la empresa</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-6 grid-margin">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ route('companies.update', $company) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nombre de la Empresa</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $company->name ?? '') }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ruc">RUC</label>
                        <input type="text" class="form-control @error('ruc') is-invalid @enderror" id="ruc" name="ruc" value="{{ old('ruc', $company->ruc ?? '') }}" required>
                        @error('ruc')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $company->address ?? '') }}" required>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $company->phone ?? '') }}" required>
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $company->email ?? '') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                        @error('logo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @if(isset($company) && $company->logo)
                            <div class="mt-2">
                                <img src="{{ Storage::url($company->logo) }}" alt="Logo actual" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $company->description ?? '') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Guardar Cambios</button>
                    <a href="{{ route('companies.index') }}" class="btn btn-light">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection