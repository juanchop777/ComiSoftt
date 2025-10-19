@extends('layouts.admin')

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
            <h1 class="text-3xl font-bold text-gray-900">Detalles del Comité Individual</h1>
            <p class="mt-2 text-gray-600">Acta #{{ $individualCommittee->act_number }} - {{ $individualCommittee->trainee_name }}</p>
          </div>
        </div>
        <div class="flex space-x-3">
          <a href="{{ route('committee.individual.index') }}" 
             class="bg-gray-500 hover:bg-gray-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Volver">
            <i class="fas fa-arrow-left"></i>
          </a>
          <a href="{{ route('committee.individual.edit', $individualCommittee->individual_committee_id) }}" 
             class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Editar">
            <i class="fas fa-edit"></i>
          </a>
          <a href="{{ route('committee.individual.pdf', $individualCommittee->individual_committee_id) }}" 
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
          <p class="text-gray-900 font-medium">{{ $individualCommittee->session_date }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-clock mr-1 text-blue-500"></i>
            Hora de Sesión
          </label>
          <p class="text-gray-900 font-medium">{{ $individualCommittee->session_time }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-users mr-1 text-blue-500"></i>
            Modalidad de Asistencia
          </label>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            {{ $individualCommittee->attendance_mode }}
          </span>
        </div>
        @if($individualCommittee->attendance_mode == 'Virtual' && $individualCommittee->access_link)
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-link mr-1 text-blue-500"></i>
            Enlace de Acceso
          </label>
          <a href="{{ $individualCommittee->access_link }}" target="_blank" 
             class="text-blue-600 hover:text-blue-800 underline text-sm break-all">
            {{ $individualCommittee->access_link }}
          </a>
        </div>
        @endif
      </div>
    </div>

    <!-- Información del Aprendiz -->
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-2xl border border-gray-100 p-8 mb-8">
      <div class="flex items-center mb-8">
        <div class="flex-shrink-0 bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl shadow-lg">
          <i class="fas fa-user-graduate text-white text-xl"></i>
        </div>
        <h3 class="ml-4 text-2xl font-bold text-gray-800">Información del Aprendiz</h3>
      </div>
      
      <div class="grid grid-cols-1 {{ $individualCommittee->minutes && $individualCommittee->minutes->has_contract ? 'lg:grid-cols-2' : 'lg:grid-cols-1' }} gap-8">
        <!-- Información Personal -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-lg shadow-md">
              <i class="fas fa-user text-white"></i>
            </div>
            <h4 class="ml-3 text-lg font-bold text-blue-800">Información Personal</h4>
          </div>
          <div class="{{ $individualCommittee->minutes && $individualCommittee->minutes->has_contract ? 'space-y-4' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4' }}">
            <!-- Nombre del Aprendiz -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Nombre del Aprendiz:</span>
                <span class="text-sm text-gray-800 font-medium bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->trainee_name ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Tipo y Número de Documento -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Tipo de Documento:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->document_type ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Número de Documento:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->id_document ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Teléfono y Email -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Teléfono del Aprendiz:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->trainee_phone ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Email:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full break-all">{{ $individualCommittee->email ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Programa de Formación -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Programa de Formación:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->program_name ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Número de Ficha -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Número de Ficha:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->batch_number ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Tipo de Programa -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Tipo de Programa:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->program_type ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Estado del Aprendiz -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Estado del Aprendiz:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->trainee_status ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Centro de Formación -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">Centro de Formación:</span>
                <span class="text-sm text-gray-800 bg-blue-50 px-3 py-1 rounded-full">{{ $individualCommittee->training_center ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Estado del Contrato -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-blue-700">¿Tiene Contrato?:</span>
                @if($individualCommittee->minutes && $individualCommittee->minutes->has_contract)
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
        @if($individualCommittee->minutes && $individualCommittee->minutes->has_contract)
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
                <span class="text-sm text-gray-800 font-medium bg-emerald-50 px-3 py-1 rounded-full">{{ $individualCommittee->company_name ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Dirección de la Empresa -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-emerald-700">Dirección de la Empresa:</span>
                <span class="text-sm text-gray-800 bg-emerald-50 px-3 py-1 rounded-full">{{ $individualCommittee->company_address ?: 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- Contacto de la Empresa -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-emerald-700">Contacto de la Empresa:</span>
                <span class="text-sm text-gray-800 bg-emerald-50 px-3 py-1 rounded-full">{{ $individualCommittee->company_contact ?? $individualCommittee->hr_contact ?? 'No especificado' }}</span>
              </div>
            </div>
            
            <!-- RRHH Responsable -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-200">
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-emerald-700">RRHH Responsable:</span>
                <span class="text-sm text-gray-800 bg-emerald-50 px-3 py-1 rounded-full">{{ $individualCommittee->hr_responsible ?? 'No especificado' }}</span>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>

    <!-- Información de la Novedad -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
      <div class="flex items-center mb-6">
        <div class="flex-shrink-0">
          <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
        </div>
        <h3 class="ml-3 text-xl font-semibold text-gray-900">Información de la Novedad</h3>
      </div>
      
      <div class="grid grid-cols-1 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-tag mr-1 text-blue-500"></i>
            Tipo de Novedad
          </label>
          <p class="text-gray-900 font-medium">
            @if($individualCommittee->incident_type == 'Academic')
              Académica
            @elseif($individualCommittee->incident_type == 'Disciplinary')
              Disciplinaria
            @elseif($individualCommittee->incident_type == 'Other')
              Otra
            @else
              {{ $individualCommittee->incident_type ?: 'No especificado' }}
            @endif
          </p>
        </div>
        
        @if($individualCommittee->incident_subtype)
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-tags mr-1 text-blue-500"></i>
            Subtipo de Novedad
          </label>
          <p class="text-gray-900 font-medium">{{ str_replace('_', ' ', $individualCommittee->incident_subtype) }}</p>
        </div>
        @endif
        
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-file-alt mr-1 text-blue-500"></i>
            Descripción de la Novedad
          </label>
          <p class="text-gray-900">{{ $individualCommittee->incident_description ?: 'No especificado' }}</p>
        </div>
      </div>
    </div>

    <!-- Información de la Falta -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
      <div class="flex items-center mb-6">
        <div class="flex-shrink-0">
          <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
        </div>
        <h3 class="ml-3 text-xl font-semibold text-gray-900">Información de la Falta</h3>
      </div>
      
      <div class="grid grid-cols-1 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-tag mr-1 text-blue-500"></i>
            Tipo de Falta
          </label>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
            @if($individualCommittee->offense_class == 'Leve') bg-green-100 text-green-800
            @elseif($individualCommittee->offense_class == 'Grave') bg-yellow-100 text-yellow-800
            @elseif($individualCommittee->offense_class == 'Gravísimo') bg-red-100 text-red-800
            @else bg-gray-100 text-gray-800 @endif">
            {{ $individualCommittee->offense_class ?: 'No especificado' }}
          </span>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-file-alt mr-1 text-blue-500"></i>
            Descripción de la Falta
          </label>
          <p class="text-gray-900">{{ $individualCommittee->offense_classification ?: 'No especificado' }}</p>
        </div>
      </div>
    </div>

    <!-- Descargos del Aprendiz -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
      <div class="flex items-center mb-6">
        <div class="flex-shrink-0">
          <i class="fas fa-comments text-purple-600 text-xl"></i>
        </div>
        <h3 class="ml-3 text-xl font-semibold text-gray-900">Descargos del Aprendiz</h3>
      </div>
      
      <div class="bg-gray-50 rounded-lg p-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          <i class="fas fa-user-edit mr-1 text-blue-500"></i>
          Descargos del Aprendiz
        </label>
        <div class="bg-white rounded-lg p-4 border border-gray-200">
          <p class="text-gray-900 whitespace-pre-wrap">{{ $individualCommittee->statement ?: 'No se registraron descargos' }}</p>
        </div>
      </div>
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
            <p class="text-gray-900 whitespace-pre-wrap">{{ $individualCommittee->missing_rating ?: 'No especificado' }}</p>
          </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lightbulb mr-1 text-blue-500"></i>
            Recomendaciones
          </label>
          <div class="bg-white rounded-lg p-3 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $individualCommittee->recommendations ?: 'No especificado' }}</p>
          </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-eye mr-1 text-blue-500"></i>
            Observaciones
          </label>
          <div class="bg-white rounded-lg p-3 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $individualCommittee->observations ?: 'No especificado' }}</p>
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
            <p class="text-gray-900 whitespace-pre-wrap">{{ $individualCommittee->commitments ?: 'No especificado' }}</p>
          </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-balance-scale mr-1 text-blue-500"></i>
            Decisión
          </label>
          <div class="bg-white rounded-lg p-4 border border-gray-200">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $individualCommittee->decision ?: 'No especificado' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection