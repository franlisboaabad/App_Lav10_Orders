<x-guest-layout>
    <h4>¡Nuevo por aquí?</h4>
    <h6 class="font-weight-light">Regístrate para continuar.</h6>
    <form class="pt-3" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name') }}" placeholder="Nombre" required autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                   id="password" name="password" placeholder="Contraseña" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-lg"
                   id="password_confirmation" name="password_confirmation" placeholder="Confirmar contraseña" required>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                REGISTRARSE
            </button>
        </div>

        <div class="text-center mt-4 font-weight-light">
            ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-primary">Iniciar sesión</a>
        </div>
    </form>
</x-guest-layout>
