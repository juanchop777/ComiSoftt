@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            </div>
            <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <form id="minutes-form" action="{{ route('minutes.store') }}" method="POST">
        @csrf

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">SERVICIO NACIONAL DE APRENDIZAJE</h1>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">CENTRO DE FORMACIÓN AGROINDUSTRIAL</h2>
            <h3 class="text-lg text-gray-600">CONSOLIDADO DE NOVEDADES ACADÉMICAS Y DISCIPLINARIAS</h3>
        </div>

        <!-- Paso 1: Persona que reporta -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6 form-step" data-step="1">
            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Persona que Reporta
                </h3>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                    <input type="text" name="full_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico *</label>
                        <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                        <input type="text" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <!-- Botón del paso 1 -->
                <div class="flex justify-end mt-6">
                    <button type="button" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors next-step">
                        Siguiente <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Paso 2: Detalles del Acta -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6 form-step hidden" data-step="2">
            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-file-alt mr-2"></i>
                    Detalles del Acta
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Número de Acta *</label>
                        <input type="text" name="act_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del Acta *</label>
                        <input type="date" name="minutes_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ date('Y-m-d') }}" 
                               max="{{ date('Y-m-d') }}" 
                               required>
                        <p class="text-sm text-gray-500 mt-1">No puede ser posterior a la fecha actual</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Centro de Formación *</label>
                        <input type="text" name="training_center" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
                
                <!-- Botones del paso 2 -->
                <div class="flex justify-between mt-6">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors prev-step">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </button>
                    <button type="button" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors next-step">
                        Siguiente <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Paso 3: Bloques dinámicos -->
        <div id="dynamic-sections" class="form-step hidden" data-step="3">
            <div class="dynamic-block mb-6">
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i>
                            Información del Aprendiz
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Botón eliminar aprendiz en la esquina derecha -->
                        <div class="flex justify-end mb-4">
                            <button type="button" class="p-2 text-red-600 hover:text-red-800 transition-colors remove-section hidden" title="Eliminar aprendiz">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Aprendiz *</label>
                                <input type="text" name="trainee_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono del Aprendiz</label>
                                <input type="text" name="trainee_phone[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 3001234567">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento *</label>
                                <select name="document_type[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Seleccione...</option>
                                    <option value="CC">Cédula de Ciudadanía</option>
                                    <option value="CE">Cédula de Extranjería</option>
                                    <option value="TI">Tarjeta de Identidad</option>
                                    <option value="PEP">Permiso especial de permanencia</option>
                                    <option value="DNI">DNI - Documento Nacional de Identificación</option>
                                    <option value="NCS">Número Ciego SENA</option>
                                    <option value="PA">Pasaporte</option>
                                    <option value="PPT">Permiso por Protección Temporal</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número de Documento *</label>
                                <input type="text" name="id_document[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Programa de Formación *</label>
                                <input type="text" name="program_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número de Ficha *</label>
                                <input type="text" name="batch_number[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Programa *</label>
                                <input type="text" name="program_type[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado del Aprendiz *</label>
                                <input type="text" name="trainee_status[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo del Aprendiz</label>
                            <input type="email" name="trainee_email[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Tiene Contrato?</label>
                            <select name="has_contract[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 has-contract">
                                <option value=""></option>
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>

                        <div class="company-fields hidden">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-4">
                                <div class="bg-gray-600 text-white px-4 py-3 rounded-lg mb-4">
                                    <h4 class="text-md font-semibold flex items-center">
                                        <i class="fas fa-building mr-2"></i>
                                        Información de la Empresa
                                    </h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Empresa</label>
                                        <input type="text" name="company_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                                        <input type="text" name="company_address[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                        </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Responsable RH</label>
                                        <input type="text" name="hr_manager_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Contacto</label>
                                        <input type="text" name="company_contact[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-4">
                            <div class="bg-gray-600 text-white px-4 py-3 rounded-lg mb-4">
                                <h4 class="text-md font-semibold flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Novedad
                                </h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Novedad</label>
                                    <select name="incident_type[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 incident-type">
                                        <option value="">Seleccione...</option>
                                        <option value="CANCELACION_MATRICULA_ACADEMICO">CANCELACIÓN MATRÍCULA ÍNDOLE ACADÉMICO</option>
                                        <option value="CANCELACION_MATRICULA_DISCIPLINARIO">CANCELACIÓN MATRÍCULA ÍNDOLE DISCIPLINARIO</option>
                                        <option value="CONDICIONAMIENTO_MATRICULA">CONDICIONAMIENTO DE MATRÍCULA</option>
                                        <option value="DESERCION_PROCESO_FORMACION">DESERCIÓN PROCESO DE FORMACIÓN</option>
                                        <option value="NO_GENERACION_CERTIFICADO">NO GENERACIÓN-CERTIFICADO</option>
                                        <option value="RETIRO_POR_FRAUDE">RETIRO POR FRAUDE</option>
                                        <option value="RETIRO_PROCESO_FORMACION">RETIRO PROCESO DE FORMACIÓN</option>
                                        <option value="TRASLADO_CENTRO">TRASLADO DE CENTRO</option>
                                        <option value="TRASLADO_JORNADA">TRASLADO DE JORNADA</option>
                                        <option value="TRASLADO_PROGRAMA">TRASLADO DE PROGRAMA</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtipo de Novedad</label>
                                    <select name="incident_subtype[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 incident-subtype" disabled>
                                        <option value="">Seleccione...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                                <textarea name="incident_description[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 incident-description" required></textarea>
                    </div>
                </div>
            </div>
            
                <!-- Botones del paso 3 en la esquina derecha de la card - SOLO EN EL ÚLTIMO APRENDIZ -->
                <div class="flex justify-between mt-6 action-buttons hidden">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors prev-step">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </button>
                    <div class="flex gap-3">
                        <button type="button" id="add-section" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Agregar Aprendiz
                        </button>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-save mr-2"></i> Guardar Acta
                    </button>
                    </div>
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
        steps.forEach(s => {
            s.classList.add('hidden');
            s.classList.remove('block');
        });
        const currentStep = document.querySelector(`[data-step="${step}"]`);
        currentStep.classList.remove('hidden');
        currentStep.classList.add('block');
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
                input.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                input.classList.remove('border-gray-300');
                isValid = false;
            } else {
                input.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
                input.classList.add('border-gray-300');
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
            if (e.target.value === '1') {
                companyFields.classList.remove('hidden');
                companyFields.classList.add('block');
            } else {
                companyFields.classList.add('hidden');
                companyFields.classList.remove('block');
            }
        }
        
        // Manejar subtipo de novedad
        if (e.target.classList.contains('incident-type')) {
            const subtypeSelect = e.target.closest('.dynamic-block').querySelector('.incident-subtype');
            if (e.target.value) {
                subtypeSelect.disabled = false;
                
                // Cargar subtipos específicos según el tipo seleccionado
                if (e.target.value === 'CANCELACION_MATRICULA_ACADEMICO') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="INCUMPLIMIENTO_CONTRATO_APRENDIZAJE">INCUMPLIMIENTO CONTRATO DE APRENDIZAJE</option>
                        <option value="NO_CUMPLIO_PLAN_MEJORAMIENTO">NO CUMPLIÓ PLAN DE MEJORAMIENTO</option>
                    `;
                } else if (e.target.value === 'CANCELACION_MATRICULA_DISCIPLINARIO') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="NO_CUMPLIO_PLAN_MEJORAMIENTO">NO CUMPLIÓ PLAN DE MEJORAMIENTO</option>
                        <option value="SANCION_IMPUESTA_MEDIANTE_DEBIDO_PROCESO">SANCIÓN IMPUESTA MEDIANTE DEBIDO PROCESO</option>
                    `;
                } else if (e.target.value === 'CONDICIONAMIENTO_MATRICULA') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="CONCERTACION_PLAN_DE_MEJORAMIENTO">CONCERTACIÓN PLAN DE MEJORAMIENTO</option>
                    `;
                } else if (e.target.value === 'DESERCION_PROCESO_FORMACION') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="INCUMPLIMIENTO_INASISTENCIA_3_DIAS">INCUMPLIMIENTO - INASISTENCIA 3 DIAS CONSECUTIVOS O MÁS SIN JUSTIFICACIÓN</option>
                        <option value="NO_PRESENTA_EVIDENCIA_ETAPA_PRODUCTIVA">NO PRESENTA EVIDENCIA REALIZACIÓN ETAPA PRODUCTIVA</option>
                        <option value="NO_SE_REINTEGRA_APLAZAMIENTO">NO SE REINTEGRA A PARTIR DE LA FECHA LÍMITE AUTORIZADO APLAZAMIENTO</option>
                    `;
                } else if (e.target.value === 'NO_GENERACION_CERTIFICADO') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="FORMACION_NO_REALIZADA">FORMACIÓN NO REALIZADA</option>
                        <option value="PROGRAMA_DE_FORMACION_REALIZADO_NO_CORRESPONDE">PROGRAMA DE FORMACIÓN REALIZADO NO CORRESPONDE</option>
                    `;
                } else if (e.target.value === 'RETIRO_POR_FRAUDE') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="SUPLANTACION_DATOS_BASICOS_PARA_CERTIFICARSE">SUPLANTACIÓN DATOS BÁSICOS PARA CERTIFICARSE</option>
                    `;
                } else if (e.target.value === 'RETIRO_PROCESO_FORMACION') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="NO_INICIO_PROCESO_FORMACION">NO INICIÓ PROCESO DE FORMACIÓN</option>
                        <option value="POR_FALLECIMIENTO">POR FALLECIMIENTO</option>
                    `;
                } else if (e.target.value === 'TRASLADO_CENTRO') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="CAMBIO_DE_DOMICILIO">CAMBIO DE DOMICILIO</option>
                        <option value="MOTIVOS_LABORALES">MOTIVOS LABORALES</option>
                        <option value="MOTIVOS_PERSONALES">MOTIVOS PERSONALES</option>
                    `;
                } else if (e.target.value === 'TRASLADO_JORNADA') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="MOTIVOS_LABORALES">MOTIVOS LABORALES</option>
                        <option value="MOTIVOS_PERSONALES">MOTIVOS PERSONALES</option>
                    `;
                } else if (e.target.value === 'TRASLADO_PROGRAMA') {
                    subtypeSelect.innerHTML = `
                        <option value="">Seleccionar Subtipo de Novedad</option>
                        <option value="MOTIVOS_PERSONALES">MOTIVOS PERSONALES</option>
                    `;
                } else {
                    // Para otros tipos de novedad, mostrar opción genérica
                    subtypeSelect.innerHTML = '<option value="">Seleccione...</option>';
                }
            } else {
                subtypeSelect.disabled = true;
                subtypeSelect.innerHTML = '<option value="">Seleccione...</option>';
            }
        }
    });

    // Agregar nuevo bloque
    document.addEventListener('click', function(e) {
        if (e.target.id === 'add-section' || e.target.closest('#add-section')) {
        const blocks = container.querySelectorAll('.dynamic-block');
        const lastBlock = blocks[blocks.length - 1];
        const newBlock = lastBlock.cloneNode(true);
        
        // Mostrar botón de eliminar en el nuevo bloque
        const removeBtn = newBlock.querySelector('.remove-section');
        removeBtn.classList.remove('hidden');
        removeBtn.classList.add('block');
        
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
                if (companyFields) {
                    companyFields.classList.add('hidden');
                    companyFields.classList.remove('block');
                }
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
        
        container.appendChild(newBlock);
        updateRemoveButtons();
        
        // Desplazar los botones hacia abajo cuando se agrega un aprendiz
        setTimeout(() => {
            const buttonsContainer = document.querySelector('.action-buttons:not(.hidden)');
            if (buttonsContainer) {
                buttonsContainer.scrollIntoView({ behavior: 'smooth', block: 'end' });
            }
        }, 100);
        }
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
            const actionButtons = block.querySelector('.action-buttons');
            
            if (removeBtn) {
                if (index > 0) {
                    removeBtn.classList.remove('hidden');
                    removeBtn.classList.add('block');
                } else {
                    removeBtn.classList.add('hidden');
                    removeBtn.classList.remove('block');
                }
            }
            
            // Solo mostrar botones de acción en el último bloque
            if (actionButtons) {
                if (index === blocks.length - 1) {
                    actionButtons.classList.remove('hidden');
                    actionButtons.classList.add('block');
                } else {
                    actionButtons.classList.add('hidden');
                    actionButtons.classList.remove('block');
                }
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