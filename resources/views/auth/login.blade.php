<x-guest-layout>
    <div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: radial-gradient(1000px 600px at 20% 0%, #e9d5ff 0%, transparent 70%), radial-gradient(1200px 700px at 120% -10%, #bfdbfe 0%, transparent 70%), linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center mb-4">
                        <div class="mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 18px; display: grid; place-items: center; background: conic-gradient(from 180deg at 50% 50%, #6366f1, #8b5cf6, #06b6d4, #6366f1); box-shadow: 0 12px 30px rgba(99,102,241,.35);">
                            <i class="fas fa-gavel text-white" style="font-size: 1.9rem;"></i>
                        </div>
                        <h1 class="h4 fw-bold text-dark mb-1">Bienvenido</h1>
                        <p class="text-secondary mb-0">Sistema de Gestión de Comités</p>
                    </div>

                    <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255,255,255,.9); backdrop-filter: blur(6px);">
                        <div class="card-body p-4 p-md-5">
                            @if (session('status'))
                                <div class="alert alert-success border-0 mb-4" style="border-radius: 12px;">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span class="fw-medium">{{ session('status') }}</span>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger border-0 mb-4" style="border-radius: 12px;">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" novalidate>
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark">Correo Electrónico</label>
                                    <div class="position-relative">
                                        <span class="position-absolute top-50 translate-middle-y ms-3 text-primary"><i class="fas fa-envelope"></i></span>
                                        <input id="email"
                                               name="email"
                                               type="email"
                                               value="{{ old('email') }}"
                                               required
                                               autofocus
                                               autocomplete="username"
                                               class="form-control ps-5"
                                               style="height: 48px; border-radius: 12px; border: 2px solid #e5e7eb;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold text-dark">Contraseña</label>
                                    <div class="position-relative">
                                        <span class="position-absolute top-50 translate-middle-y ms-3 text-primary"><i class="fas fa-lock"></i></span>
                                        <input id="password"
                                               name="password"
                                               type="password"
                                               required
                                               autocomplete="current-password"
                                               class="form-control ps-5"
                                               style="height: 48px; border-radius: 12px; border: 2px solid #e5e7eb;">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input id="remember_me" name="remember" type="checkbox" class="form-check-input">
                                        <label for="remember_me" class="form-check-label text-muted">Recordarme</label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none fw-medium" style="color: #6366f1;">¿Olvidaste tu contraseña?</a>
                                    @endif
                                </div>

                                <button type="submit" class="btn w-100 fw-semibold" style="height: 48px; border-radius: 12px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%); border: none; color: #fff; box-shadow: 0 8px 24px rgba(79,70,229,.35); transition: transform .15s ease, box-shadow .15s ease;">
                                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                                </button>

                                <div class="text-center mt-4">
                                    <span class="text-muted">¿No tienes una cuenta?</span>
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #6366f1;">Regístrate aquí</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">© {{ date('Y') }} ComiSoft. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus { border-color: #6366f1 !important; box-shadow: 0 0 0 .20rem rgba(99, 102, 241, .15) !important; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(79,70,229,.45) !important; }
        .card { transition: transform .25s ease, box-shadow .25s ease; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 24px 48px rgba(2,6,23,.08) !important; }
    </style>
</x-guest-layout>
