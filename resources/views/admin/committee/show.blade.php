@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-eye"></i> Detalles del Comité #{{ $committee->committee_id }}
        </h3>
        <div class="d-flex gap-2">
            <a href="{{ route('committee.edit', $committee) }}" class="btn btn-warning btn-lg">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('committee.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        </div>
    </div>

    {{-- Persona que Reporta --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-user-tie"></i> Persona que Reporta
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1"><strong>Nombre:</strong></p>
                    <p class="text-primary mb-3">{{ $committee->reporting_person_name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Email:</strong></p>
                    <p class="mb-3">
                        @if($committee->reporting_person_email)
                            <a href="mailto:{{ $committee->reporting_person_email }}" class="text-decoration-none">
                                <i class="fas fa-envelope"></i> {{ $committee->reporting_person_email }}
                            </a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Teléfono:</strong></p>
                    <p class="text-muted mb-3">{{ $committee->reporting_person_phone ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Aprendiz #1 --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-user-graduate"></i> Aprendiz #1
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-success fw-semibold mb-3">
                        <i class="fas fa-user"></i> Información Personal
                    </h6>
                    <p class="mb-1"><strong>Nombre:</strong></p>
                    <p class="text-primary mb-2">{{ $committee->trainee_name ?? 'N/A' }}</p>
                    
                    <p class="mb-1"><strong>Documento:</strong></p>
                    <p class="text-muted mb-2">{{ $committee->id_document ?? 'N/A' }}</p>
                    
                    <p class="mb-1"><strong>Programa:</strong></p>
                    <p class="text-muted mb-2">{{ $committee->program_name ?? 'N/A' }}</p>
                    
                    <p class="mb-1"><strong>Ficha:</strong></p>
                    <p class="text-muted mb-2">{{ $committee->batch_number ?? 'N/A' }}</p>
                    
                    <p class="mb-1"><strong>Email:</strong></p>
                    <p class="text-muted mb-2">{{ $committee->email ?? 'N/A' }}</p>
                    
                    @if($committee->company_name || $committee->company_address)
                    <hr class="my-3">
                    <h6 class="text-info fw-semibold mb-2">
                        <i class="fas fa-building"></i> Información de la Empresa
                    </h6>
                    <p class="mb-1"><strong>Empresa:</strong></p>
                    <p class="text-muted mb-1">{{ $committee->company_name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Dirección:</strong></p>
                    <p class="text-muted mb-0">{{ $committee->company_address ?? 'N/A' }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h6 class="text-warning fw-semibold mb-3">
                        <i class="fas fa-exclamation-triangle"></i> Detalles del Incidente
                    </h6>
                    <p class="mb-1"><strong>Tipo de Novedad:</strong></p>
                    <p class="mb-2">
                        @if($committee->incident_type)
                            <span class="badge bg-warning fs-6">{{ $committee->incident_type }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                    
                    <p class="mb-1"><strong>Descripción:</strong></p>
                    <p class="text-muted mb-2">{{ $committee->incident_description ?? 'N/A' }}</p>
                    
                    <p class="mb-1"><strong>Fecha de Recepción:</strong></p>
                    <p class="mb-2">
                        @if($committee->reception_date)
                            <span class="badge bg-secondary fs-6">
                                {{ \Carbon\Carbon::parse($committee->reception_date)->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                    
                    <p class="mb-1"><strong>Responsable RH:</strong></p>
                    <p class="text-muted mb-2">{{ $committee->hr_responsible ?? 'N/A' }}</p>
                    
                    <p class="mb-1"><strong>Contacto:</strong></p>
                    <p class="text-muted mb-0">{{ $committee->hr_contact ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Información del Acta --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-file-alt"></i> Información del Acta
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1"><strong>Número de Acta:</strong></p>
                    <p class="mb-3">
                        <span class="badge bg-dark fs-6">Acta #{{ $committee->act_number ?? 'N/A' }}</span>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Fecha del Acta:</strong></p>
                    <p class="mb-3">
                        @if($committee->minutes_date)
                            <span class="badge bg-info fs-6">
                                {{ \Carbon\Carbon::parse($committee->minutes_date)->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Estado:</strong></p>
                    <p class="mb-3">
                        <span class="badge bg-success fs-6">Registrado</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Información de la Sesión del Comité --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">
                <i class="fas fa-calendar"></i> Información de Sesión del Comité
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p class="mb-1"><strong>Fecha Sesión:</strong></p>
                    <p class="mb-3">
                        @if($committee->session_date)
                            <span class="badge bg-info fs-6">
                                {{ \Carbon\Carbon::parse($committee->session_date)->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><strong>Hora Sesión:</strong></p>
                    <p class="mb-3">
                        @if($committee->session_time)
                            <span class="badge bg-secondary fs-6">{{ $committee->session_time }}</span>
                                @else
                            <span class="text-muted">N/A</span>
                                @endif
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><strong>Modalidad Asistencia:</strong></p>
                    <p class="mb-3">
                                @if($committee->attendance_mode)
                                    <span class="badge bg-{{ 
                                        $committee->attendance_mode == 'Presencial' ? 'success' : 
                                        ($committee->attendance_mode == 'Virtual' ? 'info' : 'danger') 
                            }} fs-6">
                                <i class="fas fa-{{ 
                                    $committee->attendance_mode == 'Presencial' ? 'user-check' : 
                                    ($committee->attendance_mode == 'Virtual' ? 'video' : 'user-times') 
                                }}"></i>
                                        {{ $committee->attendance_mode }}
                                    </span>
                                @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><strong>Enlace de Acceso:</strong></p>
                    <p class="mb-3">
                        @if($committee->access_link)
                            <a href="{{ $committee->access_link }}" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-external-link-alt"></i> Ver enlace
                            </a>
                        @else
                            <span class="text-muted">N/A</span>
                                @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Clasificación de la Falta --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">
                <i class="fas fa-exclamation-triangle"></i> Clasificación de la Falta
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1"><strong>Tipo de Falta:</strong></p>
                    <p class="mb-3">
                        <strong class="text-warning">{{ $committee->fault_type ?? 'N/A' }}</strong>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Clase de Falta:</strong></p>
                    <p class="mb-3">
                                @if($committee->offense_class)
                                    <span class="badge bg-{{ 
                                        $committee->offense_class == 'Leve' ? 'warning' : 
                                        ($committee->offense_class == 'Grave' ? 'danger' : 'dark') 
                            }} fs-6">
                                <i class="fas fa-exclamation-triangle"></i>
                                        {{ $committee->offense_class }}
                                    </span>
                                @else
                            <span class="text-muted">N/A</span>
                                @endif
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Descripción Detallada:</strong></p>
                    <p class="mb-3">
                        @if($committee->offense_classification)
                            <div class="bg-light p-2 rounded small">
                                {{ Str::limit($committee->offense_classification, 100) }}
            </div>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                        </div>
                    </div>
                </div>
            </div>

    {{-- Descargos del Aprendiz --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-comments"></i> Descargos del Aprendiz
            </h5>
        </div>
                        <div class="card-body">
            @if($committee->statement)
                <div class="bg-light p-3 rounded">
                    <p class="mb-0">{{ $committee->statement }}</p>
                        </div>
            @else
                <p class="text-muted mb-0">No hay descargos registrados</p>
            @endif
                </div>
            </div>

    {{-- Decisión del Comité --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-gavel"></i> Decisión del Comité
            </h5>
        </div>
                        <div class="card-body">
            @if($committee->decision)
                <div class="bg-light p-3 rounded">
                    <p class="mb-0">{{ $committee->decision }}</p>
                </div>
            @else
                <p class="text-muted mb-0">No hay decisión registrada</p>
            @endif
                        </div>
                    </div>

    {{-- Compromisos y Seguimiento --}}
    @if($committee->commitments || $committee->missing_rating || $committee->recommendations || $committee->observations)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-clipboard-check"></i> Compromisos y Seguimiento
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                @if($committee->commitments)
                <div class="col-md-6 mb-3">
                    <h6 class="text-info fw-semibold mb-2">
                        <i class="fas fa-handshake"></i> Compromisos Acordados
                    </h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $committee->commitments }}</p>
                </div>
            </div>
            @endif

            @if($committee->missing_rating)
                <div class="col-md-6 mb-3">
                    <h6 class="text-warning fw-semibold mb-2">
                        <i class="fas fa-star"></i> Calificación Faltante
                    </h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $committee->missing_rating }}</p>
                </div>
            </div>
            @endif

            @if($committee->recommendations)
                <div class="col-md-6 mb-3">
                    <h6 class="text-primary fw-semibold mb-2">
                        <i class="fas fa-lightbulb"></i> Recomendaciones
                    </h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $committee->recommendations }}</p>
                </div>
            </div>
            @endif

            @if($committee->observations)
                <div class="col-md-6 mb-3">
                    <h6 class="text-secondary fw-semibold mb-2">
                        <i class="fas fa-eye"></i> Observaciones
                    </h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $committee->observations }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Mostrar alerta de éxito si hay mensaje de sesión
@if(session('success'))
    Swal.fire({
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#28a745',
        background: '#ffffff',
        customClass: {
            popup: 'shadow-lg'
        }
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
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#d33',
        background: '#ffffff',
        customClass: {
            popup: 'shadow-lg'
        }
    });
@endif
</script>

<style>
.card { 
    border: none; 
    border-radius: 10px; 
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); 
}

.card-header { 
    border-radius: 10px 10px 0 0 !important; 
    font-weight: 600; 
}

.btn { 
    border-radius: 6px; 
    font-weight: 500; 
    padding: 0.5rem 1rem; 
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
    border-radius: 8px;
}

.badge { 
    font-size: 0.75rem; 
    padding: 0.5rem 0.75rem;
}

.fs-6 {
    font-size: 0.875rem !important;
}

.fw-semibold {
    font-weight: 600;
}

.text-primary {
    color: #0d6efd !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-success {
    color: #198754 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.text-info {
    color: #0dcaf0 !important;
}

.text-secondary {
    color: #6c757d !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.card.bg-light {
    border-radius: 8px;
}

.card.bg-light .card-body {
    padding: 1rem;
}

hr {
    border-color: #dee2e6;
    opacity: 0.5;
}

.bg-dark {
    background-color: #212529 !important;
}

.small {
    font-size: 0.875rem;
}

p strong {
    color: #495057;
    font-weight: 600;
}

.text-muted {
    color: #6c757d !important;
}
</style>
@endsection
