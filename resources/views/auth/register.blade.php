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
                        <p class="text-muted mb-0">Crea tu cuenta para acceder al sistema</p>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2"></i>Nombre Completo
                            </label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Correo Electrónico
                            </label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Contraseña
                            </label>
                            <input id="password" name="password" type="password" required autocomplete="new-password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-2"></i>Confirmar Contraseña
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mb-3">
                                <div class="form-check">
                                    <input id="terms" name="terms" type="checkbox" required class="form-check-input @error('terms') is-invalid @enderror">
                                    <label for="terms" class="form-check-label text-muted">
                                        Acepto los <a href="{{ route('terms.show') }}" class="link-primary">términos de servicio</a> y la <a href="{{ route('policy.show') }}" class="link-primary">política de privacidad</a>
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i> Crear Cuenta
                        </button>

                        <div class="text-center">
                            <span class="text-muted">¿Ya tienes una cuenta?</span>
                            <a href="{{ route('login') }}" class="link-primary ms-1">Inicia sesión aquí</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>