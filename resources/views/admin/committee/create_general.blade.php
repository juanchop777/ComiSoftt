@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Crear Comité General</h1>
      <p class="mt-2 text-gray-600">Registra un nuevo comité disciplinario general</p>
    </div>

    @if(session('success'))
      <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
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

    <form action="{{ route('committee.general.store') }}" method="POST" class="space-y-8">
      @csrf
      <input type="hidden" name="committee_mode" value="General">

      <!-- Información de la Sesión -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
          </div>
          <h3 class="ml-3 text-xl font-semibold text-gray-900">Información de la Sesión</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Sesión</label>
            <input type="date" name="session_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Hora Sesión</label>
            <input type="time" name="session_time" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Enlace (opcional)</label>
            <input type="text" name="access_link" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="https://...">
          </div>
        </div>
      </div>

      <!-- Información del Acta -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <i class="fas fa-file-alt text-green-600 text-xl"></i>
          </div>
          <h3 class="ml-3 text-xl font-semibold text-gray-900">Información del Acta</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Acta</label>
            <select name="act_number" id="act_select" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
              <option value="">Seleccionar acta...</option>
              @php $acts = $minutes->groupBy('act_number'); @endphp
              @foreach($acts as $actNumber => $items)
                <option value="{{ $actNumber }}">Acta #{{ $actNumber }} ({{ $items->count() }} aprendices)</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Acta</label>
            <input type="date" name="minutes_date" id="minutes_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
          </div>
        </div>
      </div>

      <!-- Información Detallada del Acta (se muestra solo cuando se selecciona un acta) -->
      <div id="detailed_act_info" class="hidden">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
          <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
              <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            </div>
            <h3 class="ml-3 text-xl font-semibold text-gray-900">Información Detallada del Acta</h3>
          </div>

          <!-- Persona que Reporta -->
          <div id="reporting_person_info" class="mb-8">
            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <i class="fas fa-user text-blue-600 mr-3"></i>
              Persona que Reporta
            </h4>
            <div id="reporting_person_content" class="bg-blue-50 rounded-lg p-4">
              <!-- Se llena dinámicamente -->
            </div>
          </div>

          <!-- Aprendices en esta Acta -->
          <div id="apprentices_info">
            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <i class="fas fa-users text-green-600 mr-3"></i>
              Aprendices en esta Acta
            </h4>
            <div id="apprentices_content">
              <!-- Se llena dinámicamente -->
            </div>
          </div>

          <!-- Botón para expandir el resto del formulario -->
          <div class="mt-6 flex justify-end">
            <button id="show_rest_btn" type="button" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-lg">
              <i class="fas fa-edit mr-2"></i>Crear Comité General
            </button>
          </div>
        </div>
      </div>

      <!-- Resto del formulario: oculto hasta que se haga clic en "Crear Comité General" -->
      <div id="rest_of_form" class="hidden">
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <i class="fas fa-layer-group text-blue-600 text-xl"></i>
          </div>
          <h3 class="ml-3 text-xl font-semibold text-gray-900">Configuración del Comité</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Modalidad</label>
            <select name="attendance_mode" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
              <option value="Presencial">Seleccione..</option> 
              <option value="Presencial">Presencial</option>
              <option value="Virtual">Virtual</option>
              <option value="No asistió">No asistió</option>
            </select>
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
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Falta</label>
            <select name="offense_class" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
              <option value="Leve">Seleccione...</option>
              <option value="Leve">Leve</option>
              <option value="Grave">Grave</option>
              <option value="Gravísimo">Gravísimo</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Novedad</label>
            <input type="text" name="incident_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
          </div>
        </div>

        <div class="mt-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Descripción de la Falta</label>
          <textarea name="offense_classification" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"></textarea>
        </div>

        <div class="mt-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Descripción de la Novedad</label>
          <textarea name="incident_description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"></textarea>
        </div>
      </div>

      

      <!-- Descargos Generales -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <i class="fas fa-comments text-purple-600 text-xl"></i>
          </div>
          <h3 class="ml-3 text-xl font-semibold text-gray-900">Descargos Generales</h3>
        </div>
        
        <!-- Botones para alternar entre descargo general e individual -->
        <div class="flex gap-4 mb-6">
          <button type="button" id="generalDescargoBtn" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-lg">
            <i class="fas fa-users mr-2"></i>Descargo General
          </button>
          <button type="button" id="individualDescargoBtn" class="px-6 py-3 bg-gray-600 text-white rounded-lg font-medium hover:bg-gray-700 transition-colors shadow-lg">
            <i class="fas fa-user mr-2"></i>Descargos Individuales
          </button>
        </div>

        <!-- Descargo General -->
        <div id="generalStatementsSection">
          <label class="block text-sm font-medium text-gray-700 mb-2">Descargo General</label>
          <textarea name="general_statements" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba aquí el descargo general para todos los aprendices..."></textarea>
        </div>

        <!-- Sección de descargos individuales (oculta por defecto) -->
        <div id="individualStatementsSection" class="hidden">
          <h4 class="text-lg font-semibold text-gray-800 mb-4">Descargos Individuales por Aprendiz</h4>
          <div id="individualStatementsContainer">
            <div class="text-center py-8 text-gray-500">
              <i class="fas fa-info-circle text-2xl mb-2"></i>
              <p>Selecciona una acta para cargar los aprendices</p>
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
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Decisión</label>
            <textarea name="decision" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba aquí la decisión del comité..."></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Compromisos</label>
            <textarea name="commitments" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba aquí los compromisos acordados..."></textarea>
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
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Calificación Faltante</label>
            <textarea name="missing_rating" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Especifique las calificaciones faltantes..."></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Recomendaciones</label>
            <textarea name="recommendations" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba las recomendaciones..."></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
            <textarea name="observations" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba observaciones adicionales..."></textarea>
          </div>
        </div>
      </div>

      <!-- Botones de Acción -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex justify-end gap-4">
          <a href="{{ route('committee.general.index') }}" class="px-8 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
            <i class="fas fa-times mr-2"></i>Cancelar
          </a>
          <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-lg">
            <i class="fas fa-save mr-2"></i>Guardar Comité
          </button>
        </div>
      </div>
      </div> <!-- /#rest_of_form -->
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript cargado correctamente');
    
    // Elementos del DOM
    const actSelect = document.getElementById('act_select');
    const minutesDateInput = document.getElementById('minutes_date');
    const sessionDateInput = document.querySelector('input[name="session_date"]');
    const sessionTimeInput = document.querySelector('input[name="session_time"]');
    const detailedActInfo = document.getElementById('detailed_act_info');
    const restOfForm = document.getElementById('rest_of_form');
    const showRestBtn = document.getElementById('show_rest_btn');
    const reportingPersonContent = document.getElementById('reporting_person_content');
    const apprenticesContent = document.getElementById('apprentices_content');

    // Descargos toggles
    const generalDescargoBtn = document.getElementById('generalDescargoBtn');
    const individualDescargoBtn = document.getElementById('individualDescargoBtn');
    const generalStatementsSection = document.getElementById('generalStatementsSection');
    const individualStatementsSection = document.getElementById('individualStatementsSection');
    const individualStatementsContainer = document.getElementById('individualStatementsContainer');

    // Estado
    let selectedMinutesForAct = [];
    
    console.log('Elementos encontrados:', {
        actSelect: !!actSelect,
        minutesDateInput: !!minutesDateInput,
        detailedActInfo: !!detailedActInfo
    });
    
    // Event listener para cambio de acta
    if (actSelect) {
        actSelect.addEventListener('change', function() {
            console.log('Acta seleccionada:', this.value);
            if (this.value) {
                loadSelectedActData(this.value);
                if (detailedActInfo) {
                    detailedActInfo.classList.remove('hidden');
                }
            } else {
                clearFormData();
                if (detailedActInfo) {
                    detailedActInfo.classList.add('hidden');
                }
                if (restOfForm) {
                    restOfForm.classList.add('hidden');
                }
                // limpiar descargos
                if (individualStatementsContainer) individualStatementsContainer.innerHTML = '';
                if (generalStatementsSection) generalStatementsSection.classList.remove('hidden');
                if (individualStatementsSection) individualStatementsSection.classList.add('hidden');
            }
        });
    }

    // Mostrar el resto del formulario al pulsar "Crear Comité General"
    if (showRestBtn) {
        showRestBtn.addEventListener('click', function() {
            if (restOfForm) {
                restOfForm.classList.remove('hidden');
                // desplazamiento suave al inicio del resto del formulario
                restOfForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }
    
    function translateIncidentType(value) {
        if (!value) return 'No especificado';
        const map = {
            'Academic': 'Académica',
            'Disciplinary': 'Disciplinaria',
            'Other': 'Otra'
        };
        return map[value] || value;
    }

    function loadSelectedActData(actNumber) {
        console.log('Cargando datos para acta:', actNumber);
        
        // Obtener datos de las actas
        const minutes = @json($minutes);
        console.log('Datos de actas:', minutes);
        
        const selectedMinutes = minutes.filter(m => m.act_number == actNumber);
        console.log('Actas filtradas:', selectedMinutes);
        
        if (selectedMinutes.length > 0) {
            const firstMinute = selectedMinutes[0];
            console.log('Primera acta:', firstMinute);
            
            // Llenar campos automáticamente
            if (firstMinute.minutes_date && minutesDateInput) {
                const date = new Date(firstMinute.minutes_date);
                minutesDateInput.value = date.toISOString().split('T')[0];
            }
            
            if (sessionDateInput) {
                const today = new Date();
                sessionDateInput.value = today.toISOString().split('T')[0];
            }
            
            if (sessionTimeInput) {
                const now = new Date();
                sessionTimeInput.value = now.toTimeString().slice(0, 5);
            }
            
            // Autocompletar Tipo de Novedad con la del primer aprendiz
            const incidentTypeInput = document.querySelector('input[name="incident_type"]');
            if (incidentTypeInput) {
                incidentTypeInput.value = translateIncidentType(firstMinute.incident_type);
            }

            // Autocompletar Descripción de la Novedad con la del primer aprendiz
            const incidentDescriptionInput = document.querySelector('textarea[name="incident_description"]');
            if (incidentDescriptionInput) {
                incidentDescriptionInput.value = firstMinute.incident_description || '';
            }

            // Mostrar información
            showReportingPersonInfo(firstMinute);
            showApprenticesInfo(selectedMinutes);
            selectedMinutesForAct = selectedMinutes;
        }
    }
    
    function showReportingPersonInfo(minute) {
        if (!reportingPersonContent) return;
        
        console.log('Mostrando info de persona que reporta:', minute);
        
        // Acceder a los datos de la persona que reporta desde la relación
        const reportingPerson = minute.reporting_person || {};
        
        reportingPersonContent.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <p class="text-gray-900 font-medium">${reportingPerson.full_name || 'No especificado'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <p class="text-gray-900 font-medium">${reportingPerson.email || 'No especificado'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <p class="text-gray-900 font-medium">${reportingPerson.phone || 'No especificado'}</p>
                </div>
            </div>
        `;
    }
    
    function showApprenticesInfo(minutes) {
        if (!apprenticesContent) return;
        
        console.log('Mostrando info de aprendices:', minutes);
        
        const apprenticesHtml = minutes.map((minute, index) => `
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="bg-green-600 text-white px-4 py-3 rounded-t-lg">
                    <h5 class="font-semibold">Aprendiz #${index + 1}</h5>
                </div>
                <div class="p-4">
                    <!-- Información del Aprendiz -->
                    <div class="mb-4">
                        <h6 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            Información del Aprendiz
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 font-medium">Nombre:</span>
                                <p class="text-gray-900">${minute.trainee_name || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Documento:</span>
                                <p class="text-gray-900">${minute.id_document || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Email:</span>
                                <p class="text-gray-900">${minute.email || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Programa:</span>
                                <p class="text-gray-900">${minute.program_name || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Ficha:</span>
                                <p class="text-gray-900">${minute.batch_number || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Contrato:</span>
                                <p class="text-gray-900">${minute.has_contract ? 'Sí' : 'No'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Tipo Novedad:</span>
                                <span class="inline-block bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                    ${translateIncidentType(minute.incident_type)}
                                </span>
                            </div>
                            <div class="md:col-span-2 lg:col-span-3">
                                <span class="text-gray-600 font-medium">Descripción:</span>
                                <p class="text-gray-900">${minute.incident_description || 'No especificado'}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de la Empresa (solo si tiene contrato) -->
                    ${minute.has_contract ? `
                    <div class="border-t pt-4">
                        <h6 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-building mr-2 text-green-500"></i>
                            Información de la Empresa
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 font-medium">Empresa:</span>
                                <p class="text-gray-900">${minute.company_name || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Dirección:</span>
                                <p class="text-gray-900">${minute.company_address || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Responsable RH:</span>
                                <p class="text-gray-900">${minute.hr_manager_name || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">Contacto Empresa:</span>
                                <p class="text-gray-900">${minute.company_contact || 'No especificado'}</p>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                </div>
            </div>
        `).join('');
        
        apprenticesContent.innerHTML = apprenticesHtml;
    }
    
    function clearFormData() {
        if (minutesDateInput) minutesDateInput.value = '';
        if (reportingPersonContent) reportingPersonContent.innerHTML = '';
        if (apprenticesContent) apprenticesContent.innerHTML = '';
    }

    // Toggle a descargos generales
    if (generalDescargoBtn && individualDescargoBtn) {
        generalDescargoBtn.addEventListener('click', function() {
            if (generalStatementsSection) generalStatementsSection.classList.remove('hidden');
            if (individualStatementsSection) individualStatementsSection.classList.add('hidden');
            generalDescargoBtn.classList.remove('bg-gray-600');
            generalDescargoBtn.classList.add('bg-blue-600');
            individualDescargoBtn.classList.remove('bg-blue-600');
            individualDescargoBtn.classList.add('bg-gray-600');
        });

        individualDescargoBtn.addEventListener('click', function() {
            if (!selectedMinutesForAct || selectedMinutesForAct.length === 0) {
                alert('Primero selecciona un acta para cargar los aprendices.');
                return;
            }
            // Construir campos para cada aprendiz
            if (individualStatementsContainer) {
                const html = selectedMinutesForAct.map((m, idx) => `
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descargo de ${m.trainee_name || 'Aprendiz ' + (idx+1)}</label>
                        <textarea name="individual_statements[${m.minutes_id}]" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba el descargo..."></textarea>
                    </div>
                `).join('');
                individualStatementsContainer.innerHTML = html;
            }
            if (generalStatementsSection) generalStatementsSection.classList.add('hidden');
            if (individualStatementsSection) individualStatementsSection.classList.remove('hidden');
            // toggle estilos de botones
            generalDescargoBtn.classList.remove('bg-blue-600');
            generalDescargoBtn.classList.add('bg-gray-600');
            individualDescargoBtn.classList.remove('bg-gray-600');
            individualDescargoBtn.classList.add('bg-blue-600');
        });
    }
});
</script>
@endsection