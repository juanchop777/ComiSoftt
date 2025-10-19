<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ComiSoft - Panel de Administración</title>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind CSS Fallback (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-inter">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform transition-transform duration-300 ease-in-out" id="sidebar">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 px-4 bg-blue-600">
            <div class="flex items-center">
                <i class="fas fa-gavel text-white text-2xl mr-3"></i>
                <span class="text-white text-xl font-bold">ComiSoft</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-8 px-4">
            <ul class="space-y-2">
                    <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                        <span class="font-medium">Dashboard</span>
                        </a>
                    </li>

                    <!-- Separador -->
                <li class="pt-4">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4">GESTIÓN</div>
                </li>

                <!-- Gestión de Actas -->
                <li>
                    <div class="flex items-center justify-between px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer" onclick="toggleSubmenu('actas')">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                            <span class="font-medium">Gestión de Actas</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="actas-arrow"></i>
                    </div>
                    <ul class="ml-4 mt-2 space-y-1 hidden" id="actas-submenu">
                        <li>
                            <a href="{{ route('minutes.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('minutes.create') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-plus-circle w-4 h-4 mr-3"></i>
                                <span>Nueva Acta</span>
                                </a>
                            </li>
                        <li>
                            <a href="{{ route('minutes.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('minutes.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-list w-4 h-4 mr-3"></i>
                                <span>Actas Registradas</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                <!-- Gestión de Comités -->
                <li>
                    <div class="flex items-center justify-between px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer" onclick="toggleSubmenu('comites')">
                        <div class="flex items-center">
                            <i class="fas fa-users w-5 h-5 mr-3"></i>
                            <span class="font-medium">Gestión de Comités</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="comites-arrow"></i>
                    </div>
                    <ul class="ml-4 mt-2 space-y-1 hidden" id="comites-submenu">
                        <!-- Comités Individuales -->
                        <li>
                            <div class="flex items-center justify-between px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer" onclick="toggleSubmenu('individuales')">
                                <div class="flex items-center">
                                    <i class="fas fa-user w-4 h-4 mr-3"></i>
                                    <span>Comités Individuales</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="individuales-arrow"></i>
                            </div>
                            <ul class="ml-4 mt-1 space-y-1 hidden" id="individuales-submenu">
                                <li>
                                    <a href="{{ route('committee.individual.create') }}" class="flex items-center px-4 py-2 text-xs text-gray-500 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('committee.individual.create') ? 'bg-blue-50 text-blue-600' : '' }}">
                                        <i class="fas fa-plus-circle w-3 h-3 mr-3"></i>
                                        <span>Nuevo Comité Individual</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('committee.individual.index') }}" class="flex items-center px-4 py-2 text-xs text-gray-500 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('committee.individual.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                                        <i class="fas fa-list w-3 h-3 mr-3"></i>
                                        <span>Lista Comités Individuales</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Comités Generales -->
                        <li>
                            <div class="flex items-center justify-between px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer" onclick="toggleSubmenu('generales')">
                                <div class="flex items-center">
                                    <i class="fas fa-users w-4 h-4 mr-3"></i>
                                    <span>Comités Generales</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="generales-arrow"></i>
                            </div>
                            <ul class="ml-4 mt-1 space-y-1 hidden" id="generales-submenu">
                                <li>
                                    <a href="{{ route('committee.general.create') }}" class="flex items-center px-4 py-2 text-xs text-gray-500 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('committee.general.create') ? 'bg-blue-50 text-blue-600' : '' }}">
                                        <i class="fas fa-plus-circle w-3 h-3 mr-3"></i>
                                        <span>Nuevo Comité General</span>
                                </a>
                            </li>
                                <li>
                                    <a href="{{ route('committee.general.index') }}" class="flex items-center px-4 py-2 text-xs text-gray-500 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('committee.general.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                                        <i class="fas fa-list w-3 h-3 mr-3"></i>
                                        <span>Lista Comités Generales</span>
                                    </a>
                                </li>
                            </ul>
                            </li>
                        </ul>
                    </li>

                <!-- Acta Reporte -->
                <li>
                    <div class="flex items-center justify-between px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer" onclick="toggleSubmenu('acta-reporte')">
                        <div class="flex items-center">
                            <i class="fas fa-file-contract w-5 h-5 mr-3"></i>
                            <span class="font-medium">Acta Reporte</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="acta-reporte-arrow"></i>
                    </div>
                    <ul class="ml-4 mt-2 space-y-1 hidden" id="acta-reporte-submenu">
                        <li>
                            <a href="{{ route('final-minutes.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('final-minutes.create') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-plus-circle w-4 h-4 mr-3"></i>
                                <span>Nueva Acta Reporte</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('final-minutes.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('final-minutes.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-list w-4 h-4 mr-3"></i>
                                <span>Visualizar Registros</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Separador -->
                <li class="pt-4">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4">REPORTES</div>
                </li>

                    <!-- Estadísticas -->
                <li>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                        <span class="font-medium">Estadísticas</span>
                        </a>
                    </li>

                    <!-- Reportes -->
                <li>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <i class="fas fa-file-pdf w-5 h-5 mr-3"></i>
                        <span class="font-medium">Generar Reportes</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
            <div class="flex items-center justify-between h-16 px-6">
                <!-- Mobile menu button -->
                <button class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Page title -->
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Panel de Administración ComiSoft</h1>
                </div>

                <!-- User menu -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-bell text-xl"></i>
                    </button>

                    <!-- User dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 p-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="hidden md:block font-medium">Usuario</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user w-4 h-4 mr-3"></i>
                                Mi Perfil
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog w-4 h-4 mr-3"></i>
                                Configuración
                            </a>
                            <hr class="my-1">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
        @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        // Toggle submenu
        function toggleSubmenu(menuId) {
            const submenu = document.getElementById(menuId + '-submenu');
            const arrow = document.getElementById(menuId + '-arrow');
            
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        // Auto-open submenus based on current route
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're in committee routes
            if (window.location.pathname.includes('/committee/individual')) {
                toggleSubmenu('comites');
                toggleSubmenu('individuales');
            } else if (window.location.pathname.includes('/committee/general')) {
                toggleSubmenu('comites');
                toggleSubmenu('generales');
            } else if (window.location.pathname.includes('/committee')) {
                toggleSubmenu('comites');
            } else if (window.location.pathname.includes('/minutes')) {
                toggleSubmenu('actas');
            } else if (window.location.pathname.includes('/final-minutes')) {
                toggleSubmenu('acta-reporte');
            }
        });

        // Confirm logout
        document.getElementById('logout-form').addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Cerrar Sesión?',
                    text: '¿Estás seguro de que deseas cerrar tu sesión?',
                    icon: 'question',
                    showCancelButton: true,
                confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Sí, cerrar sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const menuButton = document.querySelector('[onclick="toggleSidebar()"]');
            
            if (window.innerWidth < 1024 && 
                !sidebar.contains(e.target) && 
                !menuButton.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>