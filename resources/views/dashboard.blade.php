@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-2">Panel de control del Sistema de Comités</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500" id="current-date"></div>
                <div class="text-xs text-gray-400" id="current-time"></div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total de Actas -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Actas</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_minutes'] }}</p>
                    <p class="text-sm text-green-600 flex items-center mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ $monthlyStats['minutes_this_month'] }} este mes
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Comités Individuales -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Comités Individuales</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['individual_committees'] }}</p>
                    <p class="text-sm text-green-600 flex items-center mt-1">
                        <i class="fas fa-user mr-1"></i>
                        {{ $monthlyStats['individual_this_month'] }} este mes
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Comités Generales -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Comités Generales</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['general_committees'] }}</p>
                    <p class="text-sm text-blue-600 flex items-center mt-1">
                        <i class="fas fa-users mr-1"></i>
                        {{ $monthlyStats['general_this_month'] }} este mes
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users-cog text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Aprendices con Contrato -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Con Contrato</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['apprentices_with_contract'] }}</p>
                    <p class="text-sm text-gray-500 flex items-center mt-1">
                        <i class="fas fa-building mr-1"></i>
                        {{ round(($stats['apprentices_with_contract'] / max($stats['total_minutes'], 1)) * 100, 1) }}% del total
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-handshake text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico de Tendencia -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Tendencia de Actividad</h3>
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Últimos 6 meses</option>
                        <option>Último mes</option>
                        <option>Últimos 3 meses</option>
                        <option>Último año</option>
                    </select>
                </div>
            </div>
            <div class="h-80">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Gráfico de Tipos de Incidente -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Tipos de Incidente</h3>
            <div class="h-64 mb-6">
                <canvas id="incidentChart"></canvas>
            </div>
            <div class="space-y-3">
                @foreach($incidentTypes as $type)
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $loop->index == 0 ? '#1e40af' : ($loop->index == 1 ? '#10b981' : '#06b6d4') }};"></div>
                        <span class="text-sm text-gray-600">{{ $type->incident_type }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <a href="{{ route('minutes.create') }}" class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 border border-blue-200 hover:border-blue-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus-circle text-white text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Nueva Acta</h4>
                    <p class="text-sm text-gray-600 mt-1">Crear nueva acta</p>
                </div>
            </a>

            <a href="{{ route('committee.individual.create') }}" class="group bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 hover:from-green-100 hover:to-green-200 transition-all duration-300 border border-green-200 hover:border-green-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Comité Individual</h4>
                    <p class="text-sm text-gray-600 mt-1">Crear comité individual</p>
                </div>
            </a>

            <a href="{{ route('committee.general.create') }}" class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 hover:from-purple-100 hover:to-purple-200 transition-all duration-300 border border-purple-200 hover:border-purple-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users-cog text-white text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Comité General</h4>
                    <p class="text-sm text-gray-600 mt-1">Crear comité general</p>
                </div>
            </a>

            <a href="{{ route('minutes.index') }}" class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 border border-blue-200 hover:border-blue-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-list text-white text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Ver Actas</h4>
                    <p class="text-sm text-gray-600 mt-1">Consultar actas</p>
                </div>
            </a>

            <a href="{{ route('committee.individual.index') }}" class="group bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 border border-yellow-200 hover:border-yellow-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-yellow-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Reportes</h4>
                    <p class="text-sm text-gray-600 mt-1">Ver reportes</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="bg-white rounded-xl shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Actividad Reciente</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('committee.individual.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">Comités Individuales</a>
                    <a href="{{ route('committee.general.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">Comités Generales</a>
                </div>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @if(isset($recentActivity) && $recentActivity->count() > 0)
                @foreach($recentActivity as $activity)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 {{ $activity['type'] == 'individual' ? 'bg-green-100' : 'bg-purple-100' }} rounded-lg flex items-center justify-center">
                            <i class="fas {{ $activity['type'] == 'individual' ? 'fa-user text-green-600' : 'fa-users-cog text-purple-600' }}"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-gray-900">{{ $activity['type'] == 'individual' ? 'Comité Individual' : 'Comité General' }}</h4>
                                <span class="text-xs text-gray-500">{{ $activity['time_ago'] }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500">Acta #{{ $activity['act_number'] }}</p>
                        </div>
                        <span class="px-3 py-1 {{ $activity['type'] == 'individual' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }} text-xs font-medium rounded-full">
                            {{ $activity['type'] == 'individual' ? 'Individual' : 'General' }}
                        </span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="p-6 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-4"></i>
                    <p>No hay actividad reciente</p>
                </div>
            @endif
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