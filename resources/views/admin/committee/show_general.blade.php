@extends('layouts.admin')

@php
use App\Models\Minute;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <div class="bg-blue-100 p-3 rounded-lg">
            <i class="fas fa-gavel text-blue-600 text-xl"></i>
          </div>
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Detalles del Comité General</h1>
            <p class="mt-2 text-gray-600">Acta #{{ $generalCommittee->act_number }}</p>
          </div>
        </div>
        <div class="flex space-x-3">
          <a href="{{ route('committee.general.index') }}" 
             class="bg-gray-500 hover:bg-gray-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Volver">
            <i class="fas fa-arrow-left"></i>
          </a>
          <a href="{{ route('committee.general.edit', $generalCommittee->general_committee_id) }}" 
             class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Editar">
            <i class="fas fa-edit"></i>
          </a>
          <a href="{{ route('committee.general.pdf', $generalCommittee->general_committee_id) }}" 
             class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Exportar PDF">
            <i class="fas fa-file-pdf"></i>
          </a>
        </div>
      </div>
    </div>

    @if(session('success'))
      <div class="bg-green-50 text-green-800 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex">
          <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-400"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium">{{ session('success') }}</p>
          </div>
        </div>
      </div>
    @endif

    <!-- Información de la Sesión -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
      <div class="flex items-center mb-6">
        <div class="flex-shrink-0">
          <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
        </div>
        <h3 class="ml-3 text-xl font-semibold text-gray-900">Información de la Sesión</h3>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-calendar mr-1 text-blue-500"></i>
            Fecha de Sesión
          </label>
          <p class="text-gray-900 font-medium">{{ $generalCommittee->session_date }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-clock mr-1 text-blue-500"></i>
            Hora de Sesión
          </label>
          <p class="text-gray-900 font-medium">{{ $generalCommittee->session_time }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-users mr-1 text-blue-500"></i>
            Modalidad de Asistencia
          </label>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            {{ $generalCommittee->attendance_mode }}
          </span>
        </div>
        @if($generalCommittee->attendance_mode == 'Virtual' && $generalCommittee->access_link)
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-link mr-1 text-blue-500"></i>
            Enlace de Acceso
          </label>
          <a href="{{ $generalCommittee->access_link }}" target="_blank" 
             class="text-blue-600 hover:text-blue-800 underline text-sm break-all">
            {{ $generalCommittee->access_link }}
          </a>
        </div>
        @endif
      </div>
    </div>

    <!-- Información de los Aprendices -->
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-2xl border border-gray-100 p-8 mb-8">
      <div class="flex items-center mb-8">
        <div class="flex-shrink-0 bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl shadow-lg">
          <i class="fas fa-users text-white text-xl"></i>
        </div>
        <h3 class="ml-4 text-2xl font-bold text-gray-800">Información de los Aprendices</h3>
      </div>
      
      @if($minutes->count() > 0)
        <div class="space-y-8">
          @foreach($minutes as $index => $minute)
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300">
              <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-lg shadow-md">
                  <i class="fas fa-user-graduate text-white"></i>
                </div>
                <h4 class="ml-3 text-lg font-bold text-blue-800">Aprendiz #{{ $index + 1 }}</h4>
              </div>
              
              <div class="grid grid-cols-1 {{ $minute->has_contract ? 'lg:grid-cols-2' : 'lg:grid-cols-1' }} gap-8">
                <!-- Información Personal -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300">
                  <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-lg shadow-md">
                      <i class="fas fa-user text-white"></i>
                    </div>
                    <h4 class="ml-3 text-lg font-bold text-blue-800">Información Personal</h4>
                  </div>
                  <div class="{{ $minute->has_contract ? 'space-y-4' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4' }}">
                    <!-- Nombre del Aprendiz -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Nombre del Aprendiz:</span>
                        <span class="text-sm text-gray-800 font-medium bg-blue-50 px-3 py-1 rounded-full">{{ $minute->trainee_name ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Tipo y Número de Documento -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Tipo de Documento:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $minute->document_type ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Número de Documento:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $minute->id_document ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Teléfono y Email -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Teléfono del Aprendiz:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $minute->trainee_phone ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Email:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full break-all">{{ $minute->email ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Programa de Formación -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Programa de Formación:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $minute->program_name ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Número de Ficha -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Número de Ficha:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $minute->batch_number ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Tipo de Programa -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Tipo de Programa:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $minute->program_type ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Estado del Aprendiz -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Estado del Aprendiz:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $minute->trainee_status ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Centro de Formación -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">Centro de Formación:</span>
                        <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $minute->training_center ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Estado del Contrato -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-700">¿Tiene Contrato?:</span>
                        @if($minute->has_contract)
                          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Sí
                          </span>
                        @else
                          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>
                            No
                          </span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Información de la Empresa (solo si tiene contrato) -->
                @if($minute->has_contract)
                <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 shadow-lg border border-emerald-100 hover:shadow-xl transition-all duration-300">
                  <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 p-2 rounded-lg shadow-md">
                      <i class="fas fa-building text-white"></i>
                    </div>
                    <h4 class="ml-3 text-lg font-bold text-emerald-800">Información de la Empresa</h4>
                  </div>
                  <div class="space-y-4">
                    <!-- Nombre de la Empresa -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-emerald-700">Nombre de la Empresa:</span>
                        <span class="text-sm text-gray-800 font-medium bg-emerald-50 px-3 py-1 rounded-full">{{ $minute->company_name ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Dirección de la Empresa -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-emerald-700">Dirección de la Empresa:</span>
                        <span class="text-sm text-gray-800 bg-emerald-50 px-3 py-1 rounded-full">{{ $minute->company_address ?: 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- Contacto de la Empresa -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-emerald-700">Contacto de la Empresa:</span>
                        <span class="text-sm text-gray-800 bg-emerald-50 px-3 py-1 rounded-full">{{ $minute->company_contact ?? $minute->hr_contact ?? 'No especificado' }}</span>
                      </div>
                    </div>
                    
                    <!-- RRHH Responsable -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-emerald-700">RRHH Responsable:</span>
                        <span class="text-sm text-gray-800 bg-emerald-50 px-3 py-1 rounded-full">{{ $generalCommittee->hr_responsible ?? 'No especificado' }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-8 text-gray-500">
          <i class="fas fa-users text-4xl mb-4"></i>
          <p>No se encontraron aprendices para esta acta.</p>
        </div>
      @endif
    </div>

    <!-- Información de la Novedad -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
      <div class="flex items-center mb-6">
        <div class="flex-shrink-0">
          <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
        </div>
        <h3 class="ml-3 text-xl font-semibold text-gray-900">Información de la Novedad</h3>
      </div>
      
      <!-- Información de Novedades por Aprendiz -->
      <div class="mt-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
          Novedades por Aprendiz
        </h4>
        <div class="space-y-6">
          @foreach($minutes as $index => $minute)
            <div class="bg-white rounded-lg border border-gray-200">
              <div class="bg-red-600 text-white px-4 py-3 rounded-t-lg">
                <h5 class="font-semibold flex items-center">
                  <i class="fas fa-user mr-2"></i>
                  {{ $minute->trainee_name ?: 'Aprendiz #' . ($index + 1) }}
                </h5>
              </div>
              <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Novedad</label>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                      <span class="inline-block bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                        @php
                          $incidentTypeMap = [
                            'CANCELACION_MATRICULA_ACADEMICO' => 'CANCELACIÓN MATRÍCULA ÍNDOLE ACADÉMICO',
                            'CANCELACION_MATRICULA_DISCIPLINARIO' => 'CANCELACIÓN MATRÍCULA ÍNDOLE DISCIPLINARIO',
                            'CONDICIONAMIENTO_MATRICULA' => 'CONDICIONAMIENTO DE MATRÍCULA',
                            'DESERCION_PROCESO_FORMACION' => 'DESERCIÓN PROCESO DE FORMACIÓN',
                            'NO_GENERACION_CERTIFICADO' => 'NO GENERACIÓN-CERTIFICADO',
                            'RETIRO_POR_FRAUDE' => 'RETIRO POR FRAUDE',
                            'RETIRO_PROCESO_FORMACION' => 'RETIRO PROCESO DE FORMACIÓN',
                            'TRASLADO_CENTRO' => 'TRASLADO DE CENTRO',
                            'TRASLADO_JORNADA' => 'TRASLADO DE JORNADA',
                            'TRASLADO_PROGRAMA' => 'TRASLADO DE PROGRAMA',
                            'Academic' => 'Académica',
                            'Disciplinary' => 'Disciplinaria',
                            'Dropout' => 'Deserción'
                          ];
                          $translatedType = $incidentTypeMap[$minute->incident_type ?? ''] ?? $minute->incident_type ?? 'No especificado';
                        @endphp
                        {{ $translatedType }}
                      </span>
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtipo de Novedad</label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                      <span class="text-blue-800 font-medium">
                        {{ $minute->incident_subtype ? str_replace('_', ' ', $minute->incident_subtype) : 'No especificado' }}
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="mt-4">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Descripción de la Novedad</label>
                  <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <p class="text-gray-800">{{ $minute->incident_description ?: 'No especificado' }}</p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      
      <!-- Información de la Falta -->
      <div class="mt-8">
        <div class="border-t border-gray-200 pt-6">
          <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
            Información de la Falta
          </h4>
          
          <div class="grid grid-cols-1 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-tag mr-1 text-red-500"></i>
                Tipo de Falta
              </label>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                @if($generalCommittee->offense_class == 'Leve') bg-green-100 text-green-800
                @elseif($generalCommittee->offense_class == 'Grave') bg-yellow-100 text-yellow-800
                @elseif($generalCommittee->offense_class == 'Gravísimo') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ $generalCommittee->offense_class ?: 'No especificado' }}
              </span>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-file-alt mr-1 text-red-500"></i>
                Descripción de la Falta
              </label>
              <p class="text-gray-900">{{ $generalCommittee->offense_classification ?: 'No especificado' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Descargos -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
      <div class="flex items-center mb-6">
        <div class="flex-shrink-0">
          <i class="fas fa-comments text-purple-600 text-xl"></i>
        </div>
        <h3 class="ml-3 text-xl font-semibold text-gray-900">Descargos</h3>
      </div>
      
      @if($generalCommittee->general_statements)
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-users mr-1 text-blue-500"></i>
            Descargo General
          </label>
          <div class="bg-white rounded-lg p-4 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $generalCommittee->general_statements }}</p>
          </div>
        </div>
      @endif

      @if($generalCommittee->individual_statements)
        <div class="bg-gray-50 rounded-lg p-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-user-edit mr-1 text-blue-500"></i>
            Descargos Individuales
          </label>
          @php
            // Estructura esperada: puede ser un array indexado o un mapa minutes_id => descargo
            $individualStatements = json_decode($generalCommittee->individual_statements, true);
            // Mapa de minutes_id => Minute para resolver nombres
            $minutesById = Minute::where('act_number', $generalCommittee->act_number)->get()->keyBy('minutes_id');
            $minutesList = $minutesById->values();
          @endphp
          @if(is_array($individualStatements))
            @foreach($individualStatements as $key => $statement)
              @php
                $labelName = null;
                // Si la clave es un minutes_id, úsalo para obtener el nombre
                if (is_string($key) || is_int($key)) {
                  $minute = $minutesById[$key] ?? null;
                  if ($minute) {
                    $labelName = $minute->trainee_name;
                  }
                }
                // Si sigue sin nombre, intentamos por índice de posición
                if (!$labelName && is_numeric($key)) {
                  $minuteByIndex = $minutesList->get((int)$key);
                  if ($minuteByIndex) {
                    $labelName = $minuteByIndex->trainee_name;
                  }
                }
                if (!$labelName) {
                  $labelName = 'Aprendiz ' . (is_numeric($key) ? ((int)$key + 1) : '');
                }
              @endphp
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $labelName }}</label>
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                  <p class="text-gray-900 whitespace-pre-wrap">{{ $statement }}</p>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      @endif
    </div>

    <!-- Información Adicional -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
      <div class="flex items-center mb-6">
        <div class="flex-shrink-0">
          <i class="fas fa-clipboard-list text-indigo-600 text-xl"></i>
        </div>
        <h3 class="ml-3 text-xl font-semibold text-gray-900">Información Adicional</h3>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-star mr-1 text-blue-500"></i>
            Calificación Faltante
          </label>
          <div class="bg-white rounded-lg p-3 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $generalCommittee->missing_rating ?: 'No especificado' }}</p>
          </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lightbulb mr-1 text-blue-500"></i>
            Recomendaciones
          </label>
          <div class="bg-white rounded-lg p-3 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $generalCommittee->recommendations ?: 'No especificado' }}</p>
          </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-eye mr-1 text-blue-500"></i>
            Observaciones
          </label>
          <div class="bg-white rounded-lg p-3 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $generalCommittee->observations ?: 'No especificado' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Decisión y Compromisos -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
      <div class="flex items-center mb-6">
        <div class="flex-shrink-0">
          <i class="fas fa-gavel text-orange-600 text-xl"></i>
        </div>
        <h3 class="ml-3 text-xl font-semibold text-gray-900">Decisión y Compromisos</h3>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-handshake mr-1 text-blue-500"></i>
            Compromisos
          </label>
          <div class="bg-white rounded-lg p-4 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $generalCommittee->commitments ?: 'No especificado' }}</p>
          </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-balance-scale mr-1 text-blue-500"></i>
            Decisión
          </label>
          <div class="bg-white rounded-lg p-4 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $generalCommittee->decision ?: 'No especificado' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection