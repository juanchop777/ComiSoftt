@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header del Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-tachometer-alt text-primary me-2"></i>
                        Bienvenido, Administrador
                    </h1>
                    <p class="text-muted mb-0">Panel de control del Sistema de Comités</p>
                </div>
                <div class="text-end">
                    <p class="text-muted mb-0" id="current-date"></p>
                    <small class="text-muted" id="current-time"></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de Actas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_minutes'] }}</div>
                            <div class="text-xs text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $monthlyStats['minutes_this_month'] }} este mes
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total de Comités
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_committees'] }}</div>
                            <div class="text-xs text-muted">
                                <i class="fas fa-users me-1"></i>
                                {{ $monthlyStats['committees_this_month'] }} este mes
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-gavel fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Personas Reportantes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_reporting_persons'] }}</div>
                            <div class="text-xs text-muted">
                                <i class="fas fa-user-tie me-1"></i>
                                Registradas en el sistema
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Usuarios del Sistema
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                            <div class="text-xs text-muted">
                                <i class="fas fa-user-shield me-1"></i>
                                Acceso autorizado
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Estadísticas -->
    <div class="row mb-4">
        <!-- Gráfico de Tendencia -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tendencia de Actividad (Últimos 6 Meses)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="trendChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Tipos de Incidente -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tipos de Incidente</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="incidentChart" width="300" height="300"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($incidentTypes as $type)
                            <span class="mr-2">
                                <i class="fas fa-circle text-{{ $loop->index == 0 ? 'primary' : ($loop->index == 1 ? 'success' : 'info') }}"></i>
                                {{ $type->incident_type }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Detalladas -->
    <div class="row mb-4">
        <!-- Clases de Falta -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Clases de Falta</h6>
                </div>
                <div class="card-body">
                    @foreach($offenseClasses as $offense)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge bg-{{ $offense->offense_class == 'Leve' ? 'success' : ($offense->offense_class == 'Grave' ? 'warning' : 'danger') }} me-2">
                                    {{ $offense->offense_class }}
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="h6 mb-0">{{ $offense->count }}</span>
                                <small class="text-muted">casos</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Modalidades de Asistencia -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Modalidades de Asistencia</h6>
                </div>
                <div class="card-body">
                    @foreach($attendanceModes as $mode)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <i class="fas fa-{{ $mode->attendance_mode == 'Presencial' ? 'user' : ($mode->attendance_mode == 'Virtual' ? 'video' : 'times') }} me-2 text-{{ $mode->attendance_mode == 'Presencial' ? 'success' : ($mode->attendance_mode == 'Virtual' ? 'info' : 'danger') }}"></i>
                                {{ $mode->attendance_mode }}
                            </div>
                            <div class="text-end">
                                <span class="h6 mb-0">{{ $mode->count }}</span>
                                <small class="text-muted">sesiones</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Actas y Comités Recientes -->
    <div class="row">
        <!-- Actas Recientes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actas Recientes</h6>
                </div>
                <div class="card-body">
                    @if($recentMinutes->count() > 0)
                        @foreach($recentMinutes as $minute)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <div class="fw-bold">Acta #{{ $minute->act_number }}</div>
                                    <div class="text-muted small">{{ $minute->trainee_name }}</div>
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($minute->minutes_date)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $minute->incident_type == 'Academic' ? 'primary' : ($minute->incident_type == 'Disciplinary' ? 'warning' : 'info') }}">
                                        {{ $minute->incident_type }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">No hay actas recientes</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Comités Recientes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Comités Recientes</h6>
                </div>
                <div class="card-body">
                    @if($recentCommittees->count() > 0)
                        @foreach($recentCommittees as $committee)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <div class="fw-bold">{{ $committee->trainee_name }}</div>
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($committee->session_date)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $committee->session_time }}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $committee->offense_class == 'Leve' ? 'success' : ($committee->offense_class == 'Grave' ? 'warning' : 'danger') }}">
                                        {{ $committee->offense_class }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">No hay comités recientes</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para el gráfico de tendencias
    const trendData = @json($trends);
    const months = trendData.map(item => item.month);
    const minutesData = trendData.map(item => item.minutes);
    const committeesData = trendData.map(item => item.committees);

    // Gráfico de tendencias
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Actas',
                data: minutesData,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1
            }, {
                label: 'Comités',
                data: committeesData,
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.1
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
                    beginAtZero: true
                }
            }
        }
    });

    // Datos para el gráfico de tipos de incidente
    const incidentData = @json($incidentTypes);
    const incidentLabels = incidentData.map(item => item.incident_type);
    const incidentCounts = incidentData.map(item => item.count);
    const incidentColors = ['#3B82F6', '#10B981', '#06B6D4'];

    // Gráfico de tipos de incidente
    const incidentCtx = document.getElementById('incidentChart').getContext('2d');
    new Chart(incidentCtx, {
        type: 'doughnut',
        data: {
            labels: incidentLabels,
            datasets: [{
                data: incidentCounts,
                backgroundColor: incidentColors,
                borderWidth: 2,
                borderColor: '#fff'
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

    // Función para actualizar fecha y hora en español
    function updateDateTime() {
        const now = new Date();
        
        // Configurar zona horaria de Colombia (UTC-5)
        const colombiaTime = new Date(now.getTime() - (5 * 60 * 60 * 1000));
        
        // Días de la semana en español
        const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        
        // Meses en español
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                      'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        // Formatear fecha
        const dia = diasSemana[colombiaTime.getUTCDay()];
        const fecha = colombiaTime.getUTCDate();
        const mes = meses[colombiaTime.getUTCMonth()];
        const año = colombiaTime.getUTCFullYear();
        
        // Formatear hora
        const horas = String(colombiaTime.getUTCHours()).padStart(2, '0');
        const minutos = String(colombiaTime.getUTCMinutes()).padStart(2, '0');
        const segundos = String(colombiaTime.getUTCSeconds()).padStart(2, '0');
        
        // Actualizar elementos en el DOM
        document.getElementById('current-date').textContent = `${dia}, ${fecha} de ${mes} de ${año}`;
        document.getElementById('current-time').textContent = `${horas}:${minutos}:${segundos} (CO)`;
    }
    
    // Actualizar cada segundo
    updateDateTime();
    setInterval(updateDateTime, 1000);
});
</script>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.text-xs {
    font-size: 0.7rem;
}

.chart-area {
    position: relative;
    height: 20rem;
    width: 100%;
}

.chart-pie {
    position: relative;
    height: 15rem;
    width: 100%;
}

.card {
    border: none;
    border-radius: 0.35rem;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.font-weight-bold {
    font-weight: 700 !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.h-100 {
    height: 100% !important;
}

.py-2 {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}

.no-gutters {
    margin-right: 0;
    margin-left: 0;
}

.no-gutters > .col,
.no-gutters > [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
}

.align-items-center {
    align-items: center !important;
}

.mr-2 {
    margin-right: 0.5rem !important;
}

.col-auto {
    flex: 0 0 auto;
    width: auto;
    max-width: 100%;
}

.fa-2x {
    font-size: 2em;
}
</style>
@endsection
