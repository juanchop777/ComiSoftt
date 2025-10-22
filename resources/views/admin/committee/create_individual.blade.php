@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Crear Comité Individual</h1>
      <p class="mt-2 text-gray-600">Registra un nuevo comité disciplinario individual</p>
    </div>

    @if(session('success'))
      <div class="alert alert-accent mb-6">
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

    <form action="{{ route('committee.individual.store') }}" method="POST" class="space-y-8">
      @csrf
      <input type="hidden" name="committee_mode" value="Individual">
      <input type="hidden" name="minutes_id" id="minutes_id_input" value="">

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

      @if($continue && $pendingInfo && $pendingInfo->count() > 0)
      <!-- Información de Aprendices Pendientes -->
      <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
        <div class="flex items-center mb-4">
          <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3"></i>
          <h3 class="text-lg font-semibold text-yellow-800">Aprendices Pendientes de Comité</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          @foreach($pendingInfo as $actNumber => $actData)
            <div class="bg-white rounded-lg p-4 border border-yellow-200 cursor-pointer hover:shadow-lg transition-all duration-200 hover:border-blue-300" 
                 onclick="selectActFromPending({{ $actNumber }})">
              <div class="flex items-center justify-between mb-2">
                <h4 class="font-semibold text-gray-800">Acta #{{ $actNumber }}</h4>
                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                  {{ $actData['progress_percentage'] }}% completado
                </span>
              </div>
              
              <div class="mb-3">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                  <span>Progreso:</span>
                  <span>{{ $actData['completed_count'] }}/{{ $actData['total_apprentices'] }} aprendices</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $actData['progress_percentage'] }}%"></div>
                </div>
              </div>
              
              <p class="text-sm text-gray-600 mb-2">{{ $actData['pending_count'] }} aprendiz(es) pendiente(s)</p>
              <div class="space-y-1">
                @foreach($actData['minutes'] as $minute)
                  <div class="text-sm text-gray-700 flex items-center">
                    <i class="fas fa-user text-blue-500 mr-2"></i>
                    <span>{{ $minute->trainee_name }}</span>
                    @if($actData['completed_count'] > 0)
                      <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Pendiente</span>
                    @endif
                  </div>
                @endforeach
              </div>
              
              <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="flex items-center justify-center text-blue-600 text-sm font-medium">
                  <i class="fas fa-mouse-pointer mr-2"></i>
                  Haz clic para continuar
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
          <p class="text-sm text-blue-800">
            <i class="fas fa-info-circle mr-2"></i>
            Selecciona una acta para continuar creando comités para los aprendices pendientes.
          </p>
        </div>
      </div>
      @endif

      @if($minutes->count() == 0)
      <!-- No hay actas pendientes -->
      <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6">
        <div class="flex items-center mb-4">
          <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
          <h3 class="text-lg font-semibold text-green-800">¡Excelente Trabajo!</h3>
        </div>
        <div class="bg-white rounded-lg p-4 border border-green-200">
          <p class="text-gray-700 mb-2">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
            No hay actas pendientes de comité. Todos los aprendices ya tienen sus comités registrados.
          </p>
          <p class="text-sm text-gray-600">
            Si necesitas crear un nuevo comité, primero debes registrar una nueva acta en el sistema.
          </p>
        </div>
        <div class="mt-4 flex gap-2">
          <a href="{{ route('minutes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Crear Nueva Acta
          </a>
          <a href="{{ route('committee.individual.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors">
            <i class="fas fa-list mr-2"></i>Ver Comités Registrados
          </a>
        </div>
      </div>
      @endif

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
              <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                  <i class="fas fa-users text-green-600 mr-3"></i>
                  Aprendices en esta Acta
                </h4>
                <button type="button" onclick="clearCurrentActDataAndRefresh()" class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition-colors">
                  <i class="fas fa-trash mr-1"></i>Limpiar Datos
                </button>
              </div>
              <div id="apprentices_content">
                <!-- Se llena dinámicamente -->
              </div>
            </div>
        </div>
      </div>

      <!-- Formulario del Comité (se muestra solo cuando se hace clic en "Crear Comité") -->
      <div id="committee_form" class="hidden">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
          <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
              <i class="fas fa-gavel text-blue-600 text-xl"></i>
            </div>
            <h3 class="ml-3 text-xl font-semibold text-gray-900">Información del Comité</h3>
          </div>
          
            <div class="mb-6">
              <div>
                <h4 class="text-lg font-semibold text-gray-800" id="selected_apprentice_name">Selecciona un aprendiz</h4>
                <p class="text-sm text-gray-600">Completa la información del comité</p>
              </div>
            </div>
          
          <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Asistencia</label>
              <select name="attendance_mode" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <option value="Presencial">Presencial</option>
                <option value="Virtual">Virtual</option>
                <option value="No asistió">No asistió</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Resto del formulario (se muestra solo cuando se hace clic en "Crear Comité") -->
      <div id="rest_of_form" style="display: none;">
      <!-- Información de la Novedad -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
          </div>
          <h3 class="ml-3 text-xl font-semibold text-gray-900">Información de la Novedad</h3>
        </div>
        
        <div class="grid grid-cols-1 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Novedad</label>
            <input type="text" name="incident_type" id="incident_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm">
          </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mt-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Subtipo de Novedad</label>
            <input type="text" name="incident_subtype" id="incident_subtype" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm">
          </div>
        </div>

        <div class="mt-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Descripción de la Novedad</label>
          <textarea name="incident_description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"></textarea>
        </div>
        
        <!-- Información de la Falta -->
        <div class="mt-8">
          <div class="border-t border-gray-200 pt-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
              Información de la Falta
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Falta</label>
                <select name="offense_class" id="offense_class_select" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                  <option value="">Seleccione...</option>
                  <option value="Leve">Leve</option>
                  <option value="Grave">Grave</option>
                  <option value="Gravísimo">Gravísimo</option>
                </select>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción de la Falta</label>
                <textarea name="offense_classification" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors resize-none" placeholder="Describa la falta cometida..."></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Información de la Empresa (solo se muestra si el aprendiz tiene contrato) -->
      <div id="company_info_section" class="bg-white rounded-xl shadow-lg border border-gray-200 p-8" style="display: none;">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <i class="fas fa-building text-blue-600 text-xl"></i>
          </div>
          <h3 class="ml-3 text-xl font-semibold text-gray-900">Información de la Empresa</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Empresa</label>
            <input type="text" name="company_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección de la Empresa</label>
            <input type="text" name="company_address" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Contacto de la Empresa</label>
            <input type="text" name="company_contact" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Responsable de RRHH</label>
            <input type="text" name="hr_responsible" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
          </div>
        </div>
      </div>

      <!-- Descargos del Aprendiz -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <i class="fas fa-comments text-purple-600 text-xl"></i>
          </div>
          <h3 class="ml-3 text-xl font-semibold text-gray-900">Descargos del Aprendiz</h3>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Descargos del Aprendiz</label>
          <textarea name="statement" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba aquí los descargos del aprendiz..."></textarea>
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
            <label class="block text-sm font-medium text-gray-700 mb-2">Compromisos</label>
            <textarea name="commitments" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba aquí los compromisos acordados..."></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Decisión</label>
            <textarea name="decision" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Escriba aquí la decisión del comité..."></textarea>
          </div>
        </div>
      </div>

      </div> <!-- Cierre del div rest_of_form -->

      <!-- Botones de Acción -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex justify-center gap-4">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-2"></i>Guardar Comité
          </button>
          <a href="{{ route('committee.individual.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
            <i class="fas fa-times mr-2"></i>Cancelar
          </a>
        </div>
      </div>

      <!-- Botones de Acción -->
    </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript cargado correctamente - Individual');
    
    // Limpiar todos los datos guardados al cargar la página
    clearAllSavedData();
    
    // Elementos del DOM
    const actSelect = document.getElementById('act_select');
    const minutesDateInput = document.getElementById('minutes_date');
    const sessionDateInput = document.querySelector('input[name="session_date"]');
    const sessionTimeInput = document.querySelector('input[name="session_time"]');
    const detailedActInfo = document.getElementById('detailed_act_info');
    const committeeForm = document.getElementById('committee_form');
    const reportingPersonContent = document.getElementById('reporting_person_content');
    const apprenticesContent = document.getElementById('apprentices_content');
    
    // Helper: traducir tipo de novedad al español
    function translateIncidentType(type) {
        if (!type) return 'No especificado';
        const types = {
            'CANCELACION_MATRICULA_ACADEMICO': 'CANCELACIÓN MATRÍCULA ÍNDOLE ACADÉMICO',
            'CANCELACION_MATRICULA_DISCIPLINARIO': 'CANCELACIÓN MATRÍCULA ÍNDOLE DISCIPLINARIO',
            'CONDICIONAMIENTO_MATRICULA': 'CONDICIONAMIENTO DE MATRÍCULA',
            'DESERCION_PROCESO_FORMACION': 'DESERCIÓN PROCESO DE FORMACIÓN',
            'NO_GENERACION_CERTIFICADO': 'NO GENERACIÓN-CERTIFICADO',
            'RETIRO_POR_FRAUDE': 'RETIRO POR FRAUDE',
            'RETIRO_PROCESO_FORMACION': 'RETIRO PROCESO DE FORMACIÓN',
            'TRASLADO_CENTRO': 'TRASLADO DE CENTRO',
            'TRASLADO_JORNADA': 'TRASLADO DE JORNADA',
            'TRASLADO_PROGRAMA': 'TRASLADO DE PROGRAMA',
            // Mantener compatibilidad con tipos antiguos
            'Academic': 'Académica',
            'Disciplinary': 'Disciplinaria',
            'Dropout': 'Deserción'
        };
        return types[type] || type;
    }

    // Variable global para mantener la acta seleccionada
    let currentActNumber = null;
    
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
            }
        });
    }
    
    function loadSelectedActData(actNumber) {
        console.log('Cargando datos para acta:', actNumber);
        
        // Guardar la acta seleccionada globalmente
        currentActNumber = actNumber;
        
        // Obtener datos de las actas (todos los minutes para el JavaScript)
        const minutes = @json($allMinutes);
        console.log('Datos de actas disponibles:', minutes);
        
        const selectedMinutes = minutes.filter(m => m.act_number == actNumber);
        console.log('Actas seleccionadas:', selectedMinutes);
        
        if (selectedMinutes.length > 0) {
            const firstMinute = selectedMinutes[0];
            
            // Llenar automáticamente los campos básicos
            if (firstMinute.minutes_date && minutesDateInput) {
                const date = new Date(firstMinute.minutes_date);
                minutesDateInput.value = date.toISOString().split('T')[0];
            }
            
            // Establecer fecha de sesión como hoy
            const today = new Date();
            sessionDateInput.value = today.toISOString().split('T')[0];
            
            // Establecer hora de sesión como ahora
            const now = new Date();
            sessionTimeInput.value = now.toTimeString().slice(0, 5);
            
            // Mostrar información de la persona que reporta
            showReportingPersonInfo(firstMinute);
            
            // Mostrar información de todos los aprendices de esta acta
            showApprenticesInfo(selectedMinutes);
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
        
        // Obtener la lista de minutes que ya tienen comité desde el servidor
        const minutesWithCommittee = @json($minutesWithCommittee);
        console.log('Minutes con comité desde servidor:', minutesWithCommittee);
        
        // Filtrar aprendices que no tienen comité (solo mostrar los pendientes)
        const pendingMinutes = minutes.filter(minute => {
            // Verificar si ya tiene comité en la base de datos
            const hasCommitteeInDB = minutesWithCommittee.includes(minute.minutes_id);
            console.log(`Aprendiz ${minute.trainee_name} (ID: ${minute.minutes_id}):`, {
                hasCommitteeInDB,
                minutesWithCommittee: minutesWithCommittee.includes(minute.minutes_id)
            });
            
            if (hasCommitteeInDB) {
                return false; // No incluir si ya tiene comité en la base de datos
            }
            
            // También verificar localStorage para datos en progreso
            const savedData = localStorage.getItem(`committee_data_${minute.minutes_id}`);
            if (savedData && savedData !== '{}' && savedData !== 'null' && savedData !== '""') {
                try {
                    const data = JSON.parse(savedData);
                    // Verificar si tiene datos reales de comité
                    const hasRealData = data.session_date || data.attendance_mode || data.offense_class || data.statement;
                    return !hasRealData; // Solo incluir si NO tiene datos reales
                } catch (e) {
                    return true; // Si hay error parseando, incluir
                }
            }
            return true; // Si no hay datos guardados, incluir
        });
        
        console.log('Aprendices pendientes:', pendingMinutes.length);
        console.log('Total aprendices:', minutes.length);
        
        if (pendingMinutes.length === 0) {
            apprenticesContent.innerHTML = `
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                    <i class="fas fa-check-circle text-green-600 text-3xl mb-3"></i>
                    <h3 class="text-lg font-semibold text-green-800 mb-2">¡Todos los aprendices procesados!</h3>
                    <p class="text-green-700">Todos los aprendices de esta acta ya tienen sus comités registrados.</p>
                </div>
            `;
            return;
        }
        
        const apprenticesHtml = pendingMinutes.map((minute, index) => {
            // Verificar si hay datos guardados para este aprendiz
            const savedData = localStorage.getItem(`committee_data_${minute.minutes_id}`);
            console.log(`Verificando datos para aprendiz ${minute.minutes_id}:`, savedData);
            
            const hasSavedData = savedData !== null && savedData !== '{}' && savedData !== 'null' && savedData !== '""';
            
            // Verificar si los datos guardados tienen contenido real
            let hasRealData = false;
            if (hasSavedData) {
                try {
                    const data = JSON.parse(savedData);
                    console.log(`Datos parseados para aprendiz ${minute.minutes_id}:`, data);
                    hasRealData = Object.values(data).some(value => value && value.toString().trim() !== '');
                    console.log(`¿Tiene datos reales el aprendiz ${minute.minutes_id}?`, hasRealData);
                } catch (e) {
                    console.log(`Error parseando datos para aprendiz ${minute.minutes_id}:`, e);
                    hasRealData = false;
                }
            }
            
            const statusIcon = hasRealData ? 'fas fa-check-circle' : 'fas fa-clock';
            const statusColor = hasRealData ? 'text-green-400' : 'text-yellow-400';
            const statusText = hasRealData ? 'En progreso' : 'Pendiente';
            
            return `
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="bg-green-600 text-white px-4 py-3 rounded-t-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <h5 class="font-semibold mr-3">Aprendiz #${index + 1}</h5>
                        <div class="flex items-center text-sm">
                            <i class="${statusIcon} ${statusColor} mr-1"></i>
                            <span class="text-xs">${statusText}</span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button type="button" onclick="selectApprentice(${minute.minutes_id})" class="bg-white text-green-600 px-3 py-1 rounded text-sm font-medium hover:bg-green-50 transition-colors">
                            <i class="fas fa-edit mr-1"></i>${hasRealData ? 'Continuar' : 'Crear Comité'}
                        </button>
                        <button type="button" onclick="viewApprentice(${minute.minutes_id})" class="bg-white text-green-600 px-3 py-1 rounded text-sm font-medium hover:bg-green-50 transition-colors">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600 font-medium">Nombre:</span>
                            <p class="text-gray-900">${minute.trainee_name || 'No especificado'}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Tipo de Documento:</span>
                            <p class="text-gray-900">${minute.document_type || 'No especificado'}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Número de Documento:</span>
                            <p class="text-gray-900">${minute.id_document || 'No especificado'}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Teléfono del Aprendiz:</span>
                            <p class="text-gray-900">${minute.trainee_phone || 'No especificado'}</p>
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
                            <span class="text-gray-600 font-medium">Tipo de Programa:</span>
                            <p class="text-gray-900">${minute.program_type || 'No especificado'}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Estado del Aprendiz:</span>
                            <p class="text-gray-900">${minute.trainee_status || 'No especificado'}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Centro de Formación:</span>
                            <p class="text-gray-900">${minute.training_center || 'No especificado'}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Contrato:</span>
                            <p class="text-gray-900">${minute.has_contract ? 'Sí' : 'No'}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Tipo Novedad:</span>
                            <span class="inline-block bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                ${translateIncidentType(minute.incident_type || 'Academic')}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Subtipo de Novedad:</span>
                            <p class="text-gray-900">${(minute.incident_subtype || 'No especificado').replace(/_/g, ' ')}</p>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div>
                            <span class="text-gray-600 font-medium">Email:</span>
                            <p class="text-gray-900">${minute.email || 'No especificado'}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 font-medium">Descripción:</span>
                            <p class="text-gray-900">${minute.incident_description || 'No especificado'}</p>
                        </div>
                    </div>
                    ${minute.has_contract ? `
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <h6 class="font-semibold text-blue-800 mb-3 flex items-center">
                            <i class="fas fa-building mr-2"></i>Información de la Empresa
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-blue-600 font-medium">Empresa:</span>
                                <p class="text-gray-900">${minute.company_name || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-blue-600 font-medium">Dirección:</span>
                                <p class="text-gray-900">${minute.company_address || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-blue-600 font-medium">Contacto de la Empresa:</span>
                                <p class="text-gray-900">${minute.company_contact || 'No especificado'}</p>
                            </div>
                            <div>
                                <span class="text-blue-600 font-medium">RRHH Responsable:</span>
                                <p class="text-gray-900">${minute.hr_manager_name || 'No especificado'}</p>
                            </div>
                            
                        </div>
                    </div>
                    ` : ''}
                </div>
            </div>
            `;
        }).join('');
        
        apprenticesContent.innerHTML = apprenticesHtml;
    }
    
    // Funciones globales para los botones
    // Función para guardar datos del formulario actual
    function saveCurrentFormData() {
        const formData = {};
        const form = document.querySelector('form');
        
        console.log('Iniciando guardado de datos...');
        
        // Buscar inputs en todo el formulario, incluyendo los que están en divs ocultos
        const inputs = form.querySelectorAll('input, textarea, select');
        console.log('Total de inputs encontrados:', inputs.length);
        
        // También buscar específicamente en el div rest_of_form
        const restOfForm = document.getElementById('rest_of_form');
        let restInputs = [];
        if (restOfForm) {
            restInputs = restOfForm.querySelectorAll('input, textarea, select');
            console.log('Inputs en rest_of_form:', restInputs.length);
        }
        
        // Combinar todos los inputs únicos
        const allInputs = [...new Set([...inputs, ...restInputs])];
        console.log('Total de inputs únicos:', allInputs.length);
        
        allInputs.forEach(input => {
            if (input.name && input.name !== 'minutes_id' && input.name !== '_token') {
                // Guardar TODOS los campos, incluso los vacíos, para mantener la estructura
                formData[input.name] = input.value || '';
                console.log(`Campo ${input.name}: "${input.value}"`);
            }
        });
        
        // Guardar en localStorage con el minutes_id actual
        const currentMinutesId = document.getElementById('minutes_id_input')?.value;
        console.log('Minutes ID actual:', currentMinutesId);
        
        if (currentMinutesId) {
            const dataToSave = JSON.stringify(formData);
            localStorage.setItem(`committee_data_${currentMinutesId}`, dataToSave);
            console.log('Datos guardados para aprendiz:', currentMinutesId);
            console.log('Datos guardados:', formData);
            console.log('JSON guardado:', dataToSave);
            
            // Verificar inmediatamente que se guardó
            const verification = localStorage.getItem(`committee_data_${currentMinutesId}`);
            console.log('Verificación de guardado:', verification);
        } else {
            console.error('No se encontró minutes_id para guardar datos');
        }
    }
    
    // Función para limpiar el formulario antes de cargar datos de otro aprendiz
    function clearFormBeforeLoad() {
        console.log('Limpiando formulario completamente...');
        
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea, select');
        
        console.log('Total de campos a limpiar:', inputs.length);
        
        // Limpiar TODOS los campos del formulario
        inputs.forEach(input => {
            if (input.name) {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                    console.log(`Checkbox/Radio ${input.name} limpiado`);
                } else {
                    input.value = '';
                    console.log(`Campo ${input.name} limpiado`);
                }
            }
        });
        
        // Limpiar también el campo minutes_id temporalmente
        const minutesIdInput = document.querySelector('input[name="minutes_id"]');
        if (minutesIdInput) {
            minutesIdInput.value = '';
        }
        
        // Limpiar también el nombre del aprendiz seleccionado
        const selectedApprenticeName = document.getElementById('selected_apprentice_name');
        if (selectedApprenticeName) {
            selectedApprenticeName.textContent = 'Selecciona un aprendiz';
        }
        
        console.log('Formulario limpiado completamente');
    }
    
    // Función para cargar datos del formulario
    function loadFormData(minutesId) {
        console.log('Intentando cargar datos para aprendiz:', minutesId);
        
        const savedData = localStorage.getItem(`committee_data_${minutesId}`);
        console.log('Datos encontrados en localStorage:', savedData);
        
        if (savedData && savedData !== '{}' && savedData !== 'null' && savedData !== '""' && savedData !== '""') {
            try {
                const formData = JSON.parse(savedData);
                console.log('Datos parseados para aprendiz:', minutesId, formData);
                
                // Verificar si hay datos reales
                const hasRealData = Object.values(formData).some(value => value && value.toString().trim() !== '');
                
                if (hasRealData) {
                    // Llenar solo los campos que tienen datos guardados
                    Object.keys(formData).forEach(fieldName => {
                        const input = document.querySelector(`[name="${fieldName}"]`);
                        if (input && formData[fieldName] && formData[fieldName].trim() !== '') {
                            input.value = formData[fieldName];
                            console.log(`Campo ${fieldName} cargado con valor: "${formData[fieldName]}"`);
                        }
                    });
                    console.log('Datos cargados exitosamente para aprendiz:', minutesId);
                } else {
                    console.log('No hay datos reales para cargar para aprendiz:', minutesId);
                }
            } catch (e) {
                console.log('Error al cargar datos para aprendiz:', minutesId, e);
            }
        } else {
            console.log('No hay datos guardados para aprendiz:', minutesId);
        }
    }
    
    // Función para limpiar el formulario
    function clearFormData() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            if (input.name && input.name !== 'minutes_id') {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                } else {
                    input.value = '';
                }
            }
        });
    }
    
    // Función para limpiar solo los campos del comité (NO los campos básicos)
    function clearAllFormData() {
        console.log('LIMPIANDO SOLO LOS CAMPOS DEL COMITÉ...');
        
        // Solo limpiar campos específicos del comité, NO los campos básicos
        const committeeFields = [
            'attendance_mode', 'offense_class', 'fault_type', 'incident_type', 
            'offense_classification', 'incident_description', 'company_name', 
            'company_address', 'company_contact', 'hr_responsible', 'statement', 
            'decision', 'commitments', 'missing_rating', 'recommendations', 'observations'
        ];
        
        committeeFields.forEach(fieldName => {
            const input = document.querySelector(`[name="${fieldName}"]`);
            if (input) {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                } else {
                    input.value = '';
                }
                console.log(`Campo del comité ${fieldName} limpiado`);
            }
        });
        
        // Limpiar el nombre del aprendiz seleccionado
        const selectedApprenticeName = document.getElementById('selected_apprentice_name');
        if (selectedApprenticeName) {
            selectedApprenticeName.textContent = 'Selecciona un aprendiz';
        }
        
        console.log('CAMPOS DEL COMITÉ LIMPIOS - CAMPOS BÁSICOS CONSERVADOS');
    }
    
    // Función para llenar automáticamente los datos de la empresa
    function fillCompanyData(minute) {
        console.log('Llenando datos de la empresa automáticamente:', minute);
        
        // Llenar campos de la empresa con los datos del aprendiz
        const companyNameField = document.querySelector('input[name="company_name"]');
        if (companyNameField && minute.company_name) {
            companyNameField.value = minute.company_name;
        }
        
        const companyAddressField = document.querySelector('input[name="company_address"]');
        if (companyAddressField && minute.company_address) {
            companyAddressField.value = minute.company_address;
        }
        
        const companyContactField = document.querySelector('input[name="company_contact"]');
        if (companyContactField && minute.company_contact) {
            companyContactField.value = minute.company_contact;
        }
        
        const hrManagerField = document.querySelector('input[name="hr_responsible"]');
        if (hrManagerField && minute.hr_manager_name) {
            hrManagerField.value = minute.hr_manager_name;
        }
        
        // También llenar otros campos relacionados con la novedad
        const incidentTypeField = document.querySelector('input[name="incident_type"]');
        if (incidentTypeField && minute.incident_type) {
            incidentTypeField.value = translateIncidentType(minute.incident_type);
        }
        
        const incidentSubtypeField = document.querySelector('input[name="incident_subtype"]');
        if (incidentSubtypeField && minute.incident_subtype) {
            incidentSubtypeField.value = minute.incident_subtype.replace(/_/g, ' ');
        }
        
        const incidentDescriptionField = document.querySelector('textarea[name="incident_description"]');
        if (incidentDescriptionField && minute.incident_description) {
            incidentDescriptionField.value = minute.incident_description;
        }
        

        console.log('Datos de la empresa llenados automáticamente');
    }

    window.selectApprentice = function(minutesId) {
        console.log('Seleccionando aprendiz:', minutesId);
        
        // LIMPIAR TODO COMPLETAMENTE
        clearAllFormData();
        
        // Obtener datos del aprendiz seleccionado
        const minutes = @json($allMinutes);
        const selectedMinute = minutes.find(m => m.minutes_id == minutesId);
        
        if (selectedMinute) {
            // Llenar el campo minutes_id oculto
            const minutesIdInput = document.getElementById('minutes_id_input');
            if (minutesIdInput) {
                minutesIdInput.value = minutesId;
                console.log('Minutes ID establecido:', minutesId);
            } else {
                console.error('No se encontró el campo minutes_id');
            }
            
            // Ocultar información detallada del acta
            if (detailedActInfo) {
                detailedActInfo.classList.add('hidden');
            }
            
            // Mostrar formulario del comité
            if (committeeForm) {
                committeeForm.classList.remove('hidden');
            }
            
            // Mostrar el resto del formulario
            const restOfForm = document.getElementById('rest_of_form');
            if (restOfForm) {
                restOfForm.style.display = 'block';
            }
            
            
            // Actualizar nombre del aprendiz seleccionado
            const selectedApprenticeName = document.getElementById('selected_apprentice_name');
            if (selectedApprenticeName) {
                selectedApprenticeName.textContent = `Comité para: ${selectedMinute.trainee_name}`;
            }
            
            // NO cargar datos guardados automáticamente - empezar limpio
            console.log('Formulario limpio para nuevo aprendiz');
            
            // Mostrar u ocultar la sección de información de la empresa según si tiene contrato
            const companyInfoSection = document.getElementById('company_info_section');
            if (companyInfoSection) {
                if (selectedMinute.has_contract) {
                    companyInfoSection.style.display = 'block';
                    // Llenar automáticamente los datos de la empresa
                    fillCompanyData(selectedMinute);
                } else {
                    companyInfoSection.style.display = 'none';
                }
            }
            
            // También auto-llenar Tipo de Novedad traducido en el formulario
            const incidentTypeField = document.querySelector('input[name="incident_type"]');
            if (incidentTypeField) {
                incidentTypeField.value = translateIncidentType(selectedMinute.incident_type);
            }

            // Auto-llenar Descripción de la Novedad con la del aprendiz seleccionado
            const incidentDescriptionField = document.querySelector('textarea[name="incident_description"]');
            if (incidentDescriptionField && selectedMinute.incident_description) {
                incidentDescriptionField.value = selectedMinute.incident_description;
            }


            // Scroll al formulario del comité
            committeeForm.scrollIntoView({ behavior: 'smooth' });
        }
    };
    
    window.viewApprentice = function(minutesId) {
        console.log('Viendo detalles del aprendiz:', minutesId);
        
        // Obtener datos del aprendiz seleccionado
        const minutes = @json($allMinutes);
        const selectedMinute = minutes.find(m => m.minutes_id == minutesId);
        
        console.log('Datos del aprendiz encontrado:', selectedMinute);
        
        if (selectedMinute) {
            console.log('Creando modal para aprendiz:', selectedMinute);
            
            // Crear modal con los detalles del aprendiz
            const modalHtml = `
                <div id="apprenticeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="card-header flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Detalles del Aprendiz</h3>
                            <button onclick="closeApprenticeModal()" class="text-white hover:text-gray-200 text-2xl">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                                        <p class="text-gray-900 font-medium">${selectedMinute.trainee_name || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                                        <p class="text-gray-900">${selectedMinute.document_type || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Documento</label>
                                        <p class="text-gray-900">${selectedMinute.id_document || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono del Aprendiz</label>
                                        <p class="text-gray-900">${selectedMinute.trainee_phone || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <p class="text-gray-900">${selectedMinute.email || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Programa de Formación</label>
                                        <p class="text-gray-900">${selectedMinute.program_name || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Ficha</label>
                                        <p class="text-gray-900">${selectedMinute.batch_number || 'No especificado'}</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Programa</label>
                                        <p class="text-gray-900">${selectedMinute.program_type || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado del Aprendiz</label>
                                        <p class="text-gray-900">${selectedMinute.trainee_status || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Centro de Formación</label>
                                        <p class="text-gray-900">${selectedMinute.training_center || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado del Contrato</label>
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium ${selectedMinute.has_contract ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                            ${selectedMinute.has_contract ? 'Con Contrato' : 'Sin Contrato'}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Novedad</label>
                                        <span class="inline-block bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                            ${translateIncidentType(selectedMinute.incident_type || 'Academic')}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtipo de Novedad</label>
                                        <p class="text-gray-900">${(selectedMinute.incident_subtype || 'No especificado').replace(/_/g, ' ')}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha del Acta</label>
                                        <p class="text-gray-900">${selectedMinute.minutes_date || 'No especificado'}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Acta</label>
                                        <p class="text-gray-900">${selectedMinute.act_number || 'No especificado'}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción de la Novedad</label>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-900">${selectedMinute.incident_description || 'No especificado'}</p>
                                </div>
                            </div>
                            
                            ${selectedMinute.has_contract ? `
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-building text-blue-600 mr-2"></i>
                                    Información de la Empresa
                                </h4>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-blue-700 mb-1">Nombre de la Empresa</label>
                                            <p class="text-gray-900">${selectedMinute.company_name || 'No especificado'}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-700 mb-1">Dirección</label>
                                            <p class="text-gray-900">${selectedMinute.company_address || 'No especificado'}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-700 mb-1">Contacto</label>
                                            <p class="text-gray-900">${selectedMinute.company_contact || 'No especificado'}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-700 mb-1">Responsable RRHH</label>
                                            <p class="text-gray-900">${selectedMinute.hr_manager_name || 'No especificado'}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ` : ''}
                            
                            <div class="mt-6 flex justify-end space-x-3">
                                <button onclick="closeApprenticeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-times mr-2"></i>Cerrar
                                </button>
                                <button onclick="selectApprenticeFromModal(${minutesId})" class="btn btn-accent">
                                    <i class="fas fa-edit mr-2"></i>Crear Comité
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Agregar modal al DOM
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }
    };
    
    // Función para cerrar el modal
    window.closeApprenticeModal = function() {
        const modal = document.getElementById('apprenticeModal');
        if (modal) {
            modal.remove();
        }
    };
    
    // Función para seleccionar aprendiz desde el modal
    window.selectApprenticeFromModal = function(minutesId) {
        closeApprenticeModal();
        selectApprentice(minutesId);
    };
    
    // Función para guardar datos del aprendiz actual
    window.saveCurrentApprenticeData = function() {
        const currentMinutesId = document.getElementById('minutes_id_input')?.value;
        if (currentMinutesId) {
            saveCurrentFormData();
            alert('Datos guardados para este aprendiz');
        } else {
            alert('No hay aprendiz seleccionado');
        }
    };
    
    // Función para probar la recolección de datos
    window.testCollectData = function() {
        console.log('=== PROBANDO RECOLECCIÓN DE DATOS ===');
        const committees = collectAllCommitteeData();
        alert(`Se encontraron ${committees.length} comité(s) guardados. Revisa la consola para más detalles.`);
    };
    
    
    
    // Función para probar el flujo
    window.testFlow = function() {
        console.log('=== PROBANDO FLUJO ===');
        console.log('currentActNumber:', currentActNumber);
        
        if (currentActNumber) {
            const minutes = @json($allMinutes);
            const selectedMinutes = minutes.filter(m => m.act_number == currentActNumber);
            const currentMinutesId = document.getElementById('minutes_id_input')?.value;
            
            console.log('selectedMinutes:', selectedMinutes);
            console.log('currentMinutesId:', currentMinutesId);
            
            if (currentMinutesId) {
                const currentIndex = selectedMinutes.findIndex(m => m.minutes_id == currentMinutesId);
                const isLast = currentIndex === selectedMinutes.length - 1;
                
                console.log('currentIndex:', currentIndex);
                console.log('totalMinutes:', selectedMinutes.length);
                console.log('isLast:', isLast);
                
                if (isLast) {
                    alert('✅ Es el último aprendiz - Se redirigirá a la lista');
                } else {
                    alert('❌ No es el último aprendiz - Se quedará en el formulario');
                }
            } else {
                alert('❌ No se encontró minutes_id');
            }
        } else {
            alert('❌ No se encontró currentActNumber');
        }
    };
    
    function clearFormData() {
        if (minutesDateInput) minutesDateInput.value = '';
        if (reportingPersonContent) reportingPersonContent.innerHTML = '';
        if (apprenticesContent) apprenticesContent.innerHTML = '';
    }
    
    // Función para limpiar todos los datos guardados
    function clearAllSavedData() {
        const minutes = @json($allMinutes);
        minutes.forEach(minute => {
            localStorage.removeItem(`committee_data_${minute.minutes_id}`);
        });
        console.log('Todos los datos guardados han sido limpiados');
    }
    
    // Función para limpiar datos de la acta actual
    function clearCurrentActData() {
        if (currentActNumber) {
            const minutes = @json($allMinutes);
            const currentActMinutes = minutes.filter(m => m.act_number == currentActNumber);
            currentActMinutes.forEach(minute => {
                localStorage.removeItem(`committee_data_${minute.minutes_id}`);
            });
            console.log('Datos limpiados para la acta:', currentActNumber);
        }
    }
    
    // Función para limpiar datos y refrescar la vista
    function clearCurrentActDataAndRefresh() {
        clearCurrentActData();
        if (currentActNumber) {
            const minutes = @json($allMinutes);
            const selectedMinutes = minutes.filter(m => m.act_number == currentActNumber);
            showApprenticesInfo(selectedMinutes);
        }
    }
    
    // Función para limpiar datos específicos de un aprendiz
    function clearApprenticeData(minutesId) {
        localStorage.removeItem(`committee_data_${minutesId}`);
        console.log('Datos limpiados para aprendiz:', minutesId);
    }

    // Función para seleccionar acta desde las tarjetas pendientes
    window.selectActFromPending = function(actNumber) {
        console.log('=== SELECCIONANDO ACTA DESDE PENDIENTES ===');
        console.log('Acta seleccionada:', actNumber);
        
        // Establecer la acta actual
        currentActNumber = actNumber;
        
        // Ocultar la sección de información de aprendices pendientes
        const pendingSection = document.querySelector('.bg-yellow-50');
        if (pendingSection) {
            pendingSection.style.display = 'none';
        }
        
        // Seleccionar la acta en el dropdown
        const actSelect = document.getElementById('act_select');
        if (actSelect) {
            actSelect.value = actNumber;
            console.log('Acta seleccionada en dropdown:', actNumber);
        }
        
        // Cargar datos de la acta seleccionada
        loadSelectedActData(actNumber);
        
        // Mostrar información detallada del acta
        const detailedActInfo = document.getElementById('detailed_act_info');
        if (detailedActInfo) {
            detailedActInfo.classList.remove('hidden');
            console.log('Mostrando información detallada del acta');
        }
        
        // Scroll hacia la información detallada
        detailedActInfo.scrollIntoView({ behavior: 'smooth' });
        
        console.log('Acta seleccionada exitosamente desde pendientes');
    };
    
    // Función para recolectar todos los datos guardados y enviarlos
    function collectAllCommitteeData() {
        const minutes = @json($allMinutes);
        const allCommittees = [];
        
        console.log('=== INICIANDO RECOLECCIÓN DE DATOS ===');
        console.log('Total minutes disponibles:', minutes.length);
        
        minutes.forEach(minute => {
            const savedData = localStorage.getItem(`committee_data_${minute.minutes_id}`);
            console.log(`Verificando datos para ${minute.trainee_name} (ID: ${minute.minutes_id}):`, savedData);
            
            if (savedData && savedData !== '{}' && savedData !== 'null') {
                try {
                    const data = JSON.parse(savedData);
                    console.log(`Datos parseados para ${minute.trainee_name}:`, data);
                    
                    // Verificar que tenga datos reales
                    const hasRealData = data.session_date || data.attendance_mode || data.offense_class || data.statement;
                    console.log(`¿Tiene datos reales ${minute.trainee_name}?`, hasRealData);
                    
                    if (hasRealData) {
                        // Agregar datos del minute
                        data.minutes_id = minute.minutes_id;
                        data.act_number = minute.act_number;
                        data.trainee_name = minute.trainee_name;
                        data.minutes_date = minute.minutes_date;
                        data.id_document = minute.id_document;
                        data.program_name = minute.program_name;
                        data.batch_number = minute.batch_number;
                        data.email = minute.email;
                        data.company_name = minute.company_name;
                        data.company_address = minute.company_address;
                        data.company_contact = minute.company_contact;
                        data.incident_type = minute.incident_type;
                        data.incident_description = minute.incident_description;
                        data.hr_responsible = minute.hr_manager_name;
                        data.committee_mode = 'Individual';
                        
                        allCommittees.push(data);
                        console.log('✅ Comité recolectado para:', minute.trainee_name, data);
                    } else {
                        console.log('❌ Sin datos reales para:', minute.trainee_name);
                    }
                } catch (e) {
                    console.error('❌ Error parseando datos para', minute.trainee_name, e);
                }
            } else {
                console.log('❌ Sin datos guardados para:', minute.trainee_name);
            }
        });
        
        console.log('=== FINALIZANDO RECOLECCIÓN ===');
        console.log('Total comités recolectados:', allCommittees.length);
        console.log('Comités:', allCommittees);
        return allCommittees;
    }
    
    // Función para enviar múltiples comités
    function submitMultipleCommittees() {
        console.log('=== INICIANDO ENVÍO MÚLTIPLE ===');
        console.log('Llamando a collectAllCommitteeData()');
        const committees = collectAllCommitteeData();
        
        console.log('Comités a enviar:', committees.length);
        console.log('Comités recolectados:', committees);
        
        if (committees.length === 0) {
            alert('No hay datos de comités para guardar. Por favor, diligencia al menos un comité.');
            return;
        }
        
        if (committees.length === 1) {
            console.log('Solo hay 1 comité, enviando como comité individual');
            // Si solo hay un comité, enviarlo como comité individual normal
            // Pero primero llenar el formulario con los datos guardados
            const committee = committees[0];
            const form = document.querySelector('form');
            
            // Llenar el formulario con los datos del comité
            Object.keys(committee).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = committee[key] || '';
                }
            });
            
            form.submit();
            return;
        }
        
        if (confirm(`¿Estás seguro de que quieres guardar ${committees.length} comité(s)?`)) {
            console.log('Usuario confirmó envío de', committees.length, 'comités');
            
            // Crear un formulario oculto para enviar múltiples comités
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("committee.individual.store") }}';
            
            // Agregar token CSRF
            const csrfToken = document.querySelector('input[name="_token"]').value;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            console.log('Agregando comités al formulario...');
            
            // Agregar cada comité como un campo oculto
            committees.forEach((committee, index) => {
                console.log(`Agregando comité ${index + 1}:`, committee);
                Object.keys(committee).forEach(key => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `committees[${index}][${key}]`;
                    input.value = committee[key] || '';
                    form.appendChild(input);
                });
            });
            
            console.log('Formulario creado, enviando...');
            console.log('Formulario HTML:', form.outerHTML);
            
            // Enviar formulario
            document.body.appendChild(form);
            form.submit();
        } else {
            console.log('Usuario canceló el envío');
        }
    }
    
    // Simplificar el formulario - siempre redirigir a la lista
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('=== FORMULARIO ENVIADO ===');
            console.log('Guardando comité individual y redirigiendo a la lista');
            // No prevenir el envío, dejar que redirija normalmente
        });
    } else {
        console.error('No se encontró el formulario');
    }
});
</script>
@endsection