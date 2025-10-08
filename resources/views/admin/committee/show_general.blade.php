@extends('layouts.admin')

@php
use App\Models\Minute;
@endphp

@section('content')
<div class="container mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Detalles del Comité General</h2>
    <div class="flex gap-2">
      <a href="{{ route('committee.general.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>Volver a la Lista
      </a>
      <a href="{{ route('committee.general.edit', $generalCommittee->general_committee_id) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
        <i class="fas fa-edit mr-2"></i>Editar
      </a>
      <a href="{{ route('committee.general.pdf', $generalCommittee->general_committee_id) }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
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
          <p class="text-gray-900">{{ $generalCommittee->session_date }} {{ $generalCommittee->session_time }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Número de Acta</label>
          <p class="text-gray-900">#{{ $generalCommittee->act_number }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Fecha del Acta</label>
          <p class="text-gray-900">{{ $generalCommittee->minutes_date }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Modalidad de Asistencia</label>
          <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            {{ $generalCommittee->attendance_mode }}
          </span>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Falta</label>
          <p class="text-gray-900">{{ $generalCommittee->offense_class }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Enlace de Acceso</label>
          <p class="text-gray-900">{{ $generalCommittee->access_link ?: 'No especificado' }}</p>
        </div>
      </div>
    </div>

    <!-- Información de los Aprendices -->
    <div class="bg-green-100 text-green-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Información de los Aprendices</h3>
    </div>
    <div class="p-6">
      @php
        $minutes = Minute::where('act_number', $generalCommittee->act_number)->get();
      @endphp
      @if($minutes->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          @foreach($minutes as $index => $minute)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
              <div class="bg-green-600 text-white px-4 py-3">
                <h4 class="font-semibold text-lg">Aprendiz #{{ $index + 1 }}</h4>
              </div>
              <div class="p-4">
                <!-- Información Personal -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nombre</label>
                    <p class="text-sm font-medium text-gray-900">{{ $minute->trainee_name ?: 'No especificado' }}</p>
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Documento</label>
                    <p class="text-sm font-medium text-gray-900">{{ $minute->id_document ?: 'No especificado' }}</p>
                  </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                    <p class="text-sm text-gray-700">{{ $minute->email ?: 'No especificado' }}</p>
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Programa</label>
                    <p class="text-sm text-gray-700">{{ $minute->program_name ?: 'No especificado' }}</p>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Ficha</label>
                    <p class="text-sm text-gray-700">{{ $minute->batch_number ?: 'No especificado' }}</p>
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Contrato</label>
                    <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $minute->has_contract ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                      {{ $minute->has_contract ? 'Sí' : 'No' }}
                    </span>
                  </div>
                </div>

                <!-- Estado y Tipo -->
                <div class="flex justify-between items-center mb-4">
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tipo Novedad</label>
                    <span class="inline-block bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                      @php
                        $incidentTypeMap = [
                          'Academic' => 'Académica',
                          'Disciplinary' => 'Disciplinaria', 
                          'Other' => 'Otra'
                        ];
                        $translatedType = $incidentTypeMap[$minute->incident_type] ?? $minute->incident_type;
                      @endphp
                      {{ $translatedType ?: 'No especificado' }}
                    </span>
                  </div>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                  <label class="block text-xs font-medium text-gray-500 mb-1">Descripción</label>
                  <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded">{{ $minute->incident_description ?: 'No especificado' }}</p>
                </div>

                <!-- Información de Empresa (solo si tiene contrato) -->
                @if($minute->has_contract)
                  <div class="border-t pt-4">
                    <h5 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                      <i class="fas fa-building mr-2 text-green-500"></i>
                      Información de la Empresa
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Empresa</label>
                        <p class="text-sm text-gray-700">{{ $minute->company_name ?: 'No especificado' }}</p>
                      </div>
                      <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Dirección</label>
                        <p class="text-sm text-gray-700">{{ $minute->company_address ?: 'No especificado' }}</p>
                      </div>
                      <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Responsable RH</label>
                        <p class="text-sm text-gray-700">{{ $minute->hr_responsible ?: 'No especificado' }}</p>
                      </div>
                      <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Contacto Empresa</label>
                        <p class="text-sm text-gray-700">{{ $minute->company_contact ?: 'No especificado' }}</p>
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
    <div class="bg-yellow-100 text-yellow-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Información de la Novedad</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Novedad</label>
          <p class="text-gray-900">
            @php
              $incidentTypeMap = [
                'Academic' => 'Académica',
                'Disciplinary' => 'Disciplinaria', 
                'Other' => 'Otra'
              ];
              $translatedType = $incidentTypeMap[$generalCommittee->incident_type] ?? $generalCommittee->incident_type;
            @endphp
            {{ $translatedType ?: 'No especificado' }}
          </p>
        </div>
      </div>
      <div class="mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la Falta</label>
        <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $generalCommittee->offense_classification ?: 'No especificado' }}</p>
      </div>
      <div class="mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la Novedad</label>
        <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $generalCommittee->incident_description ?: 'No especificado' }}</p>
      </div>
    </div>

    <!-- Descargos -->
    <div class="bg-green-100 text-green-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Descargos</h3>
    </div>
    <div class="p-6">
      @if($generalCommittee->general_statements)
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1">Descargo General</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $generalCommittee->general_statements }}</p>
        </div>
      @endif

      @if($generalCommittee->individual_statements)
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Descargos Individuales</label>
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
                <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $statement }}</p>
              </div>
            @endforeach
          @endif
        </div>
      @endif
    </div>

    <!-- Decisión y Compromisos -->
    <div class="bg-yellow-100 text-yellow-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Decisión y Compromisos</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Decisión</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $generalCommittee->decision ?: 'No especificado' }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Compromisos</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $generalCommittee->commitments ?: 'No especificado' }}</p>
        </div>
      </div>
    </div>

    <!-- Información Adicional -->
    <div class="bg-blue-100 text-blue-800 px-6 py-4">
      <h3 class="text-lg font-semibold">Información Adicional</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Calificación Faltante</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $generalCommittee->missing_rating ?: 'No especificado' }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Recomendaciones</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $generalCommittee->recommendations ?: 'No especificado' }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
          <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $generalCommittee->observations ?: 'No especificado' }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection