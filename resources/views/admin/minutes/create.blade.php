@extends('layouts.admin')

@section('content')
<div class="container p-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form id="minutes-form" action="{{ route('minutes.store') }}" method="POST">
        @csrf

        <div class="text-center mb-4">
            <h1>SERVICIO NACIONAL DE APRENDIZAJE</h1>
            <h2>CENTRO DE FORMACIÓN AGROINDUSTRIAL</h2>
            <h3 class="mt-3">CONSOLIDADO DE NOVEDADES ACADÉMICAS Y DISCIPLINARIAS</h3>
        </div>

        <!-- Paso 1: Persona que reporta -->
        <div class="card mb-4 form-step" data-step="1">
            <div class="card-header bg-primary text-white">
                <strong>Persona que Reporta</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nombre Completo *</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary prev-step" style="display:none;">
                        <i class="fas fa-arrow-left"></i> Anterior
                    </button>
                    <button type="button" class="btn btn-primary next-step">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Paso 2: Detalles del Acta -->
        <div class="card mb-4 form-step" data-step="2" style="display:none;">
            <div class="card-header bg-primary text-white">
                <strong>Detalles del Acta</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Número de Acta *</label>
                        <input type="text" name="act_number" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha del Acta *</label>
                        <input type="date" name="minutes_date" class="form-control" 
                               value="{{ date('Y-m-d') }}" 
                               max="{{ date('Y-m-d') }}" 
                               required>
                        <small class="text-muted">No puede ser posterior a la fecha actual</small>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary prev-step">
                        <i class="fas fa-arrow-left"></i> Anterior
                    </button>
                    <button type="button" class="btn btn-primary next-step">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Paso 3: Bloques dinámicos -->
        <div id="dynamic-sections" class="form-step" data-step="3" style="display:none;">
            <div class="dynamic-block mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center position-relative" style="padding-right: 40px;">
                        <strong>Información del Aprendiz</strong>
                        <!-- Botón eliminar (oculto en el primer bloque) -->
                        <button type="button" class="btn btn-link text-white p-0 remove-section position-absolute" title="Eliminar aprendiz" style="right: 10px; display: none;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Aprendiz *</label>
                                <input type="text" name="trainee_name[]" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Documento de Identidad *</label>
                                <input type="text" name="id_document[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Programa de Formación *</label>
                                <input type="text" name="program_name[]" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Número de Ficha *</label>
                                <input type="text" name="batch_number[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo del Aprendiz</label>
                            <input type="email" name="trainee_email[]" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Tiene Contrato?</label>
                            <select name="has_contract[]" class="form-select has-contract">
                                <option value=""></option>
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>

                        <div class="company-fields" style="display: none;">
                            <div class="card mt-3">
                                <div class="card-header bg-secondary text-white">
                                    <strong>Información de la Empresa</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nombre de la Empresa</label>
                                            <input type="text" name="company_name[]" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Dirección</label>
                                            <input type="text" name="company_address[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Responsable TH</label>
                                            <input type="text" name="hr_manager_name[]" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Contacto</label>
                                            <input type="text" name="company_contact[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header bg-secondary text-white">
                                <strong>Novedad</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Novedad</label>
                                    <select name="incident_type[]" class="form-select incident-type">
                                        <option value="">Seleccione...</option>
                                        <option value="Academic">Académica</option>
                                        <option value="Disciplinary">Disciplinaria</option>
                                        <option value="Dropout">Deserción</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Descripción *</label>
                                    <textarea name="incident_description[]" rows="3" class="form-control incident-description" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones finales - SOLO EN EL ÚLTIMO PASO -->
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary prev-step">
                    <i class="fas fa-arrow-left"></i> Volver
                </button>
                <div>
                    <button type="button" id="add-section" class="btn btn-primary me-2">
                        <i class="fas fa-plus"></i> Agregar Aprendiz
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Acta
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de pasos del formulario
    let currentStep = 1;
    const steps = document.querySelectorAll('.form-step');
    const totalSteps = steps.length;

    function showStep(step) {
        steps.forEach(s => s.style.display = 'none');
        document.querySelector(`[data-step="${step}"]`).style.display = 'block';
    }

    document.querySelectorAll('.next-step').forEach(btn => {
        btn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        });
    });

    document.querySelectorAll('.prev-step').forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    function validateStep(step) {
        let isValid = true;
        const currentStepEl = document.querySelector(`[data-step="${step}"]`);
        
        currentStepEl.querySelectorAll('[required]').forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Campos requeridos',
                text: 'Por favor complete todos los campos obligatorios',
                confirmButtonColor: '#3085d6'
            });
        }

        return isValid;
    }

    // Manejo de bloques dinámicos
    const container = document.getElementById('dynamic-sections');
    
    // Mostrar/ocultar campos de empresa
    container.addEventListener('change', function(e) {
        if (e.target.classList.contains('has-contract')) {
            const companyFields = e.target.closest('.dynamic-block').querySelector('.company-fields');
            companyFields.style.display = e.target.value === '1' ? 'block' : 'none';
        }
    });

    // Agregar nuevo bloque
    document.getElementById('add-section').addEventListener('click', function() {
        const blocks = container.querySelectorAll('.dynamic-block');
        const lastBlock = blocks[blocks.length - 1];
        const newBlock = lastBlock.cloneNode(true);
        
        // Mostrar botón de eliminar en el nuevo bloque
        const removeBtn = newBlock.querySelector('.remove-section');
        removeBtn.style.display = 'block';
        removeBtn.style.right = '10px';
        
        // Obtener valores del último bloque
        const lastIncidentType = lastBlock.querySelector('.incident-type').value;
        const lastIncidentDescription = lastBlock.querySelector('.incident-description').value;
        
        // Limpiar inputs (excepto algunos campos)
        newBlock.querySelectorAll('input, textarea, select').forEach(el => {
            if (!['program_name[]', 'batch_number[]'].includes(el.name)) {
                if (el.name === 'incident_type[]') {
                    el.value = lastIncidentType;
                } else if (el.name === 'incident_description[]') {
                    el.value = lastIncidentDescription;
                } else {
                    el.value = '';
                }
            }
                if (el.name === 'has_contract[]') {
        el.value = ''; // deja vacío
        const companyFields = newBlock.querySelector('.company-fields');
        if (companyFields) companyFields.style.display = 'none'; // asegura que quede oculto
    }

        });
        
        // Agregar evento de eliminación
        removeBtn.addEventListener('click', function() {
            Swal.fire({
                title: '¿Eliminar aprendiz?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    newBlock.remove();
                    updateRemoveButtons();
                }
            });
        });
        
        container.insertBefore(newBlock, document.querySelector('#dynamic-sections > .d-flex'));
        updateRemoveButtons();
    });

    // Eliminar bloque
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-section') || 
            (e.target.closest && e.target.closest('.remove-section'))) {
            Swal.fire({
                title: '¿Eliminar aprendiz?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const removeBtn = e.target.classList.contains('remove-section') ? 
                                    e.target : e.target.closest('.remove-section');
                    removeBtn.closest('.dynamic-block').remove();
                    updateRemoveButtons();
                }
            });
        }
    });

    // Mostrar botón eliminar solo si hay más de un bloque
    function updateRemoveButtons() {
        const blocks = container.querySelectorAll('.dynamic-block');
        blocks.forEach((block, index) => {
            const removeBtn = block.querySelector('.remove-section');
            if (removeBtn) {
                removeBtn.style.display = index > 0 ? 'block' : 'none';
                removeBtn.style.right = '10px';
            }
        });
    }

    // Validar fecha del acta
    const minutesDateInput = document.querySelector('input[name="minutes_date"]');
    if (minutesDateInput) {
        minutesDateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate > today) {
                Swal.fire({
                    icon: 'error',
                    title: 'Fecha inválida',
                    text: 'La fecha del acta no puede ser posterior a la fecha actual',
                    confirmButtonColor: '#3085d6'
                });
                this.value = '';
            }
        });
    }

    // Inicializar
    showStep(currentStep);
    updateRemoveButtons();
});
</script>
@endsection