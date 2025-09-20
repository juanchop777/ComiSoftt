@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header Minimalista -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-1 fw-bold text-dark">Dashboard</h1>
                    <p class="text-muted mb-0">Panel de control del Sistema de Comités</p>
                </div>
                <div class="text-end">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="text-sm text-muted" id="current-date"></div>
                            <div class="text-xs text-muted" id="current-time"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales - Diseño Minimalista -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-sm text-muted mb-1">Total de Actas</div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ $stats['total_minutes'] }}</div>
                            <div class="text-xs text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $monthlyStats['minutes_this_month'] }} este mes
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-file-alt text-primary fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-sm text-muted mb-1">Total de Comités</div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ $stats['total_committees'] }}</div>
                            <div class="text-xs text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $monthlyStats['committees_this_month'] }} este mes
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-gavel text-success fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-sm text-muted mb-1">Personas Reportantes</div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ $stats['total_reporting_persons'] }}</div>
                            <div class="text-xs text-muted">
                                <i class="fas fa-users me-1"></i>
                                Registradas
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-friends text-info fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-sm text-muted mb-1">Usuarios del Sistema</div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ $stats['total_users'] }}</div>
                            <div class="text-xs text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Acceso autorizado
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-users-cog text-warning fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="row g-4">
        <!-- Gráfico de Tendencia -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Tendencia de Actividad</h5>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Últimos 6 meses
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Último mes</a></li>
                                <li><a class="dropdown-item" href="#">Últimos 3 meses</a></li>
                                <li><a class="dropdown-item" href="#">Último año</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-area" style="height: 300px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Tipos de Incidente -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <h5 class="mb-0 fw-bold text-dark">Tipos de Incidente</h5>
                </div>
                <div class="card-body p-4">
                    <div class="chart-pie" style="height: 250px;">
                        <canvas id="incidentChart"></canvas>
                    </div>
                    <div class="mt-4">
                        @foreach($incidentTypes as $type)
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle me-2" style="width: 12px; height: 12px; background-color: {{ $loop->index == 0 ? '#1e40af' : ($loop->index == 1 ? '#10b981' : '#06b6d4') }};"></div>
                                <span class="text-sm text-muted">{{ $type->incident_type }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <h5 class="mb-0 fw-bold text-dark">Acciones Rápidas</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('minutes.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 text-decoration-none">
                                <i class="fas fa-plus-circle fs-1 mb-3 text-primary"></i>
                                <span class="fw-semibold">Nueva Acta</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('committee.create') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 text-decoration-none">
                                <i class="fas fa-gavel fs-1 mb-3 text-success"></i>
                                <span class="fw-semibold">Nuevo Comité</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('minutes.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 text-decoration-none">
                                <i class="fas fa-list fs-1 mb-3 text-info"></i>
                                <span class="fw-semibold">Ver Actas</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('committee.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 text-decoration-none">
                                <i class="fas fa-chart-bar fs-1 mb-3 text-warning"></i>
                                <span class="fw-semibold">Reportes</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Actividad Reciente</h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">Ver todo</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-3 px-4 text-muted fw-semibold">Tipo</th>
                                    <th class="border-0 py-3 px-4 text-muted fw-semibold">Descripción</th>
                                    <th class="border-0 py-3 px-4 text-muted fw-semibold">Fecha</th>
                                    <th class="border-0 py-3 px-4 text-muted fw-semibold">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-alt text-primary fs-5 me-3"></i>
                                            <span class="fw-semibold">Acta</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">Nueva acta de comité académico</div>
                                        <div class="text-xs text-muted">Caso #2024-001</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-muted">Hace 2 horas</td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-success bg-opacity-10 text-success">Completado</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-gavel text-success fs-5 me-3"></i>
                                            <span class="fw-semibold">Comité</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">Sesión de comité disciplinario</div>
                                        <div class="text-xs text-muted">Reunión #2024-015</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-muted">Hace 5 horas</td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-warning bg-opacity-10 text-warning">En proceso</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-friends text-info fs-5 me-3"></i>
                                            <span class="fw-semibold">Usuario</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">Nuevo usuario registrado</div>
                                        <div class="text-xs text-muted">Dr. María González</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-muted">Ayer</td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-info bg-opacity-10 text-info">Activo</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar fecha y hora
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        const timeOptions = { 
            hour: '2-digit', 
            minute: '2-digit' 
        };
        
        document.getElementById('current-date').textContent = now.toLocaleDateString('es-ES', dateOptions);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('es-ES', timeOptions);
    }
    
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Gráfico de tendencia
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Actas',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: '#1e40af',
                backgroundColor: 'rgba(30, 64, 175, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Comités',
                data: [8, 15, 7, 12, 9, 11],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Gráfico de tipos de incidente
    const incidentCtx = document.getElementById('incidentChart').getContext('2d');
    new Chart(incidentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Académico', 'Disciplinario', 'Otros'],
            datasets: [{
                data: [45, 35, 20],
                backgroundColor: ['#1e40af', '#10b981', '#06b6d4'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection