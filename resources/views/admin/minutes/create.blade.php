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
                <div class="flex justify-between mt-6">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors prev-step hidden">
                        <i class="fas fa-arrow-left mr-2"></i> Anterior
                    </button>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                </div>
                <div class="flex justify-between mt-6">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors prev-step">
                        <i class="fas fa-arrow-left mr-2"></i> Anterior
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
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg flex justify-between items-center relative">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i>
                            Información del Aprendiz
                        </h3>
                        <!-- Botón eliminar (oculto en el primer bloque) -->
                        <button type="button" class="p-2 text-white hover:text-red-200 transition-colors remove-section hidden" title="Eliminar aprendiz">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Aprendiz *</label>
                                <input type="text" name="trainee_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Documento de Identidad *</label>
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
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Novedad</label>
                                <select name="incident_type[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 incident-type">
                                    <option value="">Seleccione...</option>
                                    <option value="Academic">Académica</option>
                                    <option value="Disciplinary">Disciplinaria</option>
                                    <option value="Dropout">Deserción</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                                <textarea name="incident_description[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 incident-description" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones finales - SOLO EN EL ÚLTIMO PASO -->
            <div class="flex justify-between mt-6">
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
    });

    // Agregar nuevo bloque
    document.getElementById('add-section').addEventListener('click', function() {
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
                if (index > 0) {
                    removeBtn.classList.remove('hidden');
                    removeBtn.classList.add('block');
                } else {
                    removeBtn.classList.add('hidden');
                    removeBtn.classList.remove('block');
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