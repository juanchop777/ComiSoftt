@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Registrar Comité</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('committee.store') }}" method="POST">
        @csrf

        {{-- Información de Sesión --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Información de Sesión</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="session_date" class="form-label fw-semibold">Fecha Sesión</label>
                        <input type="date" class="form-control" name="session_date" required>
                    </div>
                    <div class="col-md-3">
                        <label for="session_time" class="form-label fw-semibold">Hora Sesión</label>
                        <input type="time" class="form-control" name="session_time" required>
                    </div>
                    <div class="col-md-3">
                        <label for="committee_mode" class="form-label fw-semibold">Modo de Comité</label>
                        <select name="committee_mode" class="form-select" id="committee_mode" required>
                            <option value="">Seleccione...</option>
                            <option value="Individual">Individual</option>
                            <option value="General">General</option>
                        </select>
                        <small class="form-text text-muted">Individual: Un formulario por aprendiz | General: Un formulario para todos</small>
                    </div>
                    <div class="col-md-3">
                        <label for="access_link" class="form-label fw-semibold">Enlace de Acceso</label>
                        <input type="url" class="form-control" name="access_link" placeholder="https://meet.google.com/...">
                        <small class="form-text text-muted">Opcional - Solo para sesiones virtuales</small>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="minutes_date" class="form-label fw-semibold">Fecha Acta</label>
                        <input type="date" class="form-control" name="minutes_date" id="minutes_date_input">
                        <small class="form-text text-muted">Se llena automáticamente al seleccionar un acta</small>
                    </div>
                    <div class="col-md-6">
                        <input type="hidden" name="minutes_id" id="minutes_select">
                    </div>
                </div>

                {{-- Búsqueda detallada de actas --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label for="detailed_minutes_search" class="form-label fw-semibold">Buscar Acta (Vista Detallada)</label>
                        <div class="position-relative">
                            <input type="text" id="detailed_minutes_search" class="form-control" placeholder="Buscar acta para ver todos los aprendices y detalles..." autocomplete="off">
                            <div class="position-absolute top-100 start-0 w-100 bg-white border border-top-0 rounded-bottom shadow-sm d-none" id="detailed_search_results" style="max-height: 200px; overflow-y: auto; z-index: 1000;"></div>
                        </div>
                    </div>
                </div>

                {{-- Información detallada del acta --}}
                <div id="detailed_act_info" class="d-none">
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información Detallada del Acta</h6>
                        </div>
                        <div class="card-body">
                            <div id="reporting_person_info" class="mb-3">
                                <h6 class="text-primary"><i class="fas fa-user"></i> Persona que Reporta</h6>
                                <div class="row g-2">
                                    <div class="col-md-4"><strong>Nombre:</strong> <span id="rp_name">-</span></div>
                                    <div class="col-md-4"><strong>Email:</strong> <span id="rp_email">-</span></div>
                                    <div class="col-md-4"><strong>Teléfono:</strong> <span id="rp_phone">-</span></div>
                                </div>
                            </div>
                            <div id="trainees_list">
                                <h6 class="text-success"><i class="fas fa-graduation-cap"></i> Aprendices en esta Acta</h6>
                                <div id="trainees_container"></div>
                            </div>
                            
                            {{-- Contenedor para modo general --}}
                            <div id="general_mode_container" class="d-none">
                                <div class="alert alert-info">
                                    <h6 class="text-primary"><i class="fas fa-users"></i> Modo General</h6>
                                    <p class="mb-2">Se creará un solo formulario de comité para todos los aprendices de esta acta.</p>
                                    <button type="button" class="btn btn-primary" id="create_general_committee_btn">
                                        <i class="fas fa-plus"></i> Crear Comité General
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 committee-form-section" style="display: none;">
                    <div class="col-md-6">
                        <label for="attendance_mode" class="form-label fw-semibold">Modalidad Asistencia</label>
                        <select name="attendance_mode" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Virtual">Virtual</option>
                            <option value="No asistió">No asistió</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="alert alert-info mb-0 w-100">
                            <strong>Aprendiz seleccionado:</strong> <span id="selected_trainee_name">-</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="hideCommitteeForm()">
                                <i class="fas fa-times"></i> Ocultar
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2" id="restore_previous_btn" onclick="restorePreviousTrainee()" style="display: none;">
                                <i class="fas fa-undo"></i> Restaurar Anterior
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearAllFormData()">
                                <i class="fas fa-trash"></i> Limpiar Todo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Información de la Falta --}}
        <div class="card mb-4 shadow-sm committee-form-section" style="display: none;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Información de la Falta</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="fault_type" class="form-label fw-semibold">Tipo de Falta</label>
                        <input type="text" class="form-control" name="fault_type" required placeholder="Ej: Inasistencia, indisciplina, etc.">
                    </div>
                    <div class="col-md-4">
                        <label for="offense_class" class="form-label fw-semibold">Clase de Falta</label>
                        <select name="offense_class" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Leve">Leve</option>
                            <option value="Grave">Grave</option>
                            <option value="Muy Grave">Muy Grave</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="offense_classification" class="form-label fw-semibold">Descripcion de la Falta</label>
                    <textarea name="offense_classification" class="form-control" rows="3" placeholder="Describa la clasificación de la falta..."></textarea>
                </div>
                <div class="mb-4">
                    <label for="statement" class="form-label fw-semibold">Descargos</label>
                    <textarea name="statement" class="form-control" rows="3" required placeholder="Descargos del aprendiz..."></textarea>
                </div>
            </div>
        </div>

        {{-- Campo específico para descargos en modo general --}}
        <div class="card mb-4 shadow-sm general-mode-field" style="display: none;">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-users"></i> Descargos Generales</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label for="general_statements" class="form-label fw-semibold">Opiniones de Todos los Aprendices</label>
                    <textarea name="general_statements" class="form-control" rows="4" placeholder="Escriba aquí las opiniones y descargos de todos los aprendices del comité general..."></textarea>
                    <small class="form-text text-muted">Este campo es específico para el modo general y permite escribir las opiniones de todos los aprendices en un solo lugar</small>
                </div>
            </div>
        </div>

        {{-- Decisiones y Seguimiento --}}
        <div class="card mb-4 shadow-sm committee-form-section" style="display: none;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Decisiones y Seguimiento</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="decision" class="form-label fw-semibold">Decisión</label>
                        <textarea name="decision" class="form-control" rows="3" required placeholder="Decisión del comité..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="commitments" class="form-label fw-semibold">Compromisos</label>
                        <textarea name="commitments" class="form-control" rows="3" placeholder="Compromisos acordados..."></textarea>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="missing_rating" class="form-label fw-semibold">Calificación Faltante</label>
                        <textarea name="missing_rating" class="form-control" rows="3" placeholder="Calificaciones o evaluaciones faltantes..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="recommendations" class="form-label fw-semibold">Recomendaciones</label>
                        <textarea name="recommendations" class="form-control" rows="3" placeholder="Recomendaciones del comité..."></textarea>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="observations" class="form-label fw-semibold">Observaciones</label>
                    <textarea name="observations" class="form-control" rows="3" placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4 committee-form-section" style="display: none;">
            <button type="submit" class="btn btn-success" onclick="showSaveAlert()">
                <i class="fas fa-save"></i> Guardar Comité
            </button>
            <a href="{{ route('committee.index') }}" class="btn btn-secondary" onclick="showCancelAlert(event)">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const minutesDateInput = document.querySelector('input[name="minutes_date"]');
    
    const minutesData = @json($minutes->keyBy('minutes_id'));
    const allMinutes = @json($minutes->values());
    window.allMinutes = allMinutes;
    
    // Inicializar el almacenamiento de datos de aprendices
    window.traineeFormData = {};
    
    // Inicializar datos de sesión
    window.sessionData = {};
    
    // Restaurar datos de sesión si existen
    restoreSessionData();
    
    // Verificar el estado inicial del modo de comité
    const initialMode = document.getElementById('committee_mode').value;
    if (initialMode) {
        // Disparar el evento de cambio para aplicar el estado inicial
        document.getElementById('committee_mode').dispatchEvent(new Event('change'));
    }
    
    
    // Event listener para guardar automáticamente los datos del formulario
    const formFields = [
        'session_date', 'session_time', 'access_link',
        'attendance_mode', 'offense_class',
        'fault_type', 'offense_classification',
        'statement', 'decision', 'commitments', 
        'missing_rating', 'recommendations', 'observations',
        'committee_mode', 'general_statements'
    ];
    
    // Event listener para el cambio de modo de comité
    const committeeModeSelect = document.getElementById('committee_mode');
    if (committeeModeSelect) {
        committeeModeSelect.addEventListener('change', function() {
            const selectedMode = this.value;
            const traineesContainer = document.getElementById('trainees_container');
            const generalModeContainer = document.getElementById('general_mode_container');
            const generalModeFields = document.querySelectorAll('.general-mode-field');
            
            if (selectedMode === 'General') {
                // Ocultar contenedor de aprendices individuales
                if (traineesContainer) {
                    traineesContainer.style.display = 'none';
                }
                // Mostrar contenedor de modo general
                if (generalModeContainer) {
                    generalModeContainer.classList.remove('d-none');
                }
                // Mostrar campos específicos del modo general
                generalModeFields.forEach(field => {
                    field.style.display = 'block';
                });
            } else if (selectedMode === 'Individual') {
                // Mostrar contenedor de aprendices individuales
                if (traineesContainer) {
                    traineesContainer.style.display = 'block';
                }
                // Ocultar contenedor de modo general
                if (generalModeContainer) {
                    generalModeContainer.classList.add('d-none');
                }
                // Ocultar campos específicos del modo general
                generalModeFields.forEach(field => {
                    field.style.display = 'none';
                });
            } else {
                // Ocultar ambos contenedores si no hay modo seleccionado
                if (traineesContainer) {
                    traineesContainer.style.display = 'none';
                }
                if (generalModeContainer) {
                    generalModeContainer.classList.add('d-none');
                }
                // Ocultar campos específicos del modo general
                generalModeFields.forEach(field => {
                    field.style.display = 'none';
                });
            }
        });
    }
    
    formFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('input', function() {
                saveCurrentFormData();
            });
            
            field.addEventListener('change', function() {
                saveCurrentFormData();
            });
        }
    });
    
    // Función para guardar automáticamente los datos del formulario
    function saveCurrentFormData() {
        // Guardar datos de sesión globalmente
        if (!window.sessionData) {
            window.sessionData = {};
        }
        
        const sessionFields = ['session_date', 'session_time', 'access_link', 'committee_mode'];
        sessionFields.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                window.sessionData[fieldName] = field.value;
            }
        });
        
        // Guardar datos individuales del aprendiz
        if (window.selectedTraineeInfo) {
            const currentKey = `${window.selectedTraineeInfo.actNumber}_${window.selectedTraineeInfo.index}`;
            
            if (!window.traineeFormData) {
                window.traineeFormData = {};
            }
            
            const formData = {};
            formFields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    formData[fieldName] = field.value;
                }
            });
            
            // Solo guardar si hay algún dato
            const hasData = Object.values(formData).some(value => value && value.trim() !== '');
            if (hasData) {
                window.traineeFormData[currentKey] = formData;
            }
        }
    }

    
    // Búsqueda detallada
    const detailedSearchInput = document.getElementById('detailed_minutes_search');
    const detailedSearchResults = document.getElementById('detailed_search_results');
    const detailedActInfo = document.getElementById('detailed_act_info');
    
    detailedSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            detailedSearchResults.classList.add('d-none');
            detailedSearchResults.innerHTML = '';
            return;
        }
        
        const uniqueActs = {};
        allMinutes.forEach(minute => {
            if (!uniqueActs[minute.act_number]) {
                uniqueActs[minute.act_number] = minute;
            }
        });
        
        const filteredActs = Object.values(uniqueActs).filter(act => {
            const searchText = act.act_number.toLowerCase();
            return searchText.includes(searchTerm);
        });
        
        if (filteredActs.length > 0) {
            let html = '';
            filteredActs.slice(0, 10).forEach(act => {
                let displayDate;
                if (act.minutes_date) {
                    if (act.minutes_date.includes('T')) {
                        const date = new Date(act.minutes_date);
                        const year = date.getUTCFullYear();
                        const month = String(date.getUTCMonth() + 1).padStart(2, '0');
                        const day = String(date.getUTCDate()).padStart(2, '0');
                        displayDate = `${day}/${month}/${year}`;
                    } else {
                        displayDate = new Date(act.minutes_date).toLocaleDateString('es-CO');
                    }
                } else {
                    displayDate = 'Sin fecha';
                }
                
                html += `
                    <div class="search-item p-2 border-bottom cursor-pointer hover-bg-light" data-act-number="${act.act_number}" style="cursor: pointer;">
                        <div class="fw-semibold">Acta #${act.act_number}</div>
                        <div class="text-muted small">Fecha: ${displayDate}</div>
                    </div>
                `;
            });
            
            if (filteredActs.length > 10) {
                html += `<div class="p-2 text-muted text-center small">... y ${filteredActs.length - 10} resultados más</div>`;
            }
            
            detailedSearchResults.innerHTML = html;
            detailedSearchResults.classList.remove('d-none');
        } else {
            detailedSearchResults.innerHTML = '<div class="p-2 text-muted text-center">No se encontraron actas</div>';
            detailedSearchResults.classList.remove('d-none');
        }
    });
    
    detailedSearchResults.addEventListener('click', function(e) {
        const searchItem = e.target.closest('.search-item');
        if (searchItem) {
            const actNumber = searchItem.dataset.actNumber;
            showDetailedActInfo(actNumber);
            detailedSearchInput.value = `Acta #${actNumber}`;
            detailedSearchResults.classList.add('d-none');
        }
    });
    
    function showDetailedActInfo(actNumber) {
        const actMinutes = allMinutes.filter(minute => minute.act_number === actNumber);
        
        if (actMinutes.length === 0) {
            return;
        }
        
        const firstMinute = actMinutes[0];
        const reportingPerson = firstMinute.reporting_person;
        
        // Actualizar automáticamente la fecha del acta
        const minutesDateInput = document.getElementById('minutes_date_input');
        if (minutesDateInput && firstMinute.minutes_date) {
            let dateValue = firstMinute.minutes_date;
            
            if (typeof dateValue === 'string') {
                if (dateValue.includes('T')) {
                    const date = new Date(dateValue);
                    const year = date.getUTCFullYear();
                    const month = String(date.getUTCMonth() + 1).padStart(2, '0');
                    const day = String(date.getUTCDate()).padStart(2, '0');
                    dateValue = `${year}-${month}-${day}`;
                } else if (dateValue.includes(' ')) {
                    dateValue = dateValue.split(' ')[0];
                } else if (dateValue.includes('/')) {
                    const parts = dateValue.split('/');
                    if (parts.length === 3) {
                        dateValue = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                    }
                }
            }
            minutesDateInput.value = dateValue;
        }
        
        // Actualizar automáticamente el campo hidden de minutes_id
        const minutesSelect = document.getElementById('minutes_select');
        if (minutesSelect) {
            minutesSelect.value = firstMinute.minutes_id;
        }
        
        document.getElementById('rp_name').textContent = reportingPerson ? reportingPerson.full_name : 'No especificado';
        document.getElementById('rp_email').textContent = reportingPerson ? reportingPerson.email : 'No especificado';
        document.getElementById('rp_phone').textContent = reportingPerson ? reportingPerson.phone : 'No especificado';
        
        let traineesHtml = '';
        actMinutes.forEach((minute, index) => {
            const hasContract = minute.has_contract ? 'Sí' : 'No';
            const incidentType = minute.incident_type || 'No especificado';
            
            // Obtener el modo de comité seleccionado
            const committeeMode = document.getElementById('committee_mode').value;
            
            traineesHtml += `
                <div class="card mb-2">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Aprendiz #${index + 1}</h6>
                                <div class="d-flex gap-1">
                                                 <button type="button" class="btn btn-sm btn-light" onclick="showCommitteeForm(${index}, '${minute.trainee_name}', '${actNumber}')">
                             <i class="fas fa-edit"></i> Crear Comité
                         </button>
                                    <button type="button" class="btn btn-sm btn-info" onclick="viewTraineeInfo(${index}, '${minute.trainee_name}', '${actNumber}')">
                                        <i class="fas fa-eye"></i>
                         </button>
                                </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <strong>Nombre:</strong> ${minute.trainee_name || 'No especificado'}<br>
                                <strong>Documento:</strong> ${minute.id_document || 'No especificado'}<br>
                                <strong>Email:</strong> ${minute.email || 'No especificado'}<br>
                                <strong>Programa:</strong> ${minute.program_name || 'No especificado'}<br>
                                <strong>Ficha:</strong> ${minute.batch_number || 'No especificado'}
                            </div>
                            <div class="col-md-6">
                                <strong>Contrato:</strong> ${hasContract}<br>
                                <strong>Tipo Novedad:</strong> <span class="badge bg-warning">${incidentType}</span><br>
                                <strong>Empresa:</strong> ${minute.company_name || 'No especificado'}<br>
                                <strong>Dirección:</strong> ${minute.company_address || 'No especificado'}<br>
                                <strong>Responsable RH:</strong> ${minute.hr_manager_name || 'No especificado'}
                            </div>
                        </div>
                        <div class="mt-2">
                            <strong>Descripción:</strong> ${minute.incident_description || 'No especificado'}
                        </div>
                    </div>
                </div>
            `;
        });
        
        document.getElementById('trainees_container').innerHTML = traineesHtml;
        detailedActInfo.classList.remove('d-none');
        
        // Configurar el botón de comité general
        const generalCommitteeBtn = document.getElementById('create_general_committee_btn');
        if (generalCommitteeBtn) {
            generalCommitteeBtn.onclick = function() {
                showGeneralCommitteeForm(actNumber, actMinutes);
            };
        }
    }
    
    document.addEventListener('click', function(e) {
        if (!detailedSearchInput.contains(e.target) && !detailedSearchResults.contains(e.target)) {
            detailedSearchResults.classList.add('d-none');
        }
    });
    
    window.selectedTraineeInfo = null;
});

// Función global para mostrar el formulario de comité
function showCommitteeForm(traineeIndex, traineeName, actNumber) {
    // GUARDAR INFORMACIÓN DEL APRENDIZ ANTERIOR ANTES DE LIMPIAR
    if (window.selectedTraineeInfo) {
        window.previousTraineeData = {
            traineeInfo: { ...window.selectedTraineeInfo },
            formData: {}
        };
        
        // Guardar todos los datos del formulario actual
        const fieldsToSave = [
            'session_date', 'session_time', 'access_link',
            'attendance_mode', 'offense_class',
            'fault_type', 'offense_classification',
            'statement', 'decision', 'commitments', 
            'missing_rating', 'recommendations', 'observations'
        ];
        
        fieldsToSave.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                window.previousTraineeData.formData[fieldName] = field.value;
            }
        });
        
        // Guardar los datos del aprendiz anterior en el almacenamiento global
        if (!window.traineeFormData) {
            window.traineeFormData = {};
        }
        
        const previousKey = `${window.selectedTraineeInfo.actNumber}_${window.selectedTraineeInfo.index}`;
        window.traineeFormData[previousKey] = { ...window.previousTraineeData.formData };
        
        // Mostrar el botón de restaurar
        const restoreBtn = document.getElementById('restore_previous_btn');
        if (restoreBtn) {
            restoreBtn.style.display = 'inline-block';
        }
    }
    
    // Mostrar todas las secciones del formulario
    const formSections = document.querySelectorAll('.committee-form-section');
    formSections.forEach(section => {
        section.style.display = 'block';
    });
    
    // Guardar información del aprendiz seleccionado
    window.selectedTraineeInfo = {
        index: traineeIndex,
        name: traineeName,
        actNumber: actNumber
    };
    
    // Verificar si este aprendiz ya tiene datos guardados
    const currentKey = `${actNumber}_${traineeIndex}`;
    let existingData = null;
    
    if (window.traineeFormData && window.traineeFormData[currentKey]) {
        existingData = window.traineeFormData[currentKey];
    }
    
    // SIEMPRE RESTAURAR LOS DATOS DE SESIÓN GLOBALES
    restoreSessionData();
    
    if (existingData) {
        // RESTAURAR DATOS EXISTENTES DEL APRENDIZ
        Object.keys(existingData).forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.value = existingData[fieldName];
            }
        });
    } else {
        // LIMPIAR SOLO LOS CAMPOS INDIVIDUALES PARA NUEVO APRENDIZ
        // NUNCA limpiar los campos de sesión (se mantienen compartidos)
        const individualFieldsToClear = [
        'attendance_mode', 'offense_class',
        'statement', 'decision', 'commitments', 
        'missing_rating', 'recommendations', 'observations'
    ];
    
        individualFieldsToClear.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.value = '';
        }
    });
    
    // FILTRAR AUTOMÁTICAMENTE SOLO EL TIPO DE FALTA Y DESCRIPCIÓN
    const actMinutes = window.allMinutes.filter(minute => minute.act_number === actNumber);
    const currentMinute = actMinutes[traineeIndex];
    
    if (currentMinute) {
        // Traducir y filtrar el tipo de falta
        if (currentMinute.incident_type) {
            const faultTypeInput = document.querySelector('input[name="fault_type"]');
            if (faultTypeInput) {
                let translatedType = currentMinute.incident_type;
                switch (currentMinute.incident_type.toLowerCase()) {
                    case 'academic':
                        translatedType = 'Académica';
                        break;
                    case 'disciplinary':
                        translatedType = 'Disciplinaria';
                        break;
                    case 'dropout':
                        translatedType = 'Deserción';
                        break;
                    case 'attendance':
                        translatedType = 'Asistencia';
                        break;
                    case 'behavior':
                        translatedType = 'Comportamiento';
                        break;
                    case 'performance':
                        translatedType = 'Rendimiento';
                        break;
                    default:
                        translatedType = currentMinute.incident_type;
                }
                faultTypeInput.value = translatedType;
            }
        }
        
        // Filtrar la descripción de la falta
        if (currentMinute.incident_description) {
            const offenseClassificationInput = document.querySelector('textarea[name="offense_classification"]');
            if (offenseClassificationInput) {
                offenseClassificationInput.value = currentMinute.incident_description;
                }
            }
        }
    }
    
    // Actualizar el campo de minutes_id (hidden)
    const minutesSelect = document.getElementById('minutes_select');
    if (minutesSelect) {
        const actMinutes = window.allMinutes.filter(minute => minute.act_number === actNumber);
        if (actMinutes.length > 0) {
            minutesSelect.value = actMinutes[0].minutes_id;
        }
    }
    
    // Mostrar alerta informativa
    Swal.fire({
        title: 'Formulario de Comité',
        text: `Formulario habilitado para: ${traineeName}`,
        icon: 'info',
        confirmButtonText: 'Entendido'
    });
    
    // Actualizar el indicador de aprendiz seleccionado
    const selectedTraineeSpan = document.getElementById('selected_trainee_name');
    if (selectedTraineeSpan) {
        selectedTraineeSpan.textContent = traineeName;
    }
    
    // Hacer scroll hacia el formulario
    const firstFormSection = document.querySelector('.committee-form-section');
    if (firstFormSection) {
        firstFormSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Función para ocultar el formulario de comité
function hideCommitteeForm() {
    // GUARDAR LOS DATOS ACTUALES DEL FORMULARIO ANTES DE OCULTAR
    if (window.selectedTraineeInfo) {
        const currentKey = `${window.selectedTraineeInfo.actNumber}_${window.selectedTraineeInfo.index}`;
        
        if (!window.traineeFormData) {
            window.traineeFormData = {};
        }
        
        // Guardar todos los datos del formulario actual
        const fieldsToSave = [
            'session_date', 'session_time', 'access_link',
            'attendance_mode', 'offense_class',
            'fault_type', 'offense_classification',
            'statement', 'decision', 'commitments', 
            'missing_rating', 'recommendations', 'observations'
        ];
        
        const formData = {};
        fieldsToSave.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                formData[fieldName] = field.value;
            }
        });
        
        // Guardar datos individuales del aprendiz
        const individualFields = [
            'attendance_mode', 'offense_class',
            'fault_type', 'offense_classification',
            'statement', 'decision', 'commitments', 
            'missing_rating', 'recommendations', 'observations'
        ];
        
        const individualData = {};
        individualFields.forEach(fieldName => {
            if (formData[fieldName]) {
                individualData[fieldName] = formData[fieldName];
            }
        });
        
        // Solo guardar datos individuales si hay algún dato
        const hasIndividualData = Object.values(individualData).some(value => value && value.trim() !== '');
        if (hasIndividualData) {
            window.traineeFormData[currentKey] = individualData;
        }
        
        // Guardar datos de sesión globalmente
        if (!window.sessionData) {
            window.sessionData = {};
        }
        
        const sessionFields = ['session_date', 'session_time', 'access_link'];
        sessionFields.forEach(fieldName => {
            if (formData[fieldName]) {
                window.sessionData[fieldName] = formData[fieldName];
            }
        });
    }
    
    // SOLO OCULTAR LAS SECCIONES DEL FORMULARIO DE COMITÉ
    // NO ocultar la información detallada de los aprendices
    const formSections = document.querySelectorAll('.committee-form-section');
    formSections.forEach(section => {
        section.style.display = 'none';
    });
    
    // NO LIMPIAR CAMPOS - SOLO OCULTAR
    // Los datos se mantienen para poder restaurarlos después
    
    const selectedTraineeSpan = document.getElementById('selected_trainee_name');
    if (selectedTraineeSpan) {
        selectedTraineeSpan.textContent = '-';
    }
    
    // MANTENER VISIBLE LA INFORMACIÓN DETALLADA DE LOS APRENDICES
    // La información de los aprendices permanece visible para poder seleccionar otro
    
    Swal.fire({
        title: 'Formulario Ocultado',
        text: 'El formulario de comité ha sido ocultado. Los datos han sido guardados automáticamente para este aprendiz.',
        icon: 'info',
        confirmButtonText: 'Entendido'
    });
}

// Función para restaurar el aprendiz anterior
function restorePreviousTrainee() {
    if (!window.previousTraineeData) {
        Swal.fire({
            title: 'No hay datos anteriores',
            text: 'No hay información de un aprendiz anterior para restaurar',
            icon: 'warning',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    // Mostrar todas las secciones del formulario
    const formSections = document.querySelectorAll('.committee-form-section');
    formSections.forEach(section => {
        section.style.display = 'block';
    });
    
    // Restaurar la información del aprendiz anterior
    window.selectedTraineeInfo = { ...window.previousTraineeData.traineeInfo };
    
    // Restaurar todos los datos del formulario
    Object.keys(window.previousTraineeData.formData).forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.value = window.previousTraineeData.formData[fieldName];
        }
    });
    
    // Actualizar el indicador de aprendiz seleccionado
    const selectedTraineeSpan = document.getElementById('selected_trainee_name');
    if (selectedTraineeSpan) {
        selectedTraineeSpan.textContent = window.previousTraineeData.traineeInfo.name;
    }
    
    // Restaurar el minutes_id
    const minutesSelect = document.getElementById('minutes_select');
    if (minutesSelect && window.previousTraineeData.traineeInfo.actNumber) {
        const actMinutes = window.allMinutes.filter(minute => minute.act_number === window.previousTraineeData.traineeInfo.actNumber);
        if (actMinutes.length > 0) {
            minutesSelect.value = actMinutes[0].minutes_id;
        }
    }
    
    // Hacer scroll hacia el formulario
    const firstFormSection = document.querySelector('.committee-form-section');
    if (firstFormSection) {
        firstFormSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    Swal.fire({
        title: 'Información Restaurada',
        text: `Se ha restaurado la información de: ${window.previousTraineeData.traineeInfo.name}`,
        icon: 'success',
        confirmButtonText: 'Entendido'
    });
}

// Función para mostrar alerta de guardado
function showSaveAlert() {
    Swal.fire({
        title: 'Guardando...',
        text: 'El comité está siendo guardado',
        icon: 'info',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false
    });
}

// Función para mostrar alerta de cancelación
function showCancelAlert(event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro?',
        text: "Los datos ingresados se perderán",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'Continuar editando'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route('committee.index') }}';
        }
    });
}

@if(session('success'))
    Swal.fire({
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    }).then(() => {
        // Limpiar completamente el formulario después de guardar exitosamente
        clearAllFormData();
    });
@endif

@if ($errors->any())
    Swal.fire({
        title: 'Error de Validación',
        html: `
            <ul class="text-left">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `,
        icon: 'error',
        confirmButtonText: 'Entendido'
    });
@endif

// Función para ver la información detallada del aprendiz
function viewTraineeInfo(traineeIndex, traineeName, actNumber) {
    const actMinutes = window.allMinutes.filter(minute => minute.act_number === actNumber);
    const currentMinute = actMinutes[traineeIndex];
    
    if (!currentMinute) {
        Swal.fire({
            title: 'Error',
            text: 'No se encontró información del aprendiz',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    // Verificar si hay datos del formulario para este aprendiz
    const currentKey = `${actNumber}_${traineeIndex}`;
    const hasFormData = window.traineeFormData && window.traineeFormData[currentKey];
    
    // Formatear fecha
    let displayDate = 'Sin fecha';
    if (currentMinute.minutes_date) {
        if (currentMinute.minutes_date.includes('T')) {
            const date = new Date(currentMinute.minutes_date);
            const year = date.getUTCFullYear();
            const month = String(date.getUTCMonth() + 1).padStart(2, '0');
            const day = String(date.getUTCDate()).padStart(2, '0');
            displayDate = `${day}/${month}/${year}`;
        } else {
            displayDate = new Date(currentMinute.minutes_date).toLocaleDateString('es-CO');
        }
    }
    
    // Traducir tipo de incidente
    let incidentType = currentMinute.incident_type || 'No especificado';
    switch (incidentType.toLowerCase()) {
        case 'academic':
            incidentType = 'Académica';
            break;
        case 'disciplinary':
            incidentType = 'Disciplinaria';
            break;
        case 'dropout':
            incidentType = 'Deserción';
            break;
        case 'attendance':
            incidentType = 'Asistencia';
            break;
        case 'behavior':
            incidentType = 'Comportamiento';
            break;
        case 'performance':
            incidentType = 'Rendimiento';
            break;
    }
    
    // Crear HTML con la información del aprendiz
    let traineeInfoHtml = `
        <div class="text-start">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary mb-3"><i class="fas fa-user"></i> Información Personal</h6>
                    <p><strong>Nombre:</strong> ${currentMinute.trainee_name || 'No especificado'}</p>
                    <p><strong>Documento:</strong> ${currentMinute.id_document || 'No especificado'}</p>
                    <p><strong>Email:</strong> ${currentMinute.email || 'No especificado'}</p>
                    <p><strong>Programa:</strong> ${currentMinute.program_name || 'No especificado'}</p>
                    <p><strong>Ficha:</strong> ${currentMinute.batch_number || 'No especificado'}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-success mb-3"><i class="fas fa-building"></i> Información Empresarial</h6>
                    <p><strong>Contrato:</strong> ${currentMinute.has_contract ? 'Sí' : 'No'}</p>
                    <p><strong>Empresa:</strong> ${currentMinute.company_name || 'No especificado'}</p>
                    <p><strong>Dirección:</strong> ${currentMinute.company_address || 'No especificado'}</p>
                    <p><strong>Responsable RH:</strong> ${currentMinute.hr_manager_name || 'No especificado'}</p>
                    <p><strong>Contacto Empresa:</strong> ${currentMinute.company_contact || 'No especificado'}</p>
                </div>
            </div>
            
            <hr class="my-3">
            
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-warning mb-3"><i class="fas fa-exclamation-triangle"></i> Información del Incidente</h6>
                    <p><strong>Tipo de Novedad:</strong> <span class="badge bg-warning">${incidentType}</span></p>
                    <p><strong>Fecha del Acta:</strong> ${displayDate}</p>
                    <p><strong>Número de Acta:</strong> ${actNumber}</p>
                    <p><strong>Fecha de Recepción:</strong> ${currentMinute.reception_date ? new Date(currentMinute.reception_date).toLocaleDateString('es-CO') : 'No especificado'}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-info mb-3"><i class="fas fa-user-tie"></i> Persona que Reporta</h6>
                    <p><strong>Nombre:</strong> ${currentMinute.reporting_person ? currentMinute.reporting_person.full_name : 'No especificado'}</p>
                    <p><strong>Email:</strong> ${currentMinute.reporting_person ? currentMinute.reporting_person.email : 'No especificado'}</p>
                    <p><strong>Teléfono:</strong> ${currentMinute.reporting_person ? currentMinute.reporting_person.phone : 'No especificado'}</p>
                </div>
            </div>
            
            <hr class="my-3">
            
            <div class="row">
                <div class="col-12">
                    <h6 class="text-danger mb-3"><i class="fas fa-file-alt"></i> Descripción del Incidente</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">${currentMinute.incident_description || 'No hay descripción disponible'}</p>
                    </div>
                </div>
            </div>`;
    
    // Si hay datos del formulario, agregar esa información
    if (hasFormData) {
        const formData = window.traineeFormData[currentKey];
        traineeInfoHtml += `
            <hr class="my-3">
            
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-success mb-0"><i class="fas fa-clipboard-list"></i> Información del Comité</h6>
                        <button type="button" class="btn btn-warning btn-sm" onclick="editTraineeInfo(${traineeIndex}, '${traineeName}', '${actNumber}')">
                            <i class="fas fa-edit"></i> Editar Comité
                        </button>
            </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-2"><i class="fas fa-calendar"></i> Sesión</h6>
                            <p><strong>Fecha:</strong> ${window.sessionData ? window.sessionData.session_date || 'No especificada' : 'No especificada'}</p>
                            <p><strong>Hora:</strong> ${window.sessionData ? window.sessionData.session_time || 'No especificada' : 'No especificada'}</p>
                            <p><strong>Enlace:</strong> ${window.sessionData ? window.sessionData.access_link || 'No especificado' : 'No especificado'}</p>
                            <p><strong>Modalidad:</strong> <span class="badge bg-info">${formData.attendance_mode || 'No especificada'}</span></p>
        </div>
                        <div class="col-md-6">
                            <h6 class="text-warning mb-2"><i class="fas fa-exclamation-triangle"></i> Falta</h6>
                            <p><strong>Tipo:</strong> ${formData.fault_type || 'No especificado'}</p>
                            <p><strong>Clase:</strong> <span class="badge bg-warning">${formData.offense_class || 'No especificada'}</span></p>
                            <p><strong>Descripción:</strong> ${formData.offense_classification || 'No especificada'}</p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="text-danger mb-2"><i class="fas fa-comments"></i> Descargos y Decisión</h6>
                            <p><strong>Descargos:</strong></p>
                            <div class="bg-light p-2 rounded small">
                                ${formData.statement || 'No especificados'}
                            </div>
                            <p><strong>Decisión:</strong></p>
                            <div class="bg-light p-2 rounded small">
                                ${formData.decision || 'No especificada'}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info mb-2"><i class="fas fa-handshake"></i> Seguimiento</h6>
                            <p><strong>Compromisos:</strong></p>
                            <div class="bg-light p-2 rounded small">
                                ${formData.commitments || 'No especificados'}
                            </div>
                            <p><strong>Calificación Faltante:</strong></p>
                            <div class="bg-light p-2 rounded small">
                                ${formData.missing_rating || 'No especificada'}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="text-secondary mb-2"><i class="fas fa-lightbulb"></i> Recomendaciones</h6>
                            <div class="bg-light p-2 rounded small">
                                ${formData.recommendations || 'No especificadas'}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary mb-2"><i class="fas fa-eye"></i> Observaciones</h6>
                            <div class="bg-light p-2 rounded small">
                                ${formData.observations || 'No especificadas'}
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
    } else {
        // Mostrar datos de sesión incluso si no hay datos individuales del comité
        if (window.sessionData && (window.sessionData.session_date || window.sessionData.session_time || window.sessionData.access_link)) {
            traineeInfoHtml += `
                <hr class="my-3">
                
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i>
                            <strong>Información de Sesión Disponible:</strong>
                            <br><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Fecha:</strong> ${window.sessionData.session_date || 'No especificada'}
                                </div>
                                <div class="col-md-4">
                                    <strong>Hora:</strong> ${window.sessionData.session_time || 'No especificada'}
                                </div>
                                <div class="col-md-4">
                                    <strong>Enlace:</strong> ${window.sessionData.access_link || 'No especificado'}
                                </div>
                            </div>
                            <br>
                            <button type="button" class="btn btn-primary btn-sm" onclick="editTraineeInfo(${traineeIndex}, '${traineeName}', '${actNumber}')">
                                <i class="fas fa-plus"></i> Crear Comité
                            </button>
                        </div>
                    </div>
                </div>`;
        } else {
            traineeInfoHtml += `
                <hr class="my-3">
                
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> No hay información del comité registrada para este aprendiz. 
                            <br><br>
                            <button type="button" class="btn btn-primary btn-sm" onclick="editTraineeInfo(${traineeIndex}, '${traineeName}', '${actNumber}')">
                                <i class="fas fa-plus"></i> Crear Comité
                            </button>
                        </div>
                    </div>
                </div>`;
        }
    }
    
    traineeInfoHtml += `</div>`;
    
    // Mostrar modal con la información
    Swal.fire({
        title: `<i class="fas fa-user-graduate"></i> Información de ${traineeName}`,
        html: traineeInfoHtml,
        width: '950px',
        confirmButtonText: 'Cerrar',
        confirmButtonColor: '#3085d6',
        showCloseButton: true,
        customClass: {
            container: 'trainee-info-modal'
        }
    });
}

// Función para limpiar completamente todos los datos del formulario
function clearAllFormData() {
    Swal.fire({
        title: '¿Limpiar Formulario?',
        text: 'Esta acción limpiará todos los datos del formulario. ¿Estás seguro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, limpiar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Limpiar todos los campos del formulario
            const allFields = [
                'session_date', 'session_time', 'access_link', 'committee_mode',
                'attendance_mode', 'offense_class',
                'fault_type', 'offense_classification',
                'statement', 'decision', 'commitments', 
                'missing_rating', 'recommendations', 'observations',
                'general_statements'
            ];
            
            allFields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    field.value = '';
                }
            });
            
            // Limpiar datos almacenados
            window.traineeFormData = null;
            window.sessionData = null;
            window.selectedTraineeInfo = null;
            
            // Ocultar formulario
            hideCommitteeForm();
            
            Swal.fire(
                '¡Formulario Limpiado!',
                'Todos los datos han sido eliminados.',
                'success'
            );
        }
    });
}

// Función para editar la información del aprendiz (ir al formulario)
function editTraineeInfo(traineeIndex, traineeName, actNumber) {
    // Cerrar el modal actual
    Swal.close();
    
    // Ir al formulario para editar
    showCommitteeForm(traineeIndex, traineeName, actNumber);
    
    // Restaurar datos de sesión después de mostrar el formulario
    setTimeout(() => {
        restoreSessionData();
    }, 100);
    
    // Mostrar mensaje informativo
    setTimeout(() => {
            Swal.fire({
            title: 'Modo Edición',
            text: `Ahora puedes editar la información del comité para: ${traineeName}`,
            icon: 'info',
                confirmButtonText: 'Entendido'
            });
    }, 500);
}

// Función para restaurar los datos de sesión globales
function restoreSessionData() {
    if (window.sessionData) {
        const sessionFields = ['session_date', 'session_time', 'access_link', 'committee_mode'];
        sessionFields.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.value = window.sessionData[fieldName];
            }
        });
    }
}

// Función para mostrar el formulario de comité general
function showGeneralCommitteeForm(actNumber, actMinutes) {
    // Mostrar todas las secciones del formulario
    const formSections = document.querySelectorAll('.committee-form-section');
    formSections.forEach(section => {
        section.style.display = 'block';
    });
    
    // Configurar información para modo general
    window.selectedTraineeInfo = {
        index: 'general',
        name: 'Comité General',
        actNumber: actNumber,
        mode: 'General',
        allTrainees: actMinutes
    };
    
    // Limpiar campos individuales pero mantener datos de sesión
    const individualFields = [
        'attendance_mode', 'offense_class',
        'fault_type', 'offense_classification',
        'statement', 'decision', 'commitments', 
        'missing_rating', 'recommendations', 'observations'
    ];
    
    individualFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.value = '';
        }
    });
    
    // Mostrar campos específicos del modo general
    const generalModeFields = document.querySelectorAll('.general-mode-field');
    generalModeFields.forEach(field => {
        field.style.display = 'block';
    });
    
    // Configurar el campo de minutes_id para el primer acta
    const minutesSelect = document.getElementById('minutes_select');
    if (minutesSelect && actMinutes.length > 0) {
        minutesSelect.value = actMinutes[0].minutes_id;
    }
    
    // Actualizar el indicador de aprendiz seleccionado
    const selectedTraineeSpan = document.getElementById('selected_trainee_name');
    if (selectedTraineeSpan) {
        selectedTraineeSpan.textContent = `Comité General - ${actMinutes.length} aprendices`;
    }
    
    // Mostrar alerta informativa
    Swal.fire({
        title: 'Comité General',
        text: `Formulario habilitado para ${actMinutes.length} aprendices del acta #${actNumber}`,
        icon: 'info',
        confirmButtonText: 'Entendido'
    });
    
    // Hacer scroll hacia el formulario
    const firstFormSection = document.querySelector('.committee-form-section');
    if (firstFormSection) {
        firstFormSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>

<style>
.hover-bg-light:hover { background-color: #f8f9fa !important; }
.cursor-pointer { cursor: pointer; }
.card { border: none; border-radius: 10px; }
.card-header { border-radius: 10px 10px 0 0 !important; }
.form-control-lg, .form-select-lg { padding: 0.75rem 1rem; font-size: 1rem; border-radius: 8px; border: 1px solid #ced4da; }
.form-label { margin-bottom: 0.5rem; }
.btn-lg { padding: 0.5rem 1.5rem; font-size: 1.1rem; border-radius: 8px; }
.search-item.active { background-color: #e9ecef !important; }
.form-control, .form-select { border-radius: 6px; border: 1px solid #ced4da; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
.form-control:focus, .form-select:focus { border-color: #86b7fe; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
.form-label { font-weight: 600; color: #495057; margin-bottom: 0.5rem; }
.btn { border-radius: 6px; font-weight: 500; padding: 0.5rem 1rem; }
.card { border: none; border-radius: 10px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
.card-header { border-radius: 10px 10px 0 0 !important; font-weight: 600; }
textarea.form-control { resize: vertical; min-height: 80px; }
.form-text { font-size: 0.875rem; color: #6c757d; }
#detailed_act_info .card { border: 1px solid #dee2e6; margin-bottom: 1rem; }
#detailed_act_info .card-header { padding: 0.75rem 1rem; font-weight: 600; }
#detailed_act_info .card-body { padding: 1rem; }
#trainees_container .card { border: 1px solid #28a745; margin-bottom: 0.5rem; }
#trainees_container .card-header { padding: 0.5rem 1rem; font-size: 0.9rem; }
#trainees_container .card-body { padding: 0.75rem; font-size: 0.9rem; }
.badge { font-size: 0.75rem; }
#detailed_search_results { border: 1px solid #ced4da; border-top: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
#detailed_search_results .search-item:hover { background-color: #f8f9fa; }
@media (max-width: 768px) { #detailed_act_info .row .col-md-4, #detailed_act_info .row .col-md-6 { margin-bottom: 0.5rem; } }
#trainees_container .btn-light { background-color: #f8f9fa; border-color: #dee2e6; color: #495057; font-size: 0.8rem; padding: 0.25rem 0.5rem; }
#trainees_container .btn-light:hover { background-color: #e9ecef; border-color: #adb5bd; color: #212529; }
.committee-form-section { transition: all 0.3s ease-in-out; }
.alert-info { background-color: #d1ecf1; border-color: #bee5eb; color: #0c5460; }

/* Estilos para el modal de información del aprendiz */
.trainee-info-modal .swal2-popup {
    max-width: 900px !important;
}

.trainee-info-modal .swal2-content {
    text-align: left !important;
}

.trainee-info-modal h6 {
    font-weight: 600;
    margin-bottom: 15px;
}

.trainee-info-modal p {
    margin-bottom: 8px;
    line-height: 1.4;
}

.trainee-info-modal .badge {
    font-size: 0.8rem;
}

.trainee-info-modal .bg-light {
    background-color: #f8f9fa !important;
}

/* Estilos para los botones de los aprendices */
#trainees_container .btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: white;
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
    min-width: 32px;
}

#trainees_container .btn-info:hover {
    background-color: #138496;
    border-color: #117a8b;
    color: white;
}

#trainees_container .btn-light {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

#trainees_container .btn-light:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    color: #212529;
}

#trainees_container .card-header {
    flex-wrap: wrap;
    gap: 5px;
}

#trainees_container .d-flex.gap-1 {
    gap: 0.25rem !important;
}
</style>
@endsection
