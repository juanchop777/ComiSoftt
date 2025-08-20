@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Registrar Comité</h3>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Errores de validación --}}
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
                    <div class="col-md-4">
                        <label for="session_date" class="form-label fw-semibold">Fecha Sesión</label>
                                                 <input type="date" class="form-control" name="session_date" required>
                    </div>

                    <div class="col-md-4">
                        <label for="session_time" class="form-label fw-semibold">Hora Sesión</label>
                                                 <input type="time" class="form-control" name="session_time" required>
                    </div>

                    <div class="col-md-4">
                        <label for="access_link" class="form-label fw-semibold">Enlace de Acceso</label>
                                                 <input type="url" class="form-control" name="access_link" placeholder="https://meet.google.com/...">
                        <small class="form-text text-muted">Opcional - Solo para sesiones virtuales</small>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="minutes_search" class="form-label fw-semibold">Buscar Acta</label>
                        <div class="position-relative">
                                                         <input type="text" 
                                    id="minutes_search" 
                                    class="form-control" 
                                    placeholder="Buscar por número de acta o nombre del aprendiz..."
                                    autocomplete="off">
                            <div class="position-absolute top-100 start-0 w-100 bg-white border border-top-0 rounded-bottom shadow-sm d-none" 
                                 id="search_results" 
                                 style="max-height: 200px; overflow-y: auto; z-index: 1000;">
                                <!-- Los resultados aparecerán aquí -->
                            </div>
                        </div>
                        
                                                 <select name="minutes_id" id="minutes_select" class="form-select mt-2 d-none" required>
                            <option value="">Seleccione un acta...</option>
                            @foreach($minutes as $minute)
                                <option value="{{ $minute->minutes_id }}" 
                                        data-trainee="{{ $minute->trainee_name }}"
                                        data-date="{{ $minute->minutes_date }}"
                                        data-search="{{ strtolower($minute->act_number . ' ' . $minute->trainee_name) }}">
                                    Acta #{{ $minute->act_number }} - {{ $minute->trainee_name }} ({{ \Carbon\Carbon::parse($minute->minutes_date)->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        
                        <div id="selected_act" class="mt-2 d-none">
                            <div class="alert alert-info mb-0">
                                <strong>Acta seleccionada:</strong> <span id="selected_act_text"></span>
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" id="change_act">Cambiar</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="trainee_name" class="form-label fw-semibold">Nombre Aprendiz</label>
                                                 <input type="text" class="form-control" name="trainee_name" readonly>
                    </div>

                    <div class="col-md-3">
                        <label for="minutes_date" class="form-label fw-semibold">Fecha Acta</label>
                                                 <input type="date" class="form-control" name="minutes_date" readonly>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="attendance_mode" class="form-label fw-semibold">Modalidad Asistencia</label>
                                                 <select name="attendance_mode" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Virtual">Virtual</option>
                            <option value="No asistió">No asistió</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Información de la Falta --}}
        <div class="card mb-4 shadow-sm">
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

        {{-- Decisiones y Seguimiento --}}
        <div class="card mb-4 shadow-sm">
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

        <div class="d-flex gap-2 mb-4">
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
    const minutesSelect = document.getElementById('minutes_select');
    const traineeNameInput = document.querySelector('input[name="trainee_name"]');
    const searchInput = document.getElementById('minutes_search');
    const searchResults = document.getElementById('search_results');
    const selectedActDiv = document.getElementById('selected_act');
    const selectedActText = document.getElementById('selected_act_text');
    const changeActBtn = document.getElementById('change_act');
    const minutesDateInput = document.querySelector('input[name="minutes_date"]');
    
    // Datos de las actas
    const minutesData = @json($minutes->keyBy('minutes_id'));
    const allMinutes = @json($minutes->values());
    
    let isActSelected = false;
    
    // Función para mostrar/ocultar elementos según el estado
    function toggleVisibility() {
        if (isActSelected) {
            searchInput.classList.add('d-none');
            selectedActDiv.classList.remove('d-none');
            searchResults.classList.add('d-none');
        } else {
            searchInput.classList.remove('d-none');
            selectedActDiv.classList.add('d-none');
            searchInput.focus();
        }
    }
    
    // Función para seleccionar un acta
    function selectAct(minuteId, optionText) {
        minutesSelect.value = minuteId;
        selectedActText.textContent = optionText;
        
        // Autocompletar el nombre del aprendiz
        if (minutesData[minuteId] && minutesData[minuteId].trainee_name) {
            traineeNameInput.value = minutesData[minuteId].trainee_name;
        }
        
        // Autocompletar la fecha del acta
        if (minutesDateInput && minutesData[minuteId]) {
            let dateValue = minutesData[minuteId].minutes_date || 
                           minutesData[minuteId].date || 
                           minutesData[minuteId].created_at;
            
            if (dateValue) {
                if (typeof dateValue === 'string') {
                    if (dateValue.includes('T')) {
                        const date = new Date(dateValue);
                        const year = date.getUTCFullYear();
                        const month = String(date.getUTCMonth() + 1).padStart(2, '0');
                        const day = String(date.getUTCDate()).padStart(2, '0');
                        dateValue = `${year}-${month}-${day}`;
                    }
                    else if (dateValue.includes(' ')) {
                        dateValue = dateValue.split(' ')[0];
                    }
                    else if (dateValue.includes('/')) {
                        const parts = dateValue.split('/');
                        if (parts.length === 3) {
                            dateValue = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                        }
                    }
                }
                minutesDateInput.value = dateValue;
            }
        }
        
        isActSelected = true;
        searchInput.value = '';
        toggleVisibility();
    }
    
    // Búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            searchResults.classList.add('d-none');
            searchResults.innerHTML = '';
            return;
        }
        
        // Filtrar actas
        const filteredMinutes = allMinutes.filter(minute => {
            const searchText = (minute.act_number + ' ' + minute.trainee_name).toLowerCase();
            return searchText.includes(searchTerm);
        });
        
        // Mostrar resultados
        if (filteredMinutes.length > 0) {
            let html = '';
            filteredMinutes.slice(0, 10).forEach(minute => {
                let displayDate;
                if (minute.minutes_date) {
                    if (minute.minutes_date.includes('T')) {
                        const date = new Date(minute.minutes_date);
                        const year = date.getUTCFullYear();
                        const month = String(date.getUTCMonth() + 1).padStart(2, '0');
                        const day = String(date.getUTCDate()).padStart(2, '0');
                        displayDate = `${day}/${month}/${year}`;
                    } else {
                        displayDate = new Date(minute.minutes_date).toLocaleDateString('es-CO');
                    }
                } else {
                    displayDate = 'Sin fecha';
                }
                
                html += `
                    <div class="search-item p-2 border-bottom cursor-pointer hover-bg-light" 
                         data-minutes-id="${minute.minutes_id}"
                         style="cursor: pointer;">
                        <div class="fw-semibold">Acta #${minute.act_number}</div>
                        <div class="text-muted small">${minute.trainee_name} - ${displayDate}</div>
                    </div>
                `;
            });
            
            if (filteredMinutes.length > 10) {
                html += `<div class="p-2 text-muted text-center small">... y ${filteredMinutes.length - 10} resultados más</div>`;
            }
            
            searchResults.innerHTML = html;
            searchResults.classList.remove('d-none');
        } else {
            searchResults.innerHTML = '<div class="p-2 text-muted text-center">No se encontraron actas</div>';
            searchResults.classList.remove('d-none');
        }
    });
    
    // Seleccionar acta desde los resultados de búsqueda
    searchResults.addEventListener('click', function(e) {
        const searchItem = e.target.closest('.search-item');
        if (searchItem) {
            const minuteId = searchItem.dataset.minutesId;
            const minute = minutesData[minuteId];
            const date = new Date(minute.minutes_date).toLocaleDateString('es-CO');
            const optionText = `Acta #${minute.act_number} - ${minute.trainee_name} (${date})`;
            selectAct(minuteId, optionText);
        }
    });
    
    // Botón para cambiar acta
    changeActBtn.addEventListener('click', function() {
        isActSelected = false;
        minutesSelect.value = '';
        traineeNameInput.value = '';
        minutesDateInput.value = '';
        toggleVisibility();
    });
    
    // Cerrar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('d-none');
        }
    });
    
    // Navegación con teclado
    searchInput.addEventListener('keydown', function(e) {
        const items = searchResults.querySelectorAll('.search-item');
        let currentIndex = -1;
        
        items.forEach((item, index) => {
            if (item.classList.contains('active')) {
                currentIndex = index;
            }
        });
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
        } else if (e.key === 'Enter' && currentIndex >= 0) {
            e.preventDefault();
            items[currentIndex].click();
            return;
        } else {
            return;
        }
        
        items.forEach((item, index) => {
            if (index === currentIndex) {
                item.classList.add('active', 'bg-light');
            } else {
                item.classList.remove('active', 'bg-light');
            }
        });
    });
    
    // Inicializar visibilidad
    toggleVisibility();
});

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
            // Si confirma, navegar a la página de índice
            window.location.href = '{{ route('committee.index') }}';
        }
    });
}

// Mostrar alerta de éxito si hay mensaje de sesión
@if(session('success'))
    Swal.fire({
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
@endif

// Mostrar alerta de error si hay errores de validación
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
</script>

<style>
.hover-bg-light:hover {
    background-color: #f8f9fa !important;
}
.cursor-pointer {
    cursor: pointer;
}
.card {
    border: none;
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
.form-control-lg, .form-select-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 8px;
    border: 1px solid #ced4da;
}
.form-label {
    margin-bottom: 0.5rem;
}
.btn-lg {
    padding: 0.5rem 1.5rem;
    font-size: 1.1rem;
    border-radius: 8px;
}
.search-item.active {
    background-color: #e9ecef !important;
}

.form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
    padding: 0.5rem 1rem;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
    font-weight: 600;
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}
</style>
@endsection