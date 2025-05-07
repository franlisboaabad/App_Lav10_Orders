<x-guest-layout>
    <h4>¿Olvidaste tu contraseña?</h4>
    <h6 class="font-weight-light">Ingresa tu email para recuperar tu contraseña.</h6>

    <!-- Session Status -->
    <div class="alert alert-info">
        {{ session('status') }}
    </div>

    <form class="pt-3" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                ENVIAR ENLACE DE RECUPERACIÓN
            </button>
        </div>

        <div class="text-center mt-4 font-weight-light">
            ¿Recordaste tu contraseña? <a href="{{ route('login') }}" class="text-primary">Iniciar sesión</a>
        </div>
    </form>
</x-guest-layout>
