<x-guest-layout>
    <div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 50%, #c5cae9 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="text-center mb-5">
                        <!-- Logo -->
                        <div class="mx-auto mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
                            <i class="fas fa-gavel text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h2 class="h3 fw-bold text-dark mb-2">
                            Únete a ComiSoft
                        </h2>
                        <p class="text-muted fw-medium">
                            Crea tu cuenta para acceder al sistema
                        </p>
                    </div>

                    <!-- Register Form -->
                    <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9);">
                        <div class="card-body p-4 p-md-5">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        Nombre Completo
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <input id="name" 
                                               name="name" 
                                               type="text" 
                                               value="{{ old('name') }}"
                                               required 
                                               autofocus 
                                               autocomplete="name"
                                               class="form-control border-start-0 ps-0"
                                               style="border-radius: 0 10px 10px 0; border: 2px solid #e9ecef;"
                                               placeholder="Tu nombre completo">
                                    </div>
                                    @error('name')
                                        <div class="mt-2 text-danger small d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        Correo Electrónico
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </span>
                                        <input id="email" 
                                               name="email" 
                                               type="email" 
                                               value="{{ old('email') }}"
                                               required 
                                               autocomplete="username"
                                               class="form-control border-start-0 ps-0"
                                               style="border-radius: 0 10px 10px 0; border: 2px solid #e9ecef;"
                                               placeholder="tu@email.com">
                                    </div>
                                    @error('email')
                                        <div class="mt-2 text-danger small d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-lock text-primary me-2"></i>
                                        Contraseña
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-primary"></i>
                                        </span>
                                        <input id="password" 
                                               name="password" 
                                               type="password" 
                                               required 
                                               autocomplete="new-password"
                                               class="form-control border-start-0 ps-0"
                                               style="border-radius: 0 10px 10px 0; border: 2px solid #e9ecef;"
                                               placeholder="••••••••">
                                    </div>
                                    @error('password')
                                        <div class="mt-2 text-danger small d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-lock text-primary me-2"></i>
                                        Confirmar Contraseña
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-primary"></i>
                                        </span>
                                        <input id="password_confirmation" 
                                               name="password_confirmation" 
                                               type="password" 
                                               required 
                                               autocomplete="new-password"
                                               class="form-control border-start-0 ps-0"
                                               style="border-radius: 0 10px 10px 0; border: 2px solid #e9ecef;"
                                               placeholder="••••••••">
                                    </div>
                                    @error('password_confirmation')
                                        <div class="mt-2 text-danger small d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Terms and Conditions -->
                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="mb-4 p-3" style="background: linear-gradient(135deg, #f8f9ff 0%, #e8f4fd 100%); border-radius: 12px; border: 2px solid #e3f2fd;">
                                        <div class="form-check">
                                            <input id="terms" 
                                                   name="terms" 
                                                   type="checkbox" 
                                                   required
                                                   class="form-check-input">
                                            <label for="terms" class="form-check-label text-dark">
                                                Acepto los 
                                                <a href="{{ route('terms.show') }}" 
                                                   target="_blank"
                                                   class="text-decoration-none fw-medium text-primary">
                                                    términos de servicio
                                                </a> 
                                                y la 
                                                <a href="{{ route('policy.show') }}" 
                                                   target="_blank"
                                                   class="text-decoration-none fw-medium text-primary">
                                                    política de privacidad
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                <!-- Register Button -->
                                <div class="d-grid mb-4">
                                    <button type="submit" 
                                            class="btn btn-primary btn-lg fw-semibold"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 12px; padding: 12px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); transition: all 0.3s ease;">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Crear Cuenta
                                    </button>
                                </div>

                                <!-- Validation Errors -->
                                @if ($errors->any())
                                    <div class="alert alert-danger border-0" style="border-radius: 12px;">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                            <div>
                                                <h6 class="fw-semibold mb-2">Errores de validación</h6>
                                                <ul class="mb-0 ps-3">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </form>

                            <!-- Login Link -->
                            <div class="text-center pt-3">
                                <p class="text-muted mb-0">
                                    ¿Ya tienes una cuenta? 
                                    <a href="{{ route('login') }}" 
                                       class="text-decoration-none fw-semibold text-primary">
                                        Inicia sesión aquí
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <p class="text-muted small">
                            © {{ date('Y') }} ComiSoft. Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
        }
        
        .input-group-text {
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .form-check-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>
</x-guest-layout>
