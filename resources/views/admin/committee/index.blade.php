@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Lista de Comités</h3>
        <a href="{{ route('committee.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Comité
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($committees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Acta #</th>
                                <th>Aprendiz</th>
                                <th>Fecha Sesión</th>
                                <th>Asistencia</th>
                                <th>Clase de Falta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($committees as $committee)
                                <tr>
                                    <td>{{ $committee->committee_id }}</td>
                                    <td>{{ $committee->act_number ?? 'N/A' }}</td>
                                    <td>{{ $committee->trainee_name ?? 'N/A' }}</td>
                                    <td>{{ $committee->session_date ? \Carbon\Carbon::parse($committee->session_date)->format('d/m/Y') : 'N/A' }}</td>
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
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('committee.show', $committee) }}" class="btn btn-sm btn-outline-primary" title="Ver" onclick="showViewAlert()">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('committee.edit', $committee) }}" class="btn btn-sm btn-outline-warning" title="Editar" onclick="showEditAlert()">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="showDeleteAlert({{ $committee->committee_id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay comités registrados</h5>
                    <p class="text-muted">Comienza creando tu primer comité</p>
                    <a href="{{ route('committee.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Crear Comité
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Función para mostrar alerta de vista
function showViewAlert() {
    Swal.fire({
        title: 'Cargando...',
        text: 'Obteniendo detalles del comité',
        icon: 'info',
        timer: 1000,
        timerProgressBar: true,
        showConfirmButton: false
    });
}

// Función para mostrar alerta de edición
function showEditAlert() {
    Swal.fire({
        title: 'Cargando...',
        text: 'Abriendo formulario de edición',
        icon: 'info',
        timer: 1000,
        timerProgressBar: true,
        showConfirmButton: false
    });
}

// Función para mostrar alerta de eliminación
function showDeleteAlert(committeeId) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer. El comité será eliminado permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario dinámicamente y enviarlo
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/committee/${committeeId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            
            // Mostrar alerta de carga
            Swal.fire({
                title: 'Eliminando...',
                text: 'El comité está siendo eliminado',
                icon: 'info',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            });
            
            // Enviar formulario
            setTimeout(() => {
                form.submit();
            }, 500);
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
</script>
@endsection