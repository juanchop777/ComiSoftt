@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <div class="bg-blue-100 p-3 rounded-lg">
            <i class="fas fa-users text-blue-600 text-xl"></i>
          </div>
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Editar Comité General</h1>
            <p class="mt-2 text-gray-600">Acta #{{ $generalCommittee->act_number }}</p>
          </div>
        </div>
        <div class="flex space-x-3">
          <a href="{{ route('committee.general.show', $generalCommittee) }}" 
             class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Ver">
            <i class="fas fa-eye"></i>
          </a>
          <a href="{{ route('committee.general.index') }}" 
             class="bg-gray-500 hover:bg-gray-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Volver">
            <i class="fas fa-arrow-left"></i>
          </a>
        </div>
      </div>
    </div>

    @php
        use App\Models\Minute;
        $minutesForAct = Minute::where('act_number', $generalCommittee->act_number)->get();
    @endphp

    <form action="{{ route('committee.general.update', $generalCommittee) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        <input type="hidden" name="act_number" value="{{ $generalCommittee->act_number }}">

        <!-- Información de la Sesión -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-xl font-semibold text-gray-900">Información de la Sesión</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="session_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-1 text-blue-500"></i>
                        Fecha de Sesión
                    </label>
                    <input type="date" name="session_date" id="session_date" 
                           value="{{ old('session_date', $generalCommittee->session_date) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('session_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="session_time" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-clock mr-1 text-blue-500"></i>
                        Hora de Sesión
                    </label>
                    <input type="time" name="session_time" id="session_time" 
                           value="{{ old('session_time', $generalCommittee->session_time) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('session_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="access_link" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-link mr-1 text-blue-500"></i>
                        Enlace (opcional)
                    </label>
                    <input type="text" name="access_link" id="access_link" 
                           value="{{ old('access_link', $generalCommittee->access_link) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://...">
                    @error('access_link')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Información de los Aprendices -->
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-2xl border border-gray-100 p-8">
            <div class="flex items-center mb-8">
                <div class="flex-shrink-0 bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <h3 class="ml-4 text-2xl font-bold text-gray-800">Información de los Aprendices</h3>
            </div>
            
            @if($minutesForAct->count() > 0)
                <div class="space-y-8">
                    @foreach($minutesForAct as $idx => $m)
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-lg shadow-md">
                                    <i class="fas fa-user-graduate text-white"></i>
                                </div>
                                <h4 class="ml-3 text-lg font-bold text-blue-800">Aprendiz #{{ $idx + 1 }}</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 {{ $m->has_contract ? 'lg:grid-cols-2' : 'lg:grid-cols-1' }} gap-8">
                                <!-- Información Personal -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-lg shadow-md">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <h4 class="ml-3 text-lg font-bold text-blue-800">Información Personal</h4>
                                    </div>
                                    <div class="{{ $m->has_contract ? 'space-y-4' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4' }}">
                                        <!-- Nombre del Aprendiz -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Nombre del Aprendiz:</span>
                                                <span class="text-sm text-gray-800 font-medium bg-blue-50 px-3 py-1 rounded-full">{{ $m->trainee_name ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Tipo y Número de Documento -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Tipo de Documento:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->document_type ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Número de Documento:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->id_document ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Teléfono y Email -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Teléfono del Aprendiz:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->trainee_phone ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Email:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full break-all">{{ $m->email ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Programa de Formación -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Programa de Formación:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->program_name ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Número de Ficha -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Número de Ficha:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->batch_number ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Tipo de Programa -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Tipo de Programa:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->program_type ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Estado del Aprendiz -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Estado del Aprendiz:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->trainee_status ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Centro de Formación -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Centro de Formación:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->training_center ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Estado del Contrato -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">¿Tiene Contrato?:</span>
                                                @if($m->has_contract)
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
                                        
                                        <!-- Subtipo de Novedad -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-700">Subtipo de Novedad:</span>
                                                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $m->incident_subtype ? str_replace('_', ' ', $m->incident_subtype) : 'No especificado' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Información de la Empresa (solo si tiene contrato) -->
                                @if($m->has_contract)
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
                                                <span class="text-sm text-gray-800 font-medium bg-emerald-50 px-3 py-1 rounded-full">{{ $m->company_name ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Dirección de la Empresa -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-emerald-700">Dirección de la Empresa:</span>
                                                <span class="text-sm text-gray-800 bg-emerald-50 px-3 py-1 rounded-full">{{ $m->company_address ?: 'No especificado' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Contacto de la Empresa -->
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-emerald-700">Contacto de la Empresa:</span>
                                                <span class="text-sm text-gray-800 bg-emerald-50 px-3 py-1 rounded-full">{{ $m->company_contact ?? $m->hr_contact ?? 'No especificado' }}</span>
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
                    <p>No se encontraron aprendices para el acta #{{ $generalCommittee->act_number }}.</p>
                </div>
            @endif
        </div>

        <!-- Modalidad de Asistencia -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-xl font-semibold text-gray-900">Modalidad de Asistencia</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="attendance_mode" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-users mr-1 text-green-500"></i>
                        Modalidad
                    </label>
                    <select name="attendance_mode" id="attendance_mode" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="Presencial" {{ old('attendance_mode', $generalCommittee->attendance_mode) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="Virtual" {{ old('attendance_mode', $generalCommittee->attendance_mode) == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                        <option value="No asistió" {{ old('attendance_mode', $generalCommittee->attendance_mode) == 'No asistió' ? 'selected' : '' }}>No asistió</option>
                    </select>
                    @error('attendance_mode')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Información de la Novedad -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
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
                    @foreach($minutesForAct as $index => $minute)
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
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label for="offense_class" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-exclamation-triangle mr-1 text-red-500"></i>
                                Tipo de Falta
                            </label>
                            <select name="offense_class" id="offense_class" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="Leve" {{ old('offense_class', $generalCommittee->offense_class) == 'Leve' ? 'selected' : '' }}>Leve</option>
                                <option value="Grave" {{ old('offense_class', $generalCommittee->offense_class) == 'Grave' ? 'selected' : '' }}>Grave</option>
                                <option value="Gravísimo" {{ old('offense_class', $generalCommittee->offense_class) == 'Gravísimo' ? 'selected' : '' }}>Gravísimo</option>
                            </select>
                            @error('offense_class')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label for="offense_classification" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-alt mr-1 text-red-500"></i>
                                Descripción de la Falta
                            </label>
                            <textarea name="offense_classification" id="offense_classification" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('offense_classification', $generalCommittee->offense_classification) }}</textarea>
                            @error('offense_classification')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Descargos -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <i class="fas fa-comments text-purple-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-xl font-semibold text-gray-900">Descargos</h3>
            </div>
            
            <div class="flex gap-3 mb-6">
                <button type="button" id="editGeneralDescargoBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Descargo General</button>
                <button type="button" id="editIndividualDescargoBtn" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">Descargos Individuales</button>
            </div>
            
            @php
                $individualMap = [];
                if (!empty($generalCommittee->individual_statements)) {
                    $decoded = json_decode($generalCommittee->individual_statements, true);
                    if (is_array($decoded)) { $individualMap = $decoded; }
                }
                $hasIndividual = false;
                if (!empty($individualMap)) {
                    foreach ($individualMap as $v) { if (!empty($v)) { $hasIndividual = true; break; } }
                }
            @endphp
            
            <div id="editGeneralStatementsSection" style="{{ $hasIndividual ? 'display:none;' : '' }}">
                <div class="bg-gray-50 rounded-lg p-6">
                    <label for="general_statements" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-users mr-1 text-green-500"></i>
                        Descargo General
                    </label>
                    <textarea name="general_statements" id="general_statements" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500" {{ $hasIndividual ? 'disabled' : '' }}>{{ old('general_statements', $generalCommittee->general_statements) }}</textarea>
                    @error('general_statements')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div id="editIndividualStatementsSection" class="mt-4" style="{{ $hasIndividual ? '' : 'display:none;' }}">
                <div class="bg-gray-50 rounded-lg p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-user mr-1 text-green-500"></i>
                        Descargos Individuales
                    </label>
                    <div class="space-y-4">
                        @foreach($minutesForAct as $m)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descargo de {{ $m->trainee_name }}</label>
                                <textarea name="individual_statements[{{ $m->minutes_id }}]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500" {{ $hasIndividual ? '' : 'disabled' }}>{{ old('individual_statements.' . $m->minutes_id, $individualMap[$m->minutes_id] ?? '') }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Decisión y Compromisos -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <i class="fas fa-gavel text-orange-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-xl font-semibold text-gray-900">Decisión y Compromisos</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="commitments" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-handshake mr-1 text-yellow-500"></i>
                        Compromisos
                    </label>
                    <textarea name="commitments" id="commitments" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('commitments', $generalCommittee->commitments) }}</textarea>
                    @error('commitments')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="decision" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-balance-scale mr-1 text-yellow-500"></i>
                        Decisión
                    </label>
                    <textarea name="decision" id="decision" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('decision', $generalCommittee->decision) }}</textarea>
                    @error('decision')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <i class="fas fa-clipboard-list text-indigo-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-xl font-semibold text-gray-900">Información Adicional</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="missing_rating" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-star mr-1 text-blue-500"></i>
                        Calificación Faltante
                    </label>
                    <textarea name="missing_rating" id="missing_rating" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('missing_rating', $generalCommittee->missing_rating) }}</textarea>
                    @error('missing_rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="recommendations" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lightbulb mr-1 text-blue-500"></i>
                        Recomendaciones
                    </label>
                    <textarea name="recommendations" id="recommendations" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('recommendations', $generalCommittee->recommendations) }}</textarea>
                    @error('recommendations')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <label for="observations" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-eye mr-1 text-blue-500"></i>
                        Observaciones
                    </label>
                    <textarea name="observations" id="observations" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('observations', $generalCommittee->observations) }}</textarea>
                    @error('observations')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <div class="flex justify-end gap-4">
                <a href="{{ route('committee.general.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-lg">
                    <i class="fas fa-save mr-2"></i>Actualizar Comité
                </button>
            </div>
        </div>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const generalBtn = document.getElementById('editGeneralDescargoBtn');
    const individualBtn = document.getElementById('editIndividualDescargoBtn');
    const generalSection = document.getElementById('editGeneralStatementsSection');
    const individualSection = document.getElementById('editIndividualStatementsSection');

    function setDisabled(sectionEl, disabled) {
        const inputs = sectionEl.querySelectorAll('textarea, input, select');
        inputs.forEach(el => { el.disabled = disabled; });
    }

    function showGeneral() {
        generalSection.classList.remove('hidden');
        generalSection.style.display = '';
        individualSection.classList.add('hidden');
        individualSection.style.display = 'none';
        setDisabled(generalSection, false);
        setDisabled(individualSection, true);
        if (generalBtn.classList.contains('bg-gray-600')) generalBtn.classList.replace('bg-gray-600','bg-blue-600');
        if (individualBtn.classList.contains('bg-blue-600')) individualBtn.classList.replace('bg-blue-600','bg-gray-600');
    }

    function showIndividual() {
        generalSection.classList.add('hidden');
        generalSection.style.display = 'none';
        individualSection.classList.remove('hidden');
        individualSection.style.display = '';
        setDisabled(generalSection, true);
        setDisabled(individualSection, false);
        if (individualBtn.classList.contains('bg-gray-600')) individualBtn.classList.replace('bg-gray-600','bg-blue-600');
        if (generalBtn.classList.contains('bg-blue-600')) generalBtn.classList.replace('bg-blue-600','bg-gray-600');
    }

    if (generalBtn && individualBtn && generalSection && individualSection) {
        const hasIndividual = individualSection.querySelector('textarea') && Array.from(individualSection.querySelectorAll('textarea')).some(t => t.value && t.value.trim().length > 0);
        if (hasIndividual) {
            showIndividual();
        } else {
            showGeneral();
        }

        generalBtn.addEventListener('click', showGeneral);
        individualBtn.addEventListener('click', showIndividual);
    }
    
    // Manejo del subtipo de novedad
    const incidentTypeSelect = document.getElementById('incident_type');
    const incidentSubtypeSelect = document.getElementById('incident_subtype');
    
    // Almacenar el valor original del subtipo
    const originalSubtype = '{{ old("incident_subtype", $minutesForAct->first()->incident_subtype ?? "") }}';
    
    // Configurar el atributo data-original-value
    if (incidentSubtypeSelect) {
        incidentSubtypeSelect.setAttribute('data-original-value', originalSubtype);
    }
    
    // Función para poblar subtipos basado en el tipo seleccionado
    function populateSubtypes(incidentType) {
        if (!incidentSubtypeSelect) return;
        
        // Limpiar opciones existentes
        incidentSubtypeSelect.innerHTML = '<option value="">Seleccionar subtipo</option>';
        
        const subtypes = {
            'CANCELACION_MATRICULA_ACADEMICO': [
                { value: 'INCUMPLIMIENTO_CONTRATO_APRENDIZAJE', text: 'INCUMPLIMIENTO CONTRATO DE APRENDIZAJE' },
                { value: 'NO_CUMPLIO_PLAN_MEJORAMIENTO', text: 'NO CUMPLIÓ PLAN DE MEJORAMIENTO' }
            ],
            'CANCELACION_MATRICULA_DISCIPLINARIO': [
                { value: 'NO_CUMPLIO_PLAN_MEJORAMIENTO', text: 'NO CUMPLIÓ PLAN DE MEJORAMIENTO' },
                { value: 'SANCION_IMPUESTA_MEDIANTE_DEBIDO_PROCESO', text: 'SANCIÓN IMPUESTA MEDIANTE DEBIDO PROCESO' }
            ],
            'CONDICIONAMIENTO_MATRICULA': [
                { value: 'CONCERTACION_PLAN_DE_MEJORAMIENTO', text: 'CONCERTACIÓN PLAN DE MEJORAMIENTO' }
            ],
            'DESERCION_PROCESO_FORMACION': [
                { value: 'INCUMPLIMIENTO_INASISTENCIA_3_DIAS', text: 'INCUMPLIMIENTO - INASISTENCIA 3 DIAS CONSECUTIVOS O MÁS SIN JUSTIFICACIÓN' },
                { value: 'NO_PRESENTA_EVIDENCIA_ETAPA_PRODUCTIVA', text: 'NO PRESENTA EVIDENCIA REALIZACIÓN ETAPA PRODUCTIVA' },
                { value: 'NO_SE_REINTEGRA_APLAZAMIENTO', text: 'NO SE REINTEGRA A PARTIR DE LA FECHA LÍMITE AUTORIZADO APLAZAMIENTO' }
            ],
            'NO_GENERACION_CERTIFICADO': [
                { value: 'FORMACION_NO_REALIZADA', text: 'FORMACIÓN NO REALIZADA' },
                { value: 'PROGRAMA_DE_FORMACION_REALIZADO_NO_CORRESPONDE', text: 'PROGRAMA DE FORMACIÓN REALIZADO NO CORRESPONDE' }
            ],
            'RETIRO_POR_FRAUDE': [
                { value: 'SUPLANTACION_DATOS_BASICOS_PARA_CERTIFICARSE', text: 'SUPLANTACIÓN DATOS BÁSICOS PARA CERTIFICARSE' }
            ],
            'RETIRO_PROCESO_FORMACION': [
                { value: 'NO_INICIO_PROCESO_FORMACION', text: 'NO INICIÓ PROCESO DE FORMACIÓN' },
                { value: 'POR_FALLECIMIENTO', text: 'POR FALLECIMIENTO' }
            ],
            'TRASLADO_CENTRO': [
                { value: 'CAMBIO_DE_DOMICILIO', text: 'CAMBIO DE DOMICILIO' },
                { value: 'MOTIVOS_LABORALES', text: 'MOTIVOS LABORALES' },
                { value: 'MOTIVOS_PERSONALES', text: 'MOTIVOS PERSONALES' }
            ],
            'TRASLADO_JORNADA': [
                { value: 'MOTIVOS_LABORALES', text: 'MOTIVOS LABORALES' },
                { value: 'MOTIVOS_PERSONALES', text: 'MOTIVOS PERSONALES' }
            ],
            'TRASLADO_PROGRAMA': [
                { value: 'MOTIVOS_PERSONALES', text: 'MOTIVOS PERSONALES' }
            ]
        };
        
        if (subtypes[incidentType]) {
            subtypes[incidentType].forEach(subtype => {
                const option = document.createElement('option');
                option.value = subtype.value;
                option.textContent = subtype.text;
                incidentSubtypeSelect.appendChild(option);
            });
        }
        
        // Restaurar el valor original si existe
        if (originalSubtype && originalSubtype !== '') {
            incidentSubtypeSelect.value = originalSubtype;
        }
    }
    
    // Event listener para cambio de tipo de novedad
    if (incidentTypeSelect) {
        incidentTypeSelect.addEventListener('change', function() {
            populateSubtypes(this.value);
        });
        
        // Inicializar subtipos con el valor actual
        if (incidentTypeSelect.value) {
            populateSubtypes(incidentTypeSelect.value);
        }
    }
});
</script>
@endsection