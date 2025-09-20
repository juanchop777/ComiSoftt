<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="auth-container p-4">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-gavel text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h1 class="brand-logo mb-2">ComiSoft</h1>
                        <p class="text-muted mb-0">Sistema de Gestión de Comités</p>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Correo Electrónico
                            </label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Contraseña
                            </label>
                            <input id="password" name="password" type="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input id="remember_me" name="remember" type="checkbox" class="form-check-input">
                                <label for="remember_me" class="form-check-label text-muted">Recordarme</label>
                            </div>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="link-primary">¿Olvidaste tu contraseña?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                        </button>

                        <div class="text-center">
                            <span class="text-muted">¿No tienes una cuenta?</span>
                            <a href="{{ route('register') }}" class="link-primary ms-1">Regístrate aquí</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>