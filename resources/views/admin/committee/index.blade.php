@extends('layouts.admin')

@section('content')
<div class="container p-4">

    {{-- Alertas --}}
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session("success") }}',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#28a745',
                    background: '#ffffff',
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session("error") }}',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#d33',
                    background: '#ffffff'
                });
            });
        </script>
    @endif

    {{-- Botón para crear nuevo comité --}}
    <div class="text-center mb-4">
        <a href="{{ route('committee.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Crear Nuevo Comité
        </a>
                </div>

    {{-- Título dinámico y filtros --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>
            <i class="fas fa-users me-2"></i>
            @if(request()->has('attendance_mode'))
                Comités con asistencia en modalidad "{{ request('attendance_mode') }}"
            @elseif(request()->has('offense_class'))
                Comités con faltas de tipo "{{ request('offense_class') }}"
            @elseif(request()->has('incident_type'))
                Comités de novedad "{{ request('incident_type') }}"
            @else
                Todos los Comités Registrados
            @endif
        </h3>
        
        <div class="d-flex gap-2 mb-3" style="max-width: 600px;">
            {{-- Filtro por modalidad --}}
            <form method="GET" action="{{ route('committee.index') }}" class="d-flex flex-grow-1">
                <select name="attendance_mode" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Filtrar por asistencia</option>
                    <option value="Presencial" {{ request('attendance_mode') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                    <option value="Virtual" {{ request('attendance_mode') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                    <option value="No asistió" {{ request('attendance_mode') == 'No asistió' ? 'selected' : '' }}>No asistió</option>
                </select>
                @if(request()->has('attendance_mode'))
                <a href="{{ route('committee.index') }}" class="btn btn-outline-secondary btn-sm ms-1">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>

            {{-- Filtro por aprendiz --}}
            <form method="GET" action="{{ route('committee.index') }}" class="d-flex flex-grow-1">
                <input type="text" name="trainee_name" class="form-control form-control-sm" placeholder="Buscar aprendiz" value="{{ request('trainee_name') }}">
                <button class="btn btn-outline-primary btn-sm ms-1" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                @if(request()->has('trainee_name'))
                <a href="{{ route('committee.index') }}" class="btn btn-outline-secondary btn-sm ms-1">
                    <i class="fas fa-times"></i>
                        </a>
                    @endif
            </form>
        </div>
    </div>

    {{-- Tabla de Comités --}}
    <div class="card">
        <div class="card-body">
            @if(!empty($committees) && count($committees) > 0)
                <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Acta #</th>
                                <th>Aprendiz</th>
                                <th>Fecha Sesión</th>
                            <th>Modalidad</th>
                                <th>Clase de Falta</th>
                            <th>Tipo de Novedad</th>
                            <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($committees as $committee)
                                <tr>
                                    <td>{{ $committee->committee_id }}</td>
                            <td><strong>{{ $committee->act_number ?? 'N/A' }}</strong></td>
                                    <td>{{ $committee->trainee_name ?? 'N/A' }}</td>
                                    <td>{{ $committee->session_date ? \Carbon\Carbon::parse($committee->session_date)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $committee->attendance_mode ?? 'N/A' }}</td>
                            <td>{{ $committee->offense_class ?? 'N/A' }}</td>
                            <td>{{ $committee->incident_type ?? 'N/A' }}</td>
                            <td>
                                @if($committee->decision)
                                    <span class="badge bg-success">Completado</span>
                                        @else
                                    <span class="badge bg-warning">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info"
                                            onclick="showDetails({{ json_encode($committee) }})"
                                            title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('committee.edit', $committee) }}" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                    <form action="{{ route('committee.destroy', $committee) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                    </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> 
                    No hay comités registrados aún.
                    <br>Utiliza el botón "Crear Nuevo Comité" para empezar.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal de Detalles --}}
<div class="modal fade" id="committeeModal" tabindex="-1" aria-labelledby="committeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="committeeModalLabel">Detalles del Comité</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="committeeModalBody">
                <!-- Se cargan dinámicamente -->
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showDetails(committee) {
        let html = `
            <p><strong>Acta #:</strong> ${committee.act_number ?? 'N/A'}</p>
            <p><strong>Aprendiz:</strong> ${committee.trainee_name ?? 'N/A'}</p>
            <p><strong>Fecha de Sesión:</strong> ${committee.session_date ?? 'N/A'}</p>
            <p><strong>Hora:</strong> ${committee.session_time ?? 'N/A'}</p>
            <p><strong>Modalidad:</strong> ${committee.attendance_mode ?? 'N/A'}</p>
            <p><strong>Clase de Falta:</strong> ${committee.offense_class ?? 'N/A'}</p>
            <p><strong>Tipo de Novedad:</strong> ${committee.incident_type ?? 'N/A'}</p>
            <p><strong>Decisión:</strong> ${committee.decision ?? 'Pendiente'}</p>
        `;
        document.getElementById('committeeModalBody').innerHTML = html;
        new bootstrap.Modal(document.getElementById('committeeModal')).show();
    }
</script>
@endsection
