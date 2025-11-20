@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 mb-8">
      <div class="flex flex-col lg:flex-row lg:items-center justify-between">
        <div class="flex items-center space-x-6 mb-6 lg:mb-0">
          <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-xl shadow-lg">
            <i class="fas fa-file-contract text-white text-2xl"></i>
          </div>
          <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Detalles del Acta</h1>
            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-6">
              <div class="flex items-center space-x-2">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                  #{{ $finalMinute->act_number }}
                </span>
                <span class="text-gray-600 font-medium">{{ $finalMinute->committee_name }}</span>
              </div>
              <div class="flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-calendar"></i>
                <span>{{ $finalMinute->date->format('d/m/Y') }}</span>
                <i class="fas fa-clock ml-2"></i>
                <span>{{ $finalMinute->start_time->format('g:i A') }} - {{ $finalMinute->end_time->format('g:i A') }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center space-x-3">
          <a href="{{ route('final-minutes.index') }}" 
             class="w-12 h-12 bg-gray-500 hover:bg-gray-600 text-white rounded-lg flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md" 
             title="Volver al Listado">
            <i class="fas fa-arrow-left"></i>
          </a>
          <a href="{{ route('final-minutes.download-zip', $finalMinute) }}" 
             class="w-12 h-12 bg-purple-500 hover:bg-purple-600 text-white rounded-lg flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md" 
             title="Descargar ZIP">
            <i class="fas fa-download"></i>
          </a>
          <a href="{{ route('final-minutes.edit', $finalMinute) }}" 
             class="w-12 h-12 bg-green-500 hover:bg-green-600 text-white rounded-lg flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md" 
             title="Editar Acta">
            <i class="fas fa-edit"></i>
          </a>
          <form action="{{ route('final-minutes.destroy', $finalMinute) }}" method="POST" class="inline" 
                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este acta?')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="w-12 h-12 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md" 
                    title="Eliminar Acta">
              <i class="fas fa-trash"></i>
            </button>
          </form>
        </div>
      </div>
    </div>

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

    <!-- Información Principal -->
    <div class="space-y-8 mb-8">
        <!-- Información del Acta -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Información del Acta</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg">
                    <i class="fas fa-calendar text-blue-600 text-lg"></i>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Fecha</p>
                        <p class="text-gray-800 font-semibold text-lg">{{ $finalMinute->date->format('d/m/Y') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg">
                    <i class="fas fa-clock text-green-600 text-lg"></i>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Horario</p>
                        <p class="text-gray-800 font-semibold text-lg">{{ $finalMinute->start_time->format('g:i A') }} - {{ $finalMinute->end_time->format('g:i A') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 p-4 bg-red-50 rounded-lg">
                    <i class="fas fa-map-marker-alt text-red-600 text-lg"></i>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Ciudad</p>
                        <p class="text-gray-800 font-semibold text-lg">{{ $finalMinute->city }}</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-4 bg-purple-50 rounded-lg">
                    <i class="fas fa-link text-purple-600 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Enlace del Lugar</p>
                        <p class="text-gray-800 font-semibold">{{ $finalMinute->place_link ?? 'No especificado' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-4 bg-orange-50 rounded-lg">
                    <i class="fas fa-building text-orange-600 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Centro Regional</p>
                        <p class="text-gray-800 font-semibold">{{ $finalMinute->address_regional_center ?? 'No especificado' }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 p-4 bg-indigo-50 rounded-lg">
                    <i class="fas fa-calendar-plus text-indigo-600 text-lg"></i>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Creado</p>
                        <p class="text-gray-800 font-semibold">{{ $finalMinute->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archivos Adjuntos -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                <div class="bg-orange-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-paperclip text-orange-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Archivos Adjuntos</h2>
                    <p class="text-sm text-gray-500">
                        @if($finalMinute->attachments && count($finalMinute->attachments) > 0)
                            {{ count($finalMinute->attachments) }} archivo{{ count($finalMinute->attachments) != 1 ? 's' : '' }}
                        @else
                            Sin archivos
                        @endif
                    </p>
                </div>
            </div>
            
            @if($finalMinute->attachments && count($finalMinute->attachments) > 0)
                <div class="space-y-4">
                    @foreach($finalMinute->attachments as $index => $attachment)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-red-500 text-white p-3 rounded-lg shadow-sm">
                                    <i class="fas fa-file-pdf text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm leading-tight">{{ $attachment['original_name'] }}</p>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded-full">
                                            {{ number_format($attachment['size'] / 1024, 1) }} KB
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($attachment['uploaded_at'])->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('final-minutes.download', ['finalMinute' => $finalMinute->id, 'attachmentIndex' => $index]) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-lg flex items-center transition-all duration-200 shadow-sm hover:shadow-md" 
                               title="Descargar Archivo">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-slash text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No hay archivos adjuntos</p>
                    <p class="text-gray-400 text-sm mt-1">Los archivos aparecerán aquí cuando se adjunten</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Conclusiones -->
    @if($finalMinute->conclusions)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 mb-8">
        <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
            <div class="bg-indigo-100 p-3 rounded-lg mr-4">
                <i class="fas fa-clipboard-list text-indigo-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Conclusiones</h2>
                <p class="text-sm text-gray-500">Resumen y conclusiones del acta</p>
            </div>
        </div>
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-6 border border-indigo-100">
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap text-base">{{ $finalMinute->conclusions }}</p>
            </div>
        </div>
    </div>
    @endif
  </div>
</div>

<style>
.whitespace-pre-wrap {
    white-space: pre-wrap;
}
</style>
@endsection
