@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Detalles del Comité Individual</h2>
    <div class="flex gap-2">
      <a href="{{ route('committee.individual.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>Volver a la Lista
      </a>
      <a href="{{ route('committee.individual.edit', $individualCommittee->individual_committee_id) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
        <i class="fas fa-edit mr-2"></i>Editar
      </a>
      <a href="{{ route('committee.individual.pdf', $individualCommittee->individual_committee_id) }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
        <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-green-50 text-green-800 border border-green-200 rounded p-3 mb-4">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Información Básica -->
    <div class="bg-blue-100 text-blue-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Información Básica</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Sesión</label>
          <p class="text-gray-900">{{ $individualCommittee->session_date }} {{ $individualCommittee->session_time }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Número de Acta</label>
          <p class="text-gray-900">#{{ $individualCommittee->act_number }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Fecha del Acta</label>
          <p class="text-gray-900">{{ $individualCommittee->minutes_date }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Modalidad de Asistencia</label>
          <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            {{ $individualCommittee->attendance_mode }}
          </span>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Falta</label>
          <p class="text-gray-900">{{ $individualCommittee->offense_class }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la Falta</label>
          <p class="text-gray-900">{{ $individualCommittee->offense_classification }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Modo de Comité</label>
          <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            {{ $individualCommittee->committee_mode }}
          </span>
        </div>
      </div>
    </div>

    <!-- Información del Aprendiz -->
    <div class="bg-green-100 text-green-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Información del Aprendiz</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Aprendiz</label>
          <p class="text-gray-900">{{ $individualCommittee->trainee_name }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Documento de Identidad</label>
          <p class="text-gray-900">{{ $individualCommittee->id_document }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <p class="text-gray-900">{{ $individualCommittee->email }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Programa</label>
          <p class="text-gray-900">{{ $individualCommittee->program_name }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Número de Ficha</label>
          <p class="text-gray-900">{{ $individualCommittee->batch_number }}</p>
        </div>
      </div>
    </div>

    <!-- Información de la Novedad -->
    <div class="bg-yellow-100 text-yellow-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Información de la Novedad</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Novedad</label>
          <p class="text-gray-900">
            @if($individualCommittee->incident_type == 'Academic')
              Académica
            @elseif($individualCommittee->incident_type == 'Disciplinary')
              Disciplinaria
            @elseif($individualCommittee->incident_type == 'Other')
              Otra
            @else
              {{ $individualCommittee->incident_type }}
            @endif
          </p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la Novedad</label>
          <p class="text-gray-900">{{ $individualCommittee->incident_description }}</p>
        </div>
      </div>
    </div>

    <!-- Información de la Empresa (si tiene contrato) -->
    @if($individualCommittee->minutes && $individualCommittee->minutes->has_contract)
    <div class="bg-green-100 text-green-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Información de la Empresa</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Empresa</label>
          <p class="text-gray-900">{{ $individualCommittee->company_name }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Dirección de la Empresa</label>
          <p class="text-gray-900">{{ $individualCommittee->company_address }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Contacto de la Empresa</label>
          <p class="text-gray-900">{{ $individualCommittee->company_contact ?? $individualCommittee->hr_contact ?? 'No especificado' }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">RRHH Responsable</label>
          <p class="text-gray-900">{{ $individualCommittee->hr_responsible ?? 'No especificado' }}</p>
        </div>
      </div>
    </div>
    @endif

    <!-- Descargos del Aprendiz -->
    <div class="bg-green-100 text-green-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Descargos del Aprendiz</h3>
    </div>
    <div class="p-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Descargo</label>
        <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $individualCommittee->statement }}</p>
      </div>
    </div>

    <!-- Decisión del Comité -->
    <div class="bg-yellow-100 text-yellow-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Decisión del Comité</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Decisión</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $individualCommittee->decision }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Compromisos</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $individualCommittee->commitments }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Calificación Faltante</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $individualCommittee->missing_rating }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Recomendaciones</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $individualCommittee->recommendations }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $individualCommittee->observations }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection