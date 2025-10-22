@extends('layouts.admin')

@section('title', 'Actas finales')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <!-- Header -->
    <div class="bg-blue-600 text-white p-8 rounded-xl text-center shadow-lg mb-8">
        <i class="fas fa-file-contract text-4xl mb-4 block"></i>
        <h1 class="text-3xl font-bold">Actas Finales</h1>
        <p class="text-blue-100 mt-2">Gestión de actas finales </p>
    </div>
    
    <!-- Botón Crear y Búsqueda -->
    <div class="mb-8 flex flex-col lg:flex-row gap-4">
        <!-- Botón Crear -->
        <div class="lg:w-auto">
            <a href="{{ route('final-minutes.create') }}" 
               class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:from-green-600 hover:to-emerald-700">
                <i class="fas fa-plus text-white text-lg"></i>
            </a>
        </div>
        
        <!-- Formulario de Búsqueda -->
        <div class="flex-1">
            <form method="GET" action="{{ route('final-minutes.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Buscar por número de acta, comité o ciudad..." 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                </div>
                <div class="sm:w-48">
                    <input type="date" 
                           name="date" 
                           value="{{ request('date') }}" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                </div>
                <div class="flex gap-2">
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-search mr-2"></i>
                        Buscar
                    </button>
                    <a href="{{ route('final-minutes.index') }}" 
                       class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Mensajes -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
    @endif
    
    <!-- Información de Resultados -->
    @if(request('search') || request('date'))
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
            <span class="text-blue-700 font-medium">
                @if(request('search') && request('date'))
                    Mostrando resultados para "{{ request('search') }}" del {{ request('date') }} ({{ $finalMinutes->total() }} resultado{{ $finalMinutes->total() != 1 ? 's' : '' }})
                @elseif(request('search'))
                    Mostrando resultados para "{{ request('search') }}" ({{ $finalMinutes->total() }} resultado{{ $finalMinutes->total() != 1 ? 's' : '' }})
                @elseif(request('date'))
                    Mostrando actas del {{ request('date') }} ({{ $finalMinutes->total() }} resultado{{ $finalMinutes->total() != 1 ? 's' : '' }})
                @endif
            </span>
        </div>
    </div>
    @endif

    <!-- Lista de Actas -->
    @if($finalMinutes->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($finalMinutes as $finalMinute)
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
            <!-- Header de la Card -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white p-6 relative overflow-hidden">
                <!-- Patrón decorativo -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                                <i class="fas fa-file-contract text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Acta #{{ $finalMinute->act_number }}</h3>
                                <p class="text-blue-100 text-sm font-medium">{{ $finalMinute->committee_name }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar text-blue-200"></i>
                            <span class="text-blue-100 text-sm font-medium">{{ $finalMinute->date->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-clock text-blue-200"></i>
                            <span class="text-blue-100 text-sm font-medium">{{ $finalMinute->start_time->format('g:i A') }} - {{ $finalMinute->end_time->format('g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contenido de la Card -->
            <div class="p-6">
                <!-- Información Específica -->
                <div class="space-y-3 mb-6">
                    <!-- Solo Ubicación -->
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                        <span class="font-medium">{{ $finalMinute->city }}</span>
                    </div>
                    
                    <!-- Solo Archivos si existen -->
                    @if($finalMinute->attachments && count($finalMinute->attachments) > 0)
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-paperclip text-orange-500 mr-2"></i>
                        <span class="font-medium">{{ count($finalMinute->attachments) }} archivo(s)</span>
                    </div>
                    @endif
                </div>
                
                <!-- Botones de Acción -->
                <div class="flex justify-between items-center pt-4 border-t-2 border-gray-100">
                    <a href="{{ route('final-minutes.show', $finalMinute) }}" 
                       class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center" 
                       title="Ver Detalles">
                        <i class="fas fa-eye"></i>
                    </a>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('final-minutes.download-zip', $finalMinute) }}" 
                           class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center" 
                           title="Descargar ZIP">
                            <i class="fas fa-download"></i>
                        </a>
                        
                        <a href="{{ route('final-minutes.edit', $finalMinute) }}" 
                           class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center" 
                           title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <form action="{{ route('final-minutes.destroy', $finalMinute) }}" method="POST" class="inline" 
                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este acta?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center" 
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Paginación -->
    <div class="mt-8">
        {{ $finalMinutes->links() }}
    </div>
    
    @else
    <!-- Estado Vacío -->
    <div class="text-center py-16">
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-12 shadow-xl border border-gray-200 max-w-2xl mx-auto">
            @if(request('search') || request('date'))
                <!-- Sin resultados de búsqueda -->
                <div class="bg-gradient-to-r from-yellow-500 to-orange-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-search text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No se encontraron resultados</h3>
                <p class="text-gray-600 mb-8 text-lg">
                    @if(request('search') && request('date'))
                        No hay actas que coincidan con "{{ request('search') }}" del {{ request('date') }}
                    @elseif(request('search'))
                        No hay actas que coincidan con "{{ request('search') }}"
                    @elseif(request('date'))
                        No hay actas registradas para el {{ request('date') }}
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('final-minutes.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Limpiar Filtros
                    </a>
                    <a href="{{ route('final-minutes.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Crear Nueva Acta
                    </a>
                </div>
            @else
                <!-- Sin actas registradas -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-file-contract text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No hay actas de reunión</h3>
                <p class="text-gray-600 mb-8 text-lg">Comienza creando tu primera acta de reunión para gestionar tus documentos de manera profesional</p>
                <a href="{{ route('final-minutes.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:from-blue-600 hover:to-indigo-700">
                    <div class="bg-white/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-plus text-white text-lg"></i>
                    </div>
                    <span>Crear Primera Acta</span>
                </a>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection