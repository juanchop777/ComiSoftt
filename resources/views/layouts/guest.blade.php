<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ComiSoft - Sistema de Gestión de Comités</title>

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">

        <style>
            :root {
                --primary-blue: #1e40af;
                --secondary-blue: #3b82f6;
                --accent-blue: #60a5fa;
                --light-blue: #dbeafe;
                --dark-blue: #1e3a8a;
                --text-primary: #1e3a8a;
                --text-secondary: #475569;
                --success-color: #10b981;
                --warning-color: #f59e0b;
                --danger-color: #ef4444;
                --info-color: #06b6d4;
                --bg-primary: #ffffff;
                --bg-secondary: #f8fafc;
                --border-color: #e2e8f0;
            }

            body {
                font-family: 'Inter', sans-serif !important;
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 50%, var(--accent-blue) 100%);
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }

            /* Bolitas decorativas del fondo */
            .floating-shapes {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
                z-index: 0;
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

            .shape:nth-child(4) {
                width: 120px;
                height: 120px;
                top: 25%;
                right: 20%;
                animation-delay: 2s;
            }

            .shape:nth-child(5) {
                width: 90px;
                height: 90px;
                bottom: 30%;
                right: 10%;
                animation-delay: 4s;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.1; }
                50% { transform: translateY(-30px) rotate(180deg); opacity: 0.15; }
            }

            .auth-container {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(30, 64, 175, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                z-index: 1;
            }

            .form-control {
                border: 2px solid var(--border-color) !important;
                border-radius: 12px !important;
                padding: 0.8rem 1rem !important;
                transition: all 0.3s ease !important;
                font-size: 0.95rem !important;
            }

            .form-control:focus {
                border-color: var(--primary-blue) !important;
                box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.15) !important;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
                border: none !important;
                border-radius: 12px !important;
                padding: 0.8rem 1.5rem !important;
                font-weight: 600 !important;
                box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3) !important;
                transition: all 0.3s ease !important;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--secondary-blue), var(--accent-blue)) !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4) !important;
            }

            .form-label {
                font-weight: 600 !important;
                color: var(--text-primary) !important;
                margin-bottom: 0.5rem !important;
            }

            .brand-logo {
                background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                font-weight: 800;
                font-size: 2rem;
            }

            .text-muted {
                color: var(--text-secondary) !important;
            }

            .link-primary {
                color: var(--primary-blue) !important;
                text-decoration: none !important;
                font-weight: 500 !important;
            }

            .link-primary:hover {
                color: var(--secondary-blue) !important;
                text-decoration: underline !important;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <!-- Bolitas decorativas del fondo -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            {{ $slot }}
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
        <!-- AdminLTE JS -->
        <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>

        @livewireScripts
    </body>
</html>
