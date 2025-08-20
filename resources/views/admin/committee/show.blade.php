@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detalles del Comité</h3>
        <a href="{{ route('committee.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-users"></i> Información del Comité
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary">Información de Sesión</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Fecha Sesión:</strong></td>
                            <td>{{ $committee->session_date ? \Carbon\Carbon::parse($committee->session_date)->format('d/m/Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hora Sesión:</strong></td>
                            <td>{{ $committee->session_time ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Enlace de Acceso:</strong></td>
                            <td>
                                @if($committee->access_link)
                                    <a href="{{ $committee->access_link }}" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt"></i> Ver enlace
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Acta:</strong></td>
                            <td>Acta #{{ $committee->act_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nombre Aprendiz:</strong></td>
                            <td>{{ $committee->trainee_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha Acta:</strong></td>
                            <td>{{ $committee->minutes_date ? \Carbon\Carbon::parse($committee->minutes_date)->format('d/m/Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Modalidad Asistencia:</strong></td>
                            <td>
                                @if($committee->attendance_mode)
                                    <span class="badge bg-{{ 
                                        $committee->attendance_mode == 'Presencial' ? 'success' : 
                                        ($committee->attendance_mode == 'Virtual' ? 'info' : 'danger') 
                                    }}">
                                        {{ $committee->attendance_mode }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary">Información de la Falta</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Tipo de Falta:</strong></td>
                            <td>{{ $committee->fault_type ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Clase de Falta:</strong></td>
                            <td>
                                @if($committee->offense_class)
                                    <span class="badge bg-{{ 
                                        $committee->offense_class == 'Leve' ? 'warning' : 
                                        ($committee->offense_class == 'Grave' ? 'danger' : 'dark') 
                                    }}">
                                        {{ $committee->offense_class }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Descripcion de la Falta:</strong></td>
                            <td>{{ $committee->offense_classification ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary">Descargos</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            {{ $committee->statement ?? 'No hay descargos registrados' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="text-primary">Decisión</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            {{ $committee->decision ?? 'No hay decisión registrada' }}
                        </div>
                    </div>
                </div>
            </div>

            @if($committee->commitments)
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="text-primary">Compromisos</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            {{ $committee->commitments }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($committee->missing_rating)
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="text-primary">Calificación Faltante</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            {{ $committee->missing_rating }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($committee->recommendations)
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="text-primary">Recomendaciones</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            {{ $committee->recommendations }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($committee->observations)
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="text-primary">Observaciones</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            {{ $committee->observations }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
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
@endsection
