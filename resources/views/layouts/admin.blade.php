{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ComiSoft - Panel de Administración</title>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

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

        /* Fuente personalizada */
        body {
            font-family: 'Inter', sans-serif !important;
        }

        /* Navbar minimalista */
        .main-header.navbar {
            background: white !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05) !important;
            position: relative;
            z-index: 3;
        }

        .main-header .navbar-nav .nav-link {
            color: var(--text-primary) !important;
            transition: all 0.2s ease;
            border-radius: 6px;
            padding: 0.5rem 0.75rem !important;
        }

        .main-header .navbar-nav .nav-link:hover {
            color: var(--primary-blue) !important;
            background: rgba(30, 64, 175, 0.05) !important;
        }

        .main-header .navbar-nav .nav-link i {
            color: var(--text-primary) !important;
        }

        .main-header .navbar-nav .nav-link:hover i {
            color: var(--primary-blue) !important;
        }

        /* Sidebar minimalista */
        .main-sidebar {
            background: white !important;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.05) !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            position: relative;
            z-index: 2;
        }

        .sidebar {
            background: transparent !important;
        }

        /* Logo del sidebar */
        .brand-link {
            background: transparent !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            padding: 1.5rem 1rem !important;
            margin-bottom: 0;
        }

        .brand-text {
            color: var(--primary-blue) !important;
            font-weight: 700 !important;
            font-size: 1.4rem !important;
        }

        /* Navegación del sidebar */
        .nav-sidebar .nav-item .nav-link {
            color: var(--text-secondary) !important;
            border-radius: 8px !important;
            margin: 0.25rem 0.75rem !important;
            padding: 0.75rem 1rem !important;
            transition: all 0.2s ease !important;
            font-weight: 500 !important;
        }

        .nav-sidebar .nav-item .nav-link:hover {
            background: rgba(30, 64, 175, 0.05) !important;
            color: var(--primary-blue) !important;
        }

        .nav-sidebar .nav-item .nav-link.active {
            background: var(--primary-blue) !important;
            color: white !important;
        }

        /* Iconos del sidebar */
        .nav-sidebar .nav-item .nav-link i {
            margin-right: 0.8rem !important;
            width: 20px !important;
            text-align: center !important;
        }

        /* Submenu del sidebar */
        .nav-treeview .nav-item .nav-link {
            color: var(--text-secondary) !important;
            padding-left: 2.5rem !important;
            font-size: 0.9rem !important;
            margin: 0.1rem 0.75rem !important;
            border-radius: 6px !important;
        }

        .nav-treeview .nav-item .nav-link:hover {
            background: rgba(30, 64, 175, 0.05) !important;
            color: var(--primary-blue) !important;
        }

        .nav-treeview .nav-item .nav-link.active {
            background: var(--primary-blue) !important;
            color: white !important;
        }

        /* Indicador de submenu */
        .nav-item.has-treeview > .nav-link .right {
            color: var(--text-secondary) !important;
        }

        /* Separadores del sidebar */
        .nav-header {
            color: var(--text-secondary) !important;
            font-weight: 600 !important;
            margin-top: 1rem !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.8rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        /* Content wrapper */
        .content-wrapper {
            background: var(--bg-secondary) !important;
            min-height: calc(100vh - 57px) !important;
            position: relative;
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
            background: rgba(30, 64, 175, 0.05);
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
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.05; }
            50% { transform: translateY(-30px) rotate(180deg); opacity: 0.08; }
        }

        /* Cards minimalistas */
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04) !important;
            transition: all 0.3s ease !important;
            background: white !important;
            position: relative;
            z-index: 1;
        }

        .card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            padding: 1.5rem 1.5rem 0 1.5rem !important;
        }

        .card-title {
            font-weight: 600 !important;
            margin-bottom: 0 !important;
            color: var(--text-primary) !important;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        /* Botones minimalistas */
        .btn-primary {
            background: var(--primary-blue) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 0.5rem 1.25rem !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
        }

        .btn-primary:hover {
            background: var(--secondary-blue) !important;
            transform: translateY(-1px) !important;
        }

        .btn-outline-primary {
            border: 1px solid var(--primary-blue) !important;
            color: var(--primary-blue) !important;
            border-radius: 8px !important;
            padding: 0.5rem 1.25rem !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
        }

        .btn-outline-primary:hover {
            background: var(--primary-blue) !important;
            color: white !important;
        }

        .btn-success {
            background: var(--success-color) !important;
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
        }

        .btn-warning {
            background: var(--warning-color) !important;
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3) !important;
        }

        .btn-danger {
            background: var(--danger-color) !important;
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        }

        .btn-info {
            background: var(--info-color) !important;
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3) !important;
        }

        /* Tabla mejorada */
        .table {
            border-radius: 12px !important;
            overflow: hidden !important;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
            color: white !important;
            border: none !important;
            font-weight: 600 !important;
            padding: 1rem !important;
        }

        .table tbody tr {
            transition: all 0.3s ease !important;
        }

        .table tbody tr:hover {
            background: var(--light-blue) !important;
            transform: scale(1.01) !important;
        }

        .table tbody td {
            padding: 1rem !important;
            border-color: var(--border-color) !important;
            vertical-align: middle !important;
        }

        /* Badges mejorados */
        .badge {
            border-radius: 8px !important;
            padding: 0.5rem 0.8rem !important;
            font-weight: 500 !important;
        }

        .bg-success {
            background: var(--success-color) !important;
        }

        .bg-warning {
            background: var(--warning-color) !important;
        }

        .bg-danger {
            background: var(--danger-color) !important;
        }

        .bg-info {
            background: var(--info-color) !important;
        }

        /* Alertas mejoradas */
        .alert {
            border: none !important;
            border-radius: 12px !important;
            padding: 1rem 1.5rem !important;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1) !important;
            color: var(--success-color) !important;
            border-left: 4px solid var(--success-color) !important;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1) !important;
            color: var(--danger-color) !important;
            border-left: 4px solid var(--danger-color) !important;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1) !important;
            color: var(--warning-color) !important;
            border-left: 4px solid var(--warning-color) !important;
        }

        .alert-info {
            background: rgba(6, 182, 212, 0.1) !important;
            color: var(--info-color) !important;
            border-left: 4px solid var(--info-color) !important;
        }

        /* Formularios mejorados */
        .form-control {
            border: 2px solid var(--border-color) !important;
            border-radius: 10px !important;
            padding: 0.8rem 1rem !important;
            transition: all 0.3s ease !important;
        }

        .form-control:focus {
            border-color: var(--primary-blue) !important;
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.15) !important;
        }

        .form-label {
            font-weight: 600 !important;
            color: var(--text-primary) !important;
            margin-bottom: 0.5rem !important;
        }

        /* Dropdown del usuario */
        .dropdown-menu {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
            padding: 0.5rem !important;
        }

        .dropdown-item {
            border-radius: 8px !important;
            padding: 0.6rem 1rem !important;
            transition: all 0.3s ease !important;
            font-weight: 500 !important;
        }

        .dropdown-item:hover {
            background: var(--light-blue) !important;
            color: var(--primary-blue) !important;
        }

        /* Para que el botón de cerrar sesión parezca enlace */
        #logout-form button {
            background: none !important;
            border: none !important;
            padding: 0.6rem 1rem !important;
            margin: 0 !important;
            color: inherit !important;
            text-align: left !important;
            width: 100% !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            font-weight: 500 !important;
        }

        #logout-form button:hover {
            background: rgba(239, 68, 68, 0.1) !important;
            color: var(--danger-color) !important;
        }

        /* Animaciones */
        .nav-sidebar .nav-item {
            animation: slideInLeft 0.3s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-sidebar {
                box-shadow: none !important;
            }
            
            .card {
                margin: 0.5rem !important;
            }
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-blue);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-blue);
        }

        /* Mejoras adicionales */
        .content-header {
            padding: 1.5rem 1rem !important;
        }

        .content-header h1 {
            color: var(--text-primary) !important;
            font-weight: 700 !important;
        }

        /* Breadcrumb mejorado */
        .breadcrumb {
            background: transparent !important;
            padding: 0 !important;
        }

        .breadcrumb-item a {
            color: var(--primary-blue) !important;
            text-decoration: none !important;
        }

        .breadcrumb-item.active {
            color: var(--text-secondary) !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Bolitas decorativas del fondo -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: var(--text-primary) !important;">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link" style="color: var(--text-primary) !important; font-weight: 600;">
                    <i class="fas fa-gavel me-2 text-primary"></i>Panel de Administración ComiSoft
                </span>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" style="color: var(--text-primary) !important;">
                    <i class="fas fa-user-circle me-2 text-primary"></i>
                    <span class="d-none d-md-inline">Usuario</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user me-2 text-primary"></i> Mi Perfil
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog me-2 text-secondary"></i> Configuración
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        {{-- Botón de Cerrar Sesión --}}
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2 text-danger"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i class="fas fa-gavel brand-image" style="font-size: 1.5rem; margin-right: 0.5rem;"></i>
            <span class="brand-text">ComiSoft</span>
        </a>

        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Separador -->
                    <li class="nav-header">GESTIÓN</li>

                    <!-- Acta -->
                    <li class="nav-item has-treeview {{ request()->routeIs('minutes.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('minutes.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <p>
                                Gestión de Actas
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('minutes.create') }}" class="nav-link {{ request()->routeIs('minutes.create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle"></i>
                                    <p>Nueva Acta</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('minutes.index') }}" class="nav-link {{ request()->routeIs('minutes.index') ? 'active' : '' }}">
                                    <i class="fas fa-list"></i>
                                    <p>Actas Registradas</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Comité -->
                    <li class="nav-item has-treeview {{ request()->routeIs('committee.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('committee.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <p>
                                Gestión de Comités
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('committee.create') }}" class="nav-link {{ request()->routeIs('committee.create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle"></i>
                                    <p>Nuevo Comité</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('committee.index') }}" class="nav-link {{ request()->routeIs('committee.index') ? 'active' : '' }}">
                                    <i class="fas fa-list"></i>
                                    <p>Comités Realizados</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Separador -->
                    <li class="nav-header">REPORTES</li>

                    <!-- Estadísticas -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <p>Estadísticas</p>
                        </a>
                    </li>

                    <!-- Reportes -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-file-pdf"></i>
                            <p>Generar Reportes</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 (AdminLTE usa esta versión) -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.js') }}"></script>

    <!-- Script personalizado para mejorar la experiencia -->
    <script>
        $(document).ready(function() {
            // Animación suave para los elementos del sidebar
            $('.nav-sidebar .nav-item').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
            });

            // Efecto hover mejorado para las tarjetas
            $('.card').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );

            // Confirmación para el botón de cerrar sesión
            $('#logout-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Cerrar Sesión?',
                    text: '¿Estás seguro de que deseas cerrar tu sesión?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1e40af',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Sí, cerrar sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
