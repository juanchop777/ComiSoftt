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
                    timerProgressBar: true,
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' }
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
                    background: '#ffffff',
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' }
                });
            });
        </script>
    @endif

    {{-- Botón para crear nueva acta --}}
    <div class="text-center mb-4">
        <a href="{{ route('minutes.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Crear Nueva Acta
        </a>
    </div>

    {{-- Título dinámico y filtros --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>
            <i class="fas fa-file-alt me-2"></i>
            @if(request()->has('incident_type') && request()->has('reporting_person'))
                Actas de {{ 
                    request('incident_type') == 'Academic' ? 'Novedades Académicas' : 
                    (request('incident_type') == 'Disciplinary' ? 'Novedades Disciplinarias' : 
                    'Casos de Deserción') 
                }} reportadas por "{{ request('reporting_person') }}"
            @elseif(request()->has('incident_type'))
                Actas de {{ 
                    request('incident_type') == 'Academic' ? 'Novedades Académicas' : 
                    (request('incident_type') == 'Disciplinary' ? 'Novedades Disciplinarias' : 
                    'Casos de Deserción') 
                }}
            @elseif(request()->has('reporting_person'))
                Actas reportadas por "{{ request('reporting_person') }}"
            @else
                Todas las Actas Registradas
            @endif
        </h3>
        
        <div class="d-flex gap-2 mb-3" style="max-width: 600px;">
            {{-- Filtro por tipo --}}
            <form method="GET" action="{{ route('minutes.index') }}" class="d-flex flex-grow-1">
                <select name="incident_type" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Filtrar por tipo</option>
                    <option value="Academic" {{ request('incident_type') == 'Academic' ? 'selected' : '' }}>Académica</option>
                    <option value="Disciplinary" {{ request('incident_type') == 'Disciplinary' ? 'selected' : '' }}>Disciplinaria</option>
                    <option value="Dropout" {{ request('incident_type') == 'Dropout' ? 'selected' : '' }}>Deserción</option>
                </select>
                @if(request()->has('incident_type'))
                <a href="{{ route('minutes.index', request()->only('reporting_person')) }}" class="btn btn-outline-secondary btn-sm ms-1" title="Limpiar filtro">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>

            {{-- Filtro por nombre --}}
            <form method="GET" action="{{ route('minutes.index') }}" class="d-flex flex-grow-1">
                @if(request()->has('incident_type'))
                <input type="hidden" name="incident_type" value="{{ request('incident_type') }}">
                @endif
                <input type="text" name="reporting_person" class="form-control form-control-sm" placeholder="Buscar por nombre" value="{{ request('reporting_person') }}">
                <button class="btn btn-outline-primary btn-sm ms-1" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                @if(request()->has('reporting_person'))
                <a href="{{ route('minutes.index', request()->only('incident_type')) }}" class="btn btn-outline-secondary btn-sm ms-1" title="Limpiar búsqueda">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Tabla de Actas --}}
    <div class="card">
        <div class="card-body">
            @if(!empty($minutes) && count($minutes) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Número de Acta</th>
                            <th class="text-center">Fecha de Acta</th>
                            <th class="text-center">Persona que Reporta</th>
                            <th class="text-center">Tipos de Novedad</th>
                            <th class="text-center">Cantidad de Aprendices</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($minutes as $actNumber => $actaGroup)
                            @php
                                $reportingPerson = $actaGroup['reportingPerson'] ?? null;
                                $incidentTypes = $actaGroup['incident_types'] ?? [];
                            @endphp
                            @if(!request()->has('reporting_person') || 
                                (request()->has('reporting_person') && 
                                $reportingPerson && 
                                stripos($reportingPerson->full_name, request('reporting_person')) !== false))
                            <tr>
                                <td class="text-center"><strong>{{ $actNumber }}</strong></td>
                                <td class="text-center">{{ $actaGroup['minutes_date'] ? \Carbon\Carbon::parse($actaGroup['minutes_date'])->format('d/m/Y') : 'No especificada' }}</td>
                                <td class="text-center">{{ $reportingPerson ? $reportingPerson->full_name : 'Información no disponible' }}</td>
                                <td class="text-center">
                                    @foreach($incidentTypes as $type)
                                        @php
                                            $badgeClass = [
                                                'Academic' => 'bg-primary',
                                                'Disciplinary' => 'bg-warning',
                                                'Dropout' => 'bg-danger'
                                            ][$type] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} me-1">
                                            {{ $type === 'Academic' ? 'Académica' : 
                                               ($type === 'Disciplinary' ? 'Disciplinaria' : 
                                               ($type === 'Dropout' ? 'Deserción' : $type)) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="text-center">{{ $actaGroup['count'] }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info" 
                                                onclick="showDetails('{{ $actNumber }}', {{ json_encode($actaGroup['raw_data']) }})"
                                                title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('minutes.edit', $actNumber) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="deleteActa('{{ $actNumber }}', '{{ $reportingPerson ? $reportingPerson->full_name : 'Sin nombre' }}')"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> 
                    @if(request()->has('incident_type') && request()->has('reporting_person'))
                        No hay actas registradas de tipo "{{ 
                            request('incident_type') == 'Academic' ? 'Académica' : 
                            (request('incident_type') == 'Disciplinary' ? 'Disciplinaria' : 
                            'Deserción') 
                        }}" reportadas por "{{ request('reporting_person') }}".
                    @elseif(request()->has('incident_type'))
                        No hay actas registradas de tipo "{{ 
                            request('incident_type') == 'Academic' ? 'Académica' : 
                            (request('incident_type') == 'Disciplinary' ? 'Disciplinaria' : 
                            'Deserción') 
                        }}".
                    @elseif(request()->has('reporting_person'))
                        No hay actas registradas reportadas por "{{ request('reporting_person') }}".
                    @else
                        No hay actas registradas aún.
                    @endif
                    <br>Utiliza el botón "Crear Nueva Acta" para crear la primera acta.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal para mostrar detalles --}}
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailsModalLabel">Detalles del Acta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- El contenido se cargará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    function getIncidentTypeInSpanish(incidentType) {
        if (!incidentType) return null;
        
        const types = {
            'Academic': 'Académica',
            'Disciplinary': 'Disciplinaria',
            'Dropout': 'Deserción'
        };
        
        return types[incidentType] || incidentType;
    }

    // 👇 NUEVO: helper para formatear EXACTO como en la tabla (d/m/Y) sin tocar zona horaria
    function formatDateDMY(isoDate) {
        if (!isoDate) return 'No especificada';
        // soporta "YYYY-MM-DD" / "YYYY-MM-DDTHH:mm:ss" / "YYYY-MM-DD HH:mm:ss"
        const datePart = isoDate.split('T')[0].split(' ')[0];
        const parts = datePart.includes('-') ? datePart.split('-') : null;
        if (!parts || parts.length < 3) return isoDate;
        const [yyyy, mm, dd] = parts;
        return `${dd.padStart(2,'0')}/${mm.padStart(2,'0')}/${yyyy}`;
    }

    function showDetails(actNumber, actaGroup) {
        let modalBody = document.getElementById('modalBody');

        // ✅ Fecha EXACTA igual a la de la tabla (d/m/Y), sin ajustar timezone
        let actaDate = actaGroup.length > 0 && actaGroup[0].minutes_date
            ? formatDateDMY(actaGroup[0].minutes_date)
            : 'No especificada';
        
        // Mostrar el número de acta y la fecha
        let html = `<h4>Acta #${actNumber || 'Sin número'} - Fecha: ${actaDate}</h4>`;
        
        // Obtener la información de la persona que reporta
        let reportingPerson = null;
        if (actaGroup.length > 0 && actaGroup[0].reporting_person) {
            reportingPerson = actaGroup[0].reporting_person;
        }

        // Mostrar información de la persona que reporta
        if (reportingPerson) {
            html += `
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Persona que Reporta</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Nombre:</strong> ${reportingPerson.full_name || 'No especificado'}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Email:</strong> ${reportingPerson.email || 'No especificado'}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Teléfono:</strong> ${reportingPerson.phone || 'No especificado'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Mostrar información de cada aprendiz
        actaGroup.forEach((trainee, index) => {
            html += `
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-user-graduate"></i> Aprendiz #${index + 1}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> ${trainee.trainee_name || 'No especificado'}</p>
                                <p><strong>Documento:</strong> ${trainee.id_document || 'No especificado'}</p>
                                <p><strong>Programa:</strong> ${trainee.program_name || 'No especificado'}</p>
                                <p><strong>Ficha:</strong> ${trainee.batch_number || 'No especificado'}</p>
                                ${trainee.email ? `<p><strong>Email:</strong> ${trainee.email}</p>` : ''}
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tipo de Novedad:</strong> 
                                    <span class="badge bg-warning">${getIncidentTypeInSpanish(trainee.incident_type) || 'No especificado'}</span>
                                </p>
                                <p><strong>Descripción:</strong></p>
                                <p class="text-muted">${trainee.incident_description || 'No especificado'}</p>
                            </div>
                        </div>
                        
                        ${trainee.has_contract == 1 ? `
                            <div class="mt-3">
                                <h6><strong>Información de la Empresa:</strong></h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        ${trainee.company_name ? `<p><strong>Empresa:</strong> ${trainee.company_name}</p>` : ''}
                                        ${trainee.company_address ? `<p><strong>Dirección:</strong> ${trainee.company_address}</p>` : ''}
                                    </div>
                                    <div class="col-md-6">
                                        ${trainee.hr_manager_name ? `<p><strong>Responsable RH:</strong> ${trainee.hr_manager_name}</p>` : ''}
                                        ${trainee.company_contact ? `<p><strong>Contacto:</strong> ${trainee.company_contact}</p>` : ''}
                                    </div>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        });

        modalBody.innerHTML = html;
        
        // Inicializar el modal de Bootstrap 5 correctamente
        var modalElement = document.getElementById('detailsModal');
        var modal = new bootstrap.Modal(modalElement);
        modal.show();
        
        // Mantengo tu manejo manual de cierre (no cambia nada del botón)
        document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                modal.hide();
            });
        });
    }

    function deleteActa(actNumber, reportingPersonName) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `Se eliminará completamente el acta #${actNumber} reportada por ${reportingPersonName}. Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            showClass: { 
                popup: 'animate__animated animate__fadeInDown' 
            },
            hideClass: { 
                popup: 'animate__animated animate__fadeOutUp' 
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Eliminando...',
                    text: 'Por favor espere',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Hacer llamada AJAX para eliminar
                fetch(`/minutes/${actNumber}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Error al eliminar');
                })
                .then(data => {
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: 'El acta ha sido eliminada correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#28a745',
                        showClass: { 
                            popup: 'animate__animated animate__bounceIn' 
                        }
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al eliminar el acta',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#d33'
                    });
                });
            }
        });
    }
</script>
@endsection
