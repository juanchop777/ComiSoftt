@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-3">
            <div class="bg-gray-100 p-3 rounded-lg">
                <i class="fas fa-users text-gray-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar Comité General</h1>
                <p class="text-gray-600">Acta #{{ $generalCommittee->act_number }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('committee.general.show', $generalCommittee) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-eye"></i>
                <span>Ver</span>
            </a>
            <a href="{{ route('committee.general.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>

    @php
        use App\Models\Minute;
        $minutesForAct = Minute::where('act_number', $generalCommittee->act_number)->get();
    @endphp

    <form action="{{ route('committee.general.update', $generalCommittee) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="act_number" value="{{ $generalCommittee->act_number }}">

        <!-- Información de la Sesión -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-blue-100 text-blue-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    Información de la Sesión
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="session_date" class="block text-sm font-semibold text-gray-700 mb-2">
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
                    <div>
                        <label for="session_time" class="block text-sm font-semibold text-gray-700 mb-2">
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
                    <div>
                        <label for="access_link" class="block text-sm font-semibold text-gray-700 mb-2">
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
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-green-100 text-green-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-user-graduate mr-2"></i>
                    Información de los Aprendices
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                @if($minutesForAct->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($minutesForAct as $idx => $m)
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                <div class="bg-green-600 text-white px-4 py-2">
                                    <h4 class="font-semibold">Aprendiz #{{ $idx + 1 }}</h4>
                                </div>
                                <div class="p-4 text-sm">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Nombre</label>
                                            <p class="text-gray-900">{{ $m->trainee_name ?: 'No especificado' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Documento</label>
                                            <p class="text-gray-900">{{ $m->id_document ?: 'No especificado' }}</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Programa</label>
                                            <p class="text-gray-700">{{ $m->program_name ?: 'No especificado' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Ficha</label>
                                            <p class="text-gray-700">{{ $m->batch_number ?: 'No especificado' }}</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                                            <p class="text-gray-700">{{ $m->email ?: 'No especificado' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Contrato</label>
                                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $m->has_contract ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $m->has_contract ? 'Sí' : 'No' }}</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Tipo Novedad</label>
                                            <span class="inline-block bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                                @php
                                                    $incidentTypeMap = [
                                                        'Academic' => 'Académica',
                                                        'Disciplinary' => 'Disciplinaria', 
                                                        'Other' => 'Otra'
                                                    ];
                                                    $translatedType = $incidentTypeMap[$m->incident_type] ?? $m->incident_type;
                                                @endphp
                                                {{ $translatedType ?: 'No especificado' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Información de la Empresa (solo si tiene contrato) -->
                                    @if($m->has_contract)
                                        <div class="border-t pt-4 mt-4">
                                            <h6 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                <i class="fas fa-building mr-2 text-green-500"></i>
                                                Información de la Empresa
                                            </h6>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Empresa</label>
                                                    <p class="text-sm text-gray-700">{{ $m->company_name ?: 'No especificado' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Dirección</label>
                                                    <p class="text-sm text-gray-700">{{ $m->company_address ?: 'No especificado' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Responsable RH</label>
                                                    <p class="text-sm text-gray-700">{{ $m->hr_manager_name ?: 'No especificado' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Contacto Empresa</label>
                                                    <p class="text-sm text-gray-700">{{ $m->company_contact ?: 'No especificado' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No se encontraron aprendices para el acta #{{ $generalCommittee->act_number }}.</p>
                @endif
            </div>
        </div>

        <!-- Configuración del Comité -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-green-100 text-green-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-layer-group mr-2"></i>
                    Configuración del Comité
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="attendance_mode" class="block text-sm font-semibold text-gray-700 mb-2">
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
                    <div>
                        <label for="offense_class" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-exclamation-triangle mr-1 text-green-500"></i>
                            Tipo de Falta
                        </label>
                        <select name="offense_class" id="offense_class" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="Leve" {{ old('offense_class', $generalCommittee->offense_class) == 'Leve' ? 'selected' : '' }}>Leve</option>
                            <option value="Grave" {{ old('offense_class', $generalCommittee->offense_class) == 'Grave' ? 'selected' : '' }}>Grave</option>
                            <option value="Gravísimo" {{ old('offense_class', $generalCommittee->offense_class) == 'Gravísimo' ? 'selected' : '' }}>Gravísimo</option>
                        </select>
                        @error('offense_class')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de la Novedad -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-yellow-100 text-yellow-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Información de la Novedad
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="incident_type" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-yellow-500"></i>
                            Tipo de Novedad
                        </label>
                        <select name="incident_type" id="incident_type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">Seleccionar tipo</option>
                            <option value="Academic" {{ old('incident_type', $generalCommittee->incident_type) == 'Academic' ? 'selected' : '' }}>Académica</option>
                            <option value="Disciplinary" {{ old('incident_type', $generalCommittee->incident_type) == 'Disciplinary' ? 'selected' : '' }}>Disciplinaria</option>
                            <option value="Desertion" {{ old('incident_type', $generalCommittee->incident_type) == 'Desertion' ? 'selected' : '' }}>Deserción</option>
                        </select>
                        @error('incident_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label for="offense_classification" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-1 text-yellow-500"></i>
                        Descripción de la Falta
                    </label>
                    <textarea name="offense_classification" id="offense_classification" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('offense_classification', $generalCommittee->offense_classification) }}</textarea>
                    @error('offense_classification')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="incident_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-1 text-yellow-500"></i>
                        Descripción de la Novedad
                    </label>
                    <textarea name="incident_description" id="incident_description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('incident_description', $generalCommittee->incident_description) }}</textarea>
                    @error('incident_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        

        <!-- Descargos -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-green-100 text-green-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-comments mr-2"></i>
                    Descargos
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="flex gap-3 mb-4">
                    <button type="button" id="editGeneralDescargoBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Descargo General</button>
                    <button type="button" id="editIndividualDescargoBtn" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Descargos Individuales</button>
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
                    <label for="general_statements" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-users mr-1 text-green-500"></i>
                        Descargo General
                    </label>
                    <textarea name="general_statements" id="general_statements" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500" {{ $hasIndividual ? 'disabled' : '' }}>{{ old('general_statements', $generalCommittee->general_statements) }}</textarea>
                    @error('general_statements')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div id="editIndividualStatementsSection" class="mt-4" style="{{ $hasIndividual ? '' : 'display:none;' }}">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
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
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-yellow-100 text-yellow-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-gavel mr-2"></i>
                    Decisión y Compromisos
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="decision" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-balance-scale mr-1 text-yellow-500"></i>
                            Decisión
                        </label>
                        <textarea name="decision" id="decision" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('decision', $generalCommittee->decision) }}</textarea>
                        @error('decision')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="commitments" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-handshake mr-1 text-yellow-500"></i>
                            Compromisos
                        </label>
                        <textarea name="commitments" id="commitments" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('commitments', $generalCommittee->commitments) }}</textarea>
                        @error('commitments')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-blue-100 text-blue-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Información Adicional
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="missing_rating" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-star mr-1 text-blue-500"></i>
                            Calificación Faltante
                        </label>
                        <textarea name="missing_rating" id="missing_rating" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('missing_rating', $generalCommittee->missing_rating) }}</textarea>
                        @error('missing_rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="recommendations" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lightbulb mr-1 text-blue-500"></i>
                            Recomendaciones
                        </label>
                        <textarea name="recommendations" id="recommendations" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('recommendations', $generalCommittee->recommendations) }}</textarea>
                        @error('recommendations')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="observations" class="block text-sm font-semibold text-gray-700 mb-2">
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
        </div>

        <!-- Botones de Acción -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
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
});
</script>
@endsection