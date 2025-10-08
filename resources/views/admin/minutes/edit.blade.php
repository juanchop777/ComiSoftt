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

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Errores encontrados:</strong>
                </div>
                <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="minutes-form" action="{{ route('minutes.update', $actNumber) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">SERVICIO NACIONAL DE APRENDIZAJE</h1>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">CENTRO DE FORMACIÓN AGROINDUSTRIAL</h2>
            <h3 class="text-lg text-gray-600">EDITAR NOVEDADES - ACTA #{{ $actNumber }}</h3>
        </div>

        <!-- Persona que reporta -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Persona que Reporta
                </h3>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                    <input type="text" name="full_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           value="{{ old('full_name', $reportingPerson->full_name) }}" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico *</label>
                        <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ old('email', $reportingPerson->email) }}" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                        <input type="text" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ old('phone', $reportingPerson->phone) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles del Acta -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
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
                        <input type="text" name="act_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ old('act_number', $actNumber) }}" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del Acta *</label>
                        <input type="date" name="minutes_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ old('minutes_date', $minutesDate) }}" 
                               max="{{ date('Y-m-d') }}" required>
                        <p class="text-sm text-gray-500 mt-1">No puede ser posterior a la fecha actual</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloques de aprendices -->
        @foreach($minutes as $index => $minute)
        <div class="dynamic-block mb-6" data-id="{{ $minute->minutes_id }}">
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg flex justify-between items-center relative">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-user-graduate mr-2"></i>
                        Aprendiz #{{ $index + 1 }}
                    </h3>
                    @if($index > 0)
                    <button type="button" class="p-2 text-white hover:text-red-200 transition-colors remove-apprentice" title="Eliminar aprendiz">
                        <i class="fas fa-trash"></i>
                    </button>
                    @endif
                </div>
                <div class="p-6">
                    <input type="hidden" name="minutes_ids[]" value="{{ $minute->minutes_id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Aprendiz *</label>
                            <input type="text" name="trainee_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   value="{{ old("trainee_name.$index", $minute->trainee_name) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Documento de Identidad *</label>
                            <input type="text" name="id_document[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   value="{{ old("id_document.$index", $minute->id_document) }}" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Programa de Formación *</label>
                            <input type="text" name="program_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   value="{{ old("program_name.$index", $minute->program_name) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Número de Ficha *</label>
                            <input type="text" name="batch_number[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   value="{{ old("batch_number.$index", $minute->batch_number) }}" required>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Correo del Aprendiz</label>
                        <input type="email" name="trainee_email[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ old("trainee_email.$index", $minute->email) }}">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">¿Tiene Contrato?</label>
                        <select name="has_contract[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 has-contract">
                            <option value="0" {{ old("has_contract.$index", $minute->has_contract) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old("has_contract.$index", $minute->has_contract) == 1 ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>

                    <div class="company-fields {{ old("has_contract.$index", $minute->has_contract) ? 'block' : 'hidden' }}">
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
                                    <input type="text" name="company_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           value="{{ old("company_name.$index", $minute->company_name) }}">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                                    <input type="text" name="company_address[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           value="{{ old("company_address.$index", $minute->company_address) }}">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Responsable RH</label>
                                    <input type="text" name="hr_manager_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           value="{{ old("hr_manager_name.$index", $minute->hr_manager_name) }}">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Contacto</label>
                                    <input type="text" name="company_contact[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           value="{{ old("company_contact.$index", $minute->company_contact) }}">
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
                                <option value="Academic" {{ old("incident_type.$index", $minute->incident_type) == 'Academic' ? 'selected' : '' }}>Académica</option>
                                <option value="Disciplinary" {{ old("incident_type.$index", $minute->incident_type) == 'Disciplinary' ? 'selected' : '' }}>Disciplinaria</option>
                                <option value="Dropout" {{ old("incident_type.$index", $minute->incident_type) == 'Dropout' ? 'selected' : '' }}>Deserción</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                            <textarea name="incident_description[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 incident-description" required>{{ old("incident_description.$index", $minute->incident_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="flex justify-between mt-6">
            <a href="{{ route('minutes.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
            <div class="flex gap-3">
                <button type="button" id="add-apprentice" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i> Agregar Aprendiz
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para actualizar números de aprendices
    function updateApprenticeNumbers() {
        document.querySelectorAll('.dynamic-block').forEach((block, index) => {
            const header = block.querySelector('h3');
            if (header) {
                header.textContent = `Aprendiz #${index + 1}`;
            }
        });
    }

    // Función para activar el toggle de contrato
    function initContractToggle(select) {
        select.addEventListener('change', function() {
            const companyFields = this.closest('.dynamic-block').querySelector('.company-fields');
            if (this.value === '1') {
                companyFields.classList.remove('hidden');
                companyFields.classList.add('block');
            } else {
                companyFields.classList.add('hidden');
                companyFields.classList.remove('block');
            }
        });
        // Disparar el evento change para inicializar el estado
        select.dispatchEvent(new Event('change'));
    }

    // Inicializar los selects de contrato existentes
    document.querySelectorAll('.has-contract').forEach(initContractToggle);

    // Eliminar aprendiz
    document.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-apprentice');
        
        if (removeBtn) {
            const block = removeBtn.closest('.dynamic-block');
            const apprenticeId = block.getAttribute('data-id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente al aprendiz",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (!apprenticeId) {
                        block.remove();
                        updateApprenticeNumbers();
                        return;
                    }

                    fetch(`/minutes/${apprenticeId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            block.remove();
                            updateApprenticeNumbers();
                            Swal.fire(
                                'Eliminado!',
                                'El aprendiz ha sido eliminado correctamente.',
                                'success'
                            );
                        } else {
                            throw new Error(data.message || 'Error al eliminar el aprendiz');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error',
                            'Ocurrió un error al intentar eliminar el aprendiz: ' + error.message,
                            'error'
                        );
                    });
                }
            });
        }
    });

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
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3085d6'
                });
                this.value = '';
            }
        });
    }

    // Agregar nuevo aprendiz - Versión final que mantiene TODOS los campos solicitados
    document.getElementById('add-apprentice')?.addEventListener('click', function() {
        const blocks = document.querySelectorAll('.dynamic-block');
        if (blocks.length === 0) return;

        const lastBlock = blocks[blocks.length - 1];
        const newBlock = lastBlock.cloneNode(true);

        // Limpiar SOLO los campos que deben ser únicos para cada aprendiz
        newBlock.querySelectorAll('input[type="text"], input[type="email"]').forEach(input => {
            // Mantener batch_number[], program_name[] y minutes_ids[]
            if (!input.name.includes('batch_number') && 
                !input.name.includes('program_name') &&
                !input.name.includes('minutes_ids')) {
                // Limpiar solo estos campos:
                if (input.name.includes('trainee_name') || 
                   input.name.includes('id_document') || 
                   input.name.includes('trainee_email') || 
                   input.name.includes('company_name') || 
                   input.name.includes('company_address') || 
                   input.name.includes('hr_manager_name') || 
                   input.name.includes('company_contact')) {
                    input.value = '';
                }
            }
        });

        // Mantener el tipo de novedad (no resetear este select)
        // Resetear solo el select de contrato
        newBlock.querySelectorAll('select').forEach(select => {
            if (!select.classList.contains('incident-type')) {
                select.selectedIndex = 0;
            }
        });

        // Limpiar el ID del acta para nuevos registros
        newBlock.querySelector('input[name="minutes_ids[]"]').value = '';
        newBlock.setAttribute('data-id', '');

        // Renombrar título
        const newIndex = blocks.length + 1;
        const header = newBlock.querySelector('h3');
        if (header) {
            header.textContent = `Aprendiz #${newIndex}`;
        }

        // Asegurar que el botón de eliminar esté presente
        const headerDiv = newBlock.querySelector('.bg-blue-600');
        if (!headerDiv.querySelector('.remove-apprentice')) {
            const btn = document.createElement('button');
            btn.type = "button";
            btn.className = "p-2 text-white hover:text-red-200 transition-colors remove-apprentice";
            btn.title = "Eliminar aprendiz";
            btn.innerHTML = '<i class="fas fa-trash"></i>';
            headerDiv.appendChild(btn);
        }

        // Insertar el nuevo bloque después del último
        lastBlock.after(newBlock);

        // Inicializar el toggle de contrato en el nuevo bloque
        newBlock.querySelectorAll('.has-contract').forEach(initContractToggle);
    });
});
</script>
@endsection