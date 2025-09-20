<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ComiSoft - Sistema de Gestión de Comités</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #60a5fa;
            --light-blue: #dbeafe;
            --dark-blue: #1e3a8a;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --text-primary: #1e3a8a;
            --text-secondary: #475569;
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: var(--bg-primary);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 50%, var(--accent-color) 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.8" fill="white" opacity="0.08"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0,0,0,0.15);
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            max-width: 600px;
        }

        .btn-hero {
            padding: 14px 36px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-primary-hero {
            background: white;
            color: var(--primary-color);
            border-color: white;
        }

        .btn-primary-hero:hover {
            background: var(--light-blue);
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
        }

        .btn-outline-hero {
            background: transparent;
            color: white;
            border-color: white;
        }

        .btn-outline-hero:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
        }

        .features-section {
            padding: 100px 0;
            background: var(--bg-secondary);
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.08);
            transition: all 0.4s ease;
            border: 1px solid var(--border-color);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(30, 64, 175, 0.15);
        }

        .feature-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 2.2rem;
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.3);
        }

        .feature-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .feature-description {
            color: var(--text-secondary);
            line-height: 1.7;
            font-size: 1rem;
        }

        .stats-section {
            background: white;
            padding: 80px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .cta-section {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-color) 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .cta-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-description {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
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
            animation: float 8s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 15%;
            left: 8%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 55%;
            right: 8%;
            animation-delay: 3s;
        }

        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 15%;
            left: 15%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.1; }
            50% { transform: translateY(-30px) rotate(180deg); opacity: 0.15; }
        }

        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(30, 64, 175, 0.08);
            box-shadow: 0 4px 30px rgba(30, 64, 175, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255,255,255,0.98);
            box-shadow: 0 8px 40px rgba(30, 64, 175, 0.15);
            padding: 0.5rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand i {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-primary) !important;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.8rem 1.2rem !important;
            border-radius: 8px;
            margin: 0 0.2rem;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(30, 64, 175, 0.05);
            transform: translateY(-1px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .btn-nav {
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-nav:hover::before {
            left: 100%;
        }

        .btn-nav-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.3);
        }

        .btn-nav-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.4);
        }

        .btn-nav-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            position: relative;
        }

        .btn-nav-outline:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2830, 64, 175, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .hero-visual {
            position: relative;
            z-index: 2;
        }

        .visual-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }

        .visual-icon {
            font-size: 6rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        /* Carrusel personalizado */
        #heroCarousel {
            border-radius: 20px;
            overflow: hidden;
        }

        .carousel-indicators {
            bottom: -50px;
            margin-bottom: 0;
        }

        .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .carousel-indicators .active {
            background-color: white;
            border-color: white;
            transform: scale(1.2);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: 20px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 20px;
            height: 20px;
        }

        .carousel-item {
            transition: all 0.6s ease-in-out;
        }

        .carousel-item .visual-card {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Pausar carrusel en hover */
        #heroCarousel:hover {
            animation-play-state: paused;
        }


        .about-section {
            padding: 100px 0;
            background: white;
        }

        .about-card {
            background: var(--light-blue);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            border: 1px solid rgba(30, 64, 175, 0.1);
        }

        .about-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 2rem;
        }

        .check-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
        }

        .check-icon {
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .cta-title {
                font-size: 2.2rem;
            }

            .feature-card {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-gavel"></i>
                <span>ComiSoft</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">
                            <i class="fas fa-star me-1"></i>Características
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">
                            <i class="fas fa-info-circle me-1"></i>Acerca de
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#stats">
                            <i class="fas fa-chart-bar me-1"></i>Estadísticas
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-nav btn-nav-primary" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="btn btn-nav btn-nav-outline" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Iniciar Sesión</span>
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="btn btn-nav btn-nav-primary" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Registrarse</span>
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
                        Gestión Inteligente de <span style="color: #60a5fa;">Comités</span>
                    </h1>
                    <p class="hero-subtitle">
                        Sistema integral para la administración eficiente de comités académicos y disciplinarios. 
                        Simplifica procesos, mejora la transparencia y optimiza la toma de decisiones institucionales.
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
                <div class="col-lg-6 hero-visual">
                    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="visual-card">
                                    <i class="fas fa-gavel visual-icon"></i>
                                    <h4 class="mb-3">Sistema Profesional</h4>
                                    <p class="mb-0">Gestión completa de comités académicos y disciplinarios</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="visual-card">
                                    <i class="fas fa-file-alt visual-icon"></i>
                                    <h4 class="mb-3">Gestión de Actas</h4>
                                    <p class="mb-0">Registro y seguimiento completo de todas las actas de comité</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="visual-card">
                                    <i class="fas fa-users visual-icon"></i>
                                    <h4 class="mb-3">Control de Comités</h4>
                                    <p class="mb-0">Administración eficiente de sesiones y decisiones</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="visual-card">
                                    <i class="fas fa-chart-bar visual-icon"></i>
                                    <h4 class="mb-3">Reportes Avanzados</h4>
                                    <p class="mb-0">Estadísticas detalladas y análisis de tendencias</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-title">¿Qué es ComiSoft?</h2>
                    <p class="section-subtitle">
                        Una plataforma integral diseñada específicamente para la gestión eficiente de comités académicos y disciplinarios en instituciones educativas
                    </p>
                </div>
            </div>
            
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="pe-lg-5">
                        <h3 class="h2 fw-bold mb-4" style="color: var(--primary-color);">Sistema de Comités Académicos</h3>
                        <p class="lead mb-4 text-secondary">
                            ComiSoft facilita la gestión completa de comités que evalúan casos académicos, 
                            disciplinarios y de comportamiento estudiantil en instituciones educativas.
                        </p>
                        <div class="check-item">
                            <div class="check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Registro y seguimiento de actas de comité</span>
                        </div>
                        <div class="check-item">
                            <div class="check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Gestión de sesiones y decisiones</span>
                        </div>
                        <div class="check-item">
                            <div class="check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Clasificación de faltas y sanciones</span>
                        </div>
                        <div class="check-item">
                            <div class="check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Reportes y estadísticas detalladas</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-card">
                        <i class="fas fa-graduation-cap about-icon"></i>
                        <h4 class="fw-bold mb-3" style="color: var(--primary-color);">Comités Académicos</h4>
                        <p class="text-secondary">
                            Evaluación de casos académicos y disciplinarios con herramientas profesionales 
                            que garantizan transparencia y eficiencia en cada proceso.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-title">Características Principales</h2>
                    <p class="section-subtitle">
                        Herramientas potentes y fáciles de usar para optimizar la gestión de comités
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h4 class="feature-title">Gestión de Actas</h4>
                        <p class="feature-description">
                            Registro completo y organizado de todas las actas de comité con búsqueda avanzada y categorización automática.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="feature-title">Control de Comités</h4>
                        <p class="feature-description">
                            Administración eficiente de sesiones, miembros y decisiones con seguimiento en tiempo real del progreso.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4 class="feature-title">Reportes Avanzados</h4>
                        <p class="feature-description">
                            Estadísticas detalladas y reportes personalizables para análisis de tendencias y toma de decisiones.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="feature-title">Seguridad</h4>
                        <p class="feature-description">
                            Protección de datos sensibles con encriptación avanzada y control de acceso por roles de usuario.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4 class="feature-title">Eficiencia</h4>
                        <p class="feature-description">
                            Automatización de procesos repetitivos y notificaciones inteligentes para optimizar el tiempo de trabajo.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 class="feature-title">Acceso Móvil</h4>
                        <p class="feature-description">
                            Interfaz responsive que permite acceso completo desde cualquier dispositivo móvil o tablet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Actas Procesadas</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Comités Activos</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Tiempo de Actividad</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Soporte Disponible</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="cta-title">¿Listo para Optimizar tu Gestión?</h2>
                    <p class="cta-description">
                        Únete a las instituciones que ya confían en ComiSoft para gestionar sus comités de manera eficiente y profesional.
                    </p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary-hero btn-lg">
                            <i class="fas fa-arrow-right me-2"></i>Acceder al Sistema
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary-hero btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Registrarse Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4" style="background: var(--bg-secondary); border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-secondary">© {{ date('Y') }} ComiSoft. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-decoration-none me-3" style="color: var(--primary-color);">Términos de Uso</a>
                    <a href="#" class="text-decoration-none" style="color: var(--primary-color);">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scrolling -->
    <script>
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
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth reveal animation for navbar
        window.addEventListener('load', function() {
            const navbar = document.querySelector('.navbar');
            navbar.style.opacity = '0';
            navbar.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                navbar.style.transition = 'all 0.6s ease';
                navbar.style.opacity = '1';
                navbar.style.transform = 'translateY(0)';
            }, 100);
        });

        // Carrusel personalizado
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('#heroCarousel');
            const carouselItems = document.querySelectorAll('.carousel-item');
            
            // Pausar carrusel en hover
            carousel.addEventListener('mouseenter', function() {
                const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                if (bsCarousel) {
                    bsCarousel.pause();
                }
            });
            
            carousel.addEventListener('mouseleave', function() {
                const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                if (bsCarousel) {
                    bsCarousel.cycle();
                }
            });
            
            // Animación personalizada para cada slide
            carousel.addEventListener('slide.bs.carousel', function(e) {
                const activeItem = e.relatedTarget;
                const visualCard = activeItem.querySelector('.visual-card');
                
                // Resetear animación
                visualCard.style.animation = 'none';
                visualCard.offsetHeight; // Trigger reflow
                visualCard.style.animation = 'fadeInUp 0.8s ease-out';
            });
        });
    </script>
</body>
</html>