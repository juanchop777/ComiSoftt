@extends('layouts.admin')

@section('content')
<div class="container p-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any()))
        <div class="alert alert-danger alert-dismissible fade show">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form id="minutes-form" action="{{ route('minutes.update', $actNumber) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="text-center mb-4">
            <h1>SERVICIO NACIONAL DE APRENDIZAJE</h1>
            <h2>CENTRO DE FORMACIÓN AGROINDUSTRIAL</h2>
            <h3 class="mt-3">EDITAR NOVEDADES - ACTA #{{ $actNumber }}</h3>
        </div>

        <!-- Persona que reporta -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Persona que Reporta</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nombre Completo *</label>
                    <input type="text" name="full_name" class="form-control" 
                           value="{{ old('full_name', $reportingPerson->full_name) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico *</label>
                        <input type="email" name="email" class="form-control" 
                               value="{{ old('email', $reportingPerson->email) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="phone" class="form-control" 
                               value="{{ old('phone', $reportingPerson->phone) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles del Acta -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Detalles del Acta</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Número de Acta *</label>
                        <input type="text" name="act_number" class="form-control" 
                               value="{{ old('act_number', $actNumber) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha del Acta *</label>
                        <input type="date" name="minutes_date" class="form-control" 
                               value="{{ old('minutes_date', $minutesDate) }}" 
                               max="{{ date('Y-m-d') }}" required>
                        <small class="text-muted">No puede ser posterior a la fecha actual</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloques de aprendices -->
        @foreach($minutes as $index => $minute)
        <div class="dynamic-block mb-4" data-id="{{ $minute->minutes_id }}">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center position-relative" style="padding-right: 40px;">
                    <strong>Aprendiz #{{ $index + 1 }}</strong>
                    @if($index > 0)
                    <button type="button" class="btn btn-link text-white p-0 remove-apprentice position-absolute" title="Eliminar aprendiz" style="right: 10px;">
                        <i class="fas fa-trash"></i>
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <input type="hidden" name="minutes_ids[]" value="{{ $minute->minutes_id }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre del Aprendiz *</label>
                            <input type="text" name="trainee_name[]" class="form-control" 
                                   value="{{ old("trainee_name.$index", $minute->trainee_name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Documento de Identidad *</label>
                            <input type="text" name="id_document[]" class="form-control" 
                                   value="{{ old("id_document.$index", $minute->id_document) }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Programa de Formación *</label>
                            <input type="text" name="program_name[]" class="form-control" 
                                   value="{{ old("program_name.$index", $minute->program_name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Número de Ficha *</label>
                            <input type="text" name="batch_number[]" class="form-control" 
                                   value="{{ old("batch_number.$index", $minute->batch_number) }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo del Aprendiz</label>
                        <input type="email" name="trainee_email[]" class="form-control" 
                               value="{{ old("trainee_email.$index", $minute->email) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">¿Tiene Contrato?</label>
                        <select name="has_contract[]" class="form-select has-contract">
                            <option value="0" {{ old("has_contract.$index", $minute->has_contract) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old("has_contract.$index", $minute->has_contract) == 1 ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>

                    <div class="company-fields" style="{{ old("has_contract.$index", $minute->has_contract) ? 'display:block' : 'display:none' }}">
                        <div class="card mt-3">
                            <div class="card-header bg-secondary text-white">
                                <strong>Información de la Empresa</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre de la Empresa</label>
                                        <input type="text" name="company_name[]" class="form-control" 
                                               value="{{ old("company_name.$index", $minute->company_name) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input type="text" name="company_address[]" class="form-control" 
                                               value="{{ old("company_address.$index", $minute->company_address) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Responsable TH</label>
                                        <input type="text" name="hr_manager_name[]" class="form-control" 
                                               value="{{ old("hr_manager_name.$index", $minute->hr_manager_name) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contacto</label>
                                        <input type="text" name="company_contact[]" class="form-control" 
                                               value="{{ old("company_contact.$index", $minute->company_contact) }}">
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
                                    <option value="Academic" {{ old("incident_type.$index", $minute->incident_type) == 'Academic' ? 'selected' : '' }}>Académica</option>
                                    <option value="Disciplinary" {{ old("incident_type.$index", $minute->incident_type) == 'Disciplinary' ? 'selected' : '' }}>Disciplinaria</option>
                                    <option value="Dropout" {{ old("incident_type.$index", $minute->incident_type) == 'Dropout' ? 'selected' : '' }}>Deserción</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción *</label>
                                <textarea name="incident_description[]" rows="3" class="form-control incident-description" required>{{ old("incident_description.$index", $minute->incident_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('minutes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <div>
                <button type="button" id="add-apprentice" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Agregar Aprendiz
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Cambios
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
            block.querySelector('.card-header strong').textContent = `Aprendiz #${index + 1}`;
        });
    }

    // Función para activar el toggle de contrato
    function initContractToggle(select) {
        select.addEventListener('change', function() {
            const companyFields = this.closest('.dynamic-block').querySelector('.company-fields');
            companyFields.style.display = this.value === '1' ? 'block' : 'none';
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
        newBlock.querySelector('.card-header strong').textContent = `Aprendiz #${newIndex}`;

        // Asegurar que el botón de eliminar esté presente
        const header = newBlock.querySelector('.card-header');
        if (!header.querySelector('.remove-apprentice')) {
            const btn = document.createElement('button');
            btn.type = "button";
            btn.className = "btn btn-link text-white p-0 remove-apprentice position-absolute";
            btn.style.right = "10px";
            btn.title = "Eliminar aprendiz";
            btn.innerHTML = '<i class="fas fa-trash"></i>';
            header.appendChild(btn);
        }

        // Insertar el nuevo bloque después del último
        lastBlock.after(newBlock);

        // Inicializar el toggle de contrato en el nuevo bloque
        newBlock.querySelectorAll('.has-contract').forEach(initContractToggle);
    });
});
</script>
@endsection