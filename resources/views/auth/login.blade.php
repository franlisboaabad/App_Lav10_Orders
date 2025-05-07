<x-guest-layout>
    <h4>¡Hola! Empecemos</h4>
    <h6 class="font-weight-light">Inicia sesión para continuar.</h6>
    <form class="pt-3" method="POST" action="{{ route('login') }}">
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
        <div class="form-group">
            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                   id="password" name="password" placeholder="Contraseña" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                INICIAR SESIÓN
            </button>
        </div>
        <div class="my-2 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    Mantener sesión iniciada
                </label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link text-black">¿Olvidaste tu contraseña?</a>
            @endif
        </div>
        <div class="text-center mt-4 font-weight-light">
            ¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-primary">Regístrate</a>
        </div>
    </form>
</x-guest-layout>
