<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ComiSoft - Sistema de Gestión de Comités</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --text-color: #374151;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.95) 0%, rgba(30, 64, 175, 0.95) 100%);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-hero {
            padding: 12px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-primary-hero {
            background: white;
            color: var(--primary-color);
            border-color: white;
        }

        .btn-primary-hero:hover {
            background: transparent;
            color: white;
            border-color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .btn-outline-hero {
            background: transparent;
            color: white;
            border-color: white;
        }

        .btn-outline-hero:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .features-section {
            padding: 80px 0;
            background: white;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .feature-description {
            color: #6b7280;
            line-height: 1.6;
        }

        .stats-section {
            background: var(--light-color);
            padding: 60px 0;
        }

        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            color: var(--text-color);
            font-weight: 500;
        }

        .cta-section {
            background: linear-gradient(135deg, var(--dark-color) 0%, #374151 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-color) !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-nav {
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-nav-primary {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
        }

        .btn-nav-primary:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
        }

        .btn-nav-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-nav-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .cta-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-gavel me-2"></i>ComiSoft
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Características</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Acerca de</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-nav btn-nav-primary ms-2" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-nav btn-nav-outline me-2" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="btn btn-nav btn-nav-primary" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>Registrarse
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">
                        Gestión Inteligente de <span class="text-warning">Comités</span>
                    </h1>
                    <p class="hero-subtitle">
                        Sistema integral para la administración eficiente de comités académicos y disciplinarios. 
                        Simplifica procesos, mejora la transparencia y optimiza la toma de decisiones.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary-hero">
                                <i class="fas fa-rocket me-2"></i>Ir al Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary-hero">
                                <i class="fas fa-rocket me-2"></i>Comenzar Ahora
                            </a>
                        @endauth
                        <a href="#features" class="btn btn-outline-hero">
                            <i class="fas fa-info-circle me-2"></i>Conocer Más
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="position-relative">
                        <div class="bg-white rounded-4 p-4 shadow-lg" style="transform: rotate(-2deg);">
                            <i class="fas fa-gavel text-primary" style="font-size: 8rem; opacity: 0.8;"></i>
                        </div>
                        <div class="bg-success text-white rounded-4 p-3 shadow-lg position-absolute" 
                             style="top: -20px; right: -20px; transform: rotate(5deg);">
                            <i class="fas fa-check-circle" style="font-size: 2rem;"></i>
                        </div>
                        <div class="bg-warning text-white rounded-4 p-3 shadow-lg position-absolute" 
                             style="bottom: -20px; left: -20px; transform: rotate(-5deg);">
                            <i class="fas fa-users" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-4 fw-bold mb-3">¿Qué es ComiSoft?</h2>
                    <p class="lead text-muted">
                        Una plataforma integral diseñada específicamente para la gestión eficiente de comités académicos y disciplinarios
                    </p>
                </div>
            </div>
            
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="pe-lg-5">
                        <h3 class="h2 fw-bold mb-4 text-primary">Sistema de Comités Académicos</h3>
                        <p class="lead mb-4">
                            ComiSoft facilita la gestión completa de comités que evalúan casos académicos, 
                            disciplinarios y de comportamiento estudiantil en instituciones educativas.
                        </p>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Registro y seguimiento de actas de comité</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Gestión de sesiones y decisiones</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Clasificación de faltas y sanciones</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Reportes y estadísticas detalladas</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-light rounded-4 p-5 text-center">
                        <i class="fas fa-graduation-cap text-primary mb-4" style="font-size: 4rem;"></i>
                        <h4 class="fw-bold mb-3">Comités Académicos</h4>
                        <p class="text-muted">
                            Evaluación de casos académicos, faltas disciplinarias y 
                            toma de decisiones colegiadas con transparencia total.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="ps-lg-5">
                        <h3 class="h2 fw-bold mb-4 text-success">Proceso Simplificado</h3>
                        <p class="lead mb-4">
                            Desde el registro inicial de un caso hasta la resolución final, 
                            ComiSoft guía cada paso del proceso de manera organizada y eficiente.
                        </p>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded-3">
                                    <i class="fas fa-file-alt text-primary mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="fw-bold">Acta</h6>
                                    <small class="text-muted">Registro inicial</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded-3">
                                    <i class="fas fa-users text-success mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="fw-bold">Comité</h6>
                                    <small class="text-muted">Evaluación</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded-3">
                                    <i class="fas fa-gavel text-warning mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="fw-bold">Decisión</h6>
                                    <small class="text-muted">Resolución</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded-3">
                                    <i class="fas fa-chart-bar text-info mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="fw-bold">Seguimiento</h6>
                                    <small class="text-muted">Monitoreo</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="bg-light rounded-4 p-5 text-center">
                        <i class="fas fa-clipboard-list text-success mb-4" style="font-size: 4rem;"></i>
                        <h4 class="fw-bold mb-3">Flujo de Trabajo</h4>
                        <p class="text-muted">
                            Proceso estructurado que garantiza la consistencia 
                            y el cumplimiento de protocolos institucionales.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-4 fw-bold mb-3">Beneficios del Sistema</h2>
                    <p class="lead text-muted">
                        Descubre cómo ComiSoft transforma la gestión de comités en tu institución
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-clock" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Ahorro de Tiempo</h4>
                        <p class="text-muted">
                            Automatiza procesos manuales y reduce el tiempo de gestión 
                            de comités en un 70%. Enfoque en lo que realmente importa.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-shield-alt" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Transparencia Total</h4>
                        <p class="text-muted">
                            Registro completo y trazable de todas las decisiones. 
                            Cumplimiento normativo y auditoría simplificada.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-4">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-chart-line" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Análisis Inteligente</h4>
                        <p class="text-muted">
                            Dashboard con estadísticas en tiempo real. 
                            Identifica tendencias y mejora la toma de decisiones.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="cta-title">Proceso de Implementación</h2>
                    <p class="cta-description">
                        Integración rápida y sencilla en tu institución educativa
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="text-center text-white">
                        <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">1</span>
                        </div>
                        <h5 class="fw-bold mb-2">Configuración</h5>
                        <p class="opacity-75">Instalación y configuración inicial del sistema</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center text-white">
                        <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">2</span>
                        </div>
                        <h5 class="fw-bold mb-2">Capacitación</h5>
                        <p class="opacity-75">Entrenamiento del personal en el uso del sistema</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center text-white">
                        <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">3</span>
                        </div>
                        <h5 class="fw-bold mb-2">Migración</h5>
                        <p class="opacity-75">Transferencia de datos históricos al sistema</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center text-white">
                        <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">4</span>
                        </div>
                        <h5 class="fw-bold mb-2">Operación</h5>
                        <p class="opacity-75">Inicio de operaciones con soporte continuo</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary-hero btn-lg">
                        <i class="fas fa-arrow-right me-2"></i>Acceder al Sistema
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary-hero btn-lg">
                        <i class="fas fa-arrow-right me-2"></i>Comenzar Ahora
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">
                        <i class="fas fa-gavel me-2"></i>
                        <strong>ComiSoft</strong> - Sistema de Gestión de Comités
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        © {{ date('Y') }} ComiSoft. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255,255,255,0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.background = 'rgba(255,255,255,0.95)';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>
