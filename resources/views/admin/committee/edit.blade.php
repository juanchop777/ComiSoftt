@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Editar Comité</h3>

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

    <form action="{{ route('committee.update', $committee) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Información de Sesión --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Información de Sesión</h5>
            </div>
            <div class="card-body">
                                 <div class="row g-3 mb-4">
                     <div class="col-md-4">
                         <label for="session_date" class="form-label fw-semibold">Fecha Sesión</label>
                         <input type="date" class="form-control" name="session_date" value="{{ $committee->session_date }}" required>
                     </div>
 
                     <div class="col-md-4">
                         <label for="session_time" class="form-label fw-semibold">Hora Sesión</label>
                         <input type="time" class="form-control" name="session_time" value="{{ $committee->session_time }}" required>
                     </div>
 
                     <div class="col-md-4">
                         <label for="access_link" class="form-label fw-semibold">Enlace de Acceso</label>
                         <input type="url" class="form-control" name="access_link" value="{{ $committee->access_link }}" placeholder="https://meet.google.com/...">
                         <small class="form-text text-muted">Opcional - Solo para sesiones virtuales</small>
                     </div>
                 </div>
 
                 <div class="row g-3 mb-4">
                     <div class="col-md-6">
                         <label for="minutes_id" class="form-label fw-semibold">Acta</label>
                         <select name="minutes_id" class="form-select" required>
                             <option value="">Seleccione un acta...</option>
                             @foreach($minutes as $minute)
                                 <option value="{{ $minute->minutes_id }}" 
                                         {{ $committee->minutes_id == $minute->minutes_id ? 'selected' : '' }}>
                                     Acta #{{ $minute->act_number }} - {{ $minute->trainee_name }} ({{ \Carbon\Carbon::parse($minute->minutes_date)->format('d/m/Y') }})
                                 </option>
                             @endforeach
                         </select>
                     </div>
 
                     <div class="col-md-3">
                         <label for="trainee_name" class="form-label fw-semibold">Nombre Aprendiz</label>
                         <input type="text" name="trainee_name" class="form-control" value="{{ $committee->trainee_name }}" readonly>
                     </div>
 
                     <div class="col-md-3">
                         <label for="minutes_date" class="form-label fw-semibold">Fecha Acta</label>
                         <input type="date" class="form-control" name="minutes_date" value="{{ $committee->minutes_date }}" required>
                     </div>
                 </div>
 
                 <div class="row g-3">
                     <div class="col-md-6">
                         <label for="attendance_mode" class="form-label fw-semibold">Modalidad Asistencia</label>
                         <select name="attendance_mode" class="form-select" required>
                             <option value="">Seleccione...</option>
                             <option value="Presencial" {{ $committee->attendance_mode == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                             <option value="Virtual" {{ $committee->attendance_mode == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                             <option value="No asistió" {{ $committee->attendance_mode == 'No asistió' ? 'selected' : '' }}>No asistió</option>
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
                         <input type="text" class="form-control" name="fault_type" value="{{ $committee->fault_type }}" required placeholder="Ej: Inasistencia, indisciplina, etc.">
                     </div>
 
                     <div class="col-md-4">
                         <label for="offense_class" class="form-label fw-semibold">Clase de Falta</label>
                         <select name="offense_class" class="form-select" required>
                             <option value="">Seleccione...</option>
                             <option value="Leve" {{ $committee->offense_class == 'Leve' ? 'selected' : '' }}>Leve</option>
                             <option value="Grave" {{ $committee->offense_class == 'Grave' ? 'selected' : '' }}>Grave</option>
                             <option value="Muy Grave" {{ $committee->offense_class == 'Muy Grave' ? 'selected' : '' }}>Muy Grave</option>
                         </select>
                     </div>
                 </div>
 
                 <div class="mb-4">
                     <label for="offense_classification" class="form-label fw-semibold">Descripción de la Falta</label>
                     <textarea name="offense_classification" class="form-control" rows="3" placeholder="Describa la clasificación de la falta...">{{ $committee->offense_classification }}</textarea>
                 </div>
 
                 <div class="mb-4">
                     <label for="statement" class="form-label fw-semibold">Descargos</label>
                     <textarea name="statement" class="form-control" rows="3" required placeholder="Descargos del aprendiz...">{{ $committee->statement }}</textarea>
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
                         <textarea name="decision" class="form-control" rows="3" required placeholder="Decisión del comité...">{{ $committee->decision }}</textarea>
                     </div>
 
                     <div class="col-md-6">
                         <label for="commitments" class="form-label fw-semibold">Compromisos</label>
                         <textarea name="commitments" class="form-control" rows="3" placeholder="Compromisos acordados...">{{ $committee->commitments }}</textarea>
                     </div>
                 </div>
 
                 <div class="row g-3 mb-4">
                     <div class="col-md-6">
                         <label for="missing_rating" class="form-label fw-semibold">Calificación Faltante</label>
                         <textarea name="missing_rating" class="form-control" rows="3" placeholder="Calificaciones o evaluaciones faltantes...">{{ $committee->missing_rating }}</textarea>
                     </div>
 
                     <div class="col-md-6">
                         <label for="recommendations" class="form-label fw-semibold">Recomendaciones</label>
                         <textarea name="recommendations" class="form-control" rows="3" placeholder="Recomendaciones del comité...">{{ $committee->recommendations }}</textarea>
                     </div>
                 </div>
 
                 <div class="mb-4">
                     <label for="observations" class="form-label fw-semibold">Observaciones</label>
                     <textarea name="observations" class="form-control" rows="3" placeholder="Observaciones adicionales...">{{ $committee->observations }}</textarea>
                 </div>
            </div>
        </div>

                 <div class="d-flex gap-2 mb-4">
             <button type="submit" class="btn btn-success" onclick="showUpdateAlert()">
                 <i class="fas fa-save"></i> Actualizar Comité
             </button>
             <a href="{{ route('committee.index') }}" class="btn btn-secondary" onclick="showCancelAlert(event)">
                 <i class="fas fa-arrow-left"></i> Cancelar
             </a>
         </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const minutesSelect = document.querySelector('select[name="minutes_id"]');
    const traineeNameInput = document.querySelector('input[name="trainee_name"]');
    
    if (minutesSelect && traineeNameInput) {
        minutesSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const traineeName = selectedOption.textContent.split(' - ')[1]?.split(' (')[0];
                if (traineeName) {
                    traineeNameInput.value = traineeName;
                }
            }
        });
    }
});

// Función para mostrar alerta de actualización
function showUpdateAlert() {
    Swal.fire({
        title: 'Actualizando...',
        text: 'El comité está siendo actualizado',
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
        text: "Los cambios realizados se perderán",
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
