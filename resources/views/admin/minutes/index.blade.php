@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">

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
                    confirmButtonColor: '#10b981',
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
                    confirmButtonColor: '#ef4444',
                    background: '#ffffff',
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' }
                });
            });
        </script>
    @endif

    {{-- Header con botón de crear --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-file-alt text-blue-600 mr-3"></i>
                Todas las Actas Registradas
            </h2>
        </div>
        <a href="{{ route('minutes.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Crear Nueva Acta
        </a>
    </div>

    {{-- Tabla de Actas --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        @if(!empty($minutes) && count($minutes) > 0)
        <div class="overflow-x-auto">
            <!-- DataTables agregará los controles y la tabla aquí -->
            <div id="minutesTable_wrapper" class="p-6">
                <!-- Contenedor para controles superiores -->
                <div style="width: 100%; overflow: hidden; margin-bottom: 1rem;">
                    <div id="dt-length-container" style="float: left;"></div>
                    <div id="dt-filter-container" style="float: right;"></div>
                </div>
            <table id="minutesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número de Acta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Acta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persona que Reporta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipos de Novedad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad de Aprendices</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($minutes as $actNumber => $actaGroup)
                        @php
                            $reportingPerson = $actaGroup['reportingPerson'] ?? null;
                            $incidentTypes = $actaGroup['incident_types'] ?? [];
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">#{{ $actNumber }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $actaGroup['minutes_date'] ? \Carbon\Carbon::parse($actaGroup['minutes_date'])->format('d/m/Y') : 'No especificada' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reportingPerson ? $reportingPerson->full_name : 'Información no disponible' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($incidentTypes as $type)
                                        @php
                                            $badgeClass = [
                                                'Academic' => 'badge badge-primary',
                                                'Disciplinary' => 'badge badge-warning',
                                                'Dropout' => 'badge badge-danger'
                                            ][$type] ?? 'badge badge-muted';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                            {{ $type === 'Academic' ? 'Académica' : 
                                               ($type === 'Disciplinary' ? 'Disciplinaria' : 
                                               ($type === 'Dropout' ? 'Deserción' : $type)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $actaGroup['count'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex gap-2">
                                    <button type="button" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors" 
                                            onclick="showDetails('{{ $actNumber }}', {{ json_encode($actaGroup['raw_data']) }})"
                                            title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('minutes.edit', $actNumber) }}" 
                                       class="p-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="p-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors" 
                                            onclick="deleteActa('{{ $actNumber }}', '{{ $reportingPerson ? $reportingPerson->full_name : 'Sin nombre' }}')"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        @else
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-file-alt text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">
                No hay actas registradas aún
            </h3>
            <p class="text-gray-500 mb-6">Utiliza el botón "Crear Nueva Acta" para crear la primera acta.</p>
            <a href="{{ route('minutes.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i> Crear Nueva Acta
            </a>
        </div>
        @endif
    </div>

</div>

{{-- Modal para mostrar detalles --}}
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="detailsModal">
    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-7xl shadow-lg rounded-md bg-white max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 flex-shrink-0">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                Detalles del Acta
            </h3>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="mt-4 overflow-y-auto flex-1" id="modalBody" style="max-height: calc(90vh - 140px);">
            <!-- El contenido se cargará dinámicamente -->
        </div>
        <div class="flex justify-between pt-4 border-t border-gray-200 flex-shrink-0">
            <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors" onclick="generateActaPDF()">
                <i class="fas fa-file-pdf mr-2"></i> Exportar PDF
            </button>
            <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="closeModal()">
                <i class="fas fa-times mr-2"></i> Cerrar
            </button>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>


<script>
    // Variable global para almacenar el número de acta actual
    let currentActaNumber = null;

    function getIncidentTypeInSpanish(incidentType) {
        if (!incidentType) return null;
        
        const types = {
            'CANCELACION_MATRICULA_ACADEMICO': 'CANCELACIÓN MATRÍCULA ÍNDOLE ACADÉMICO',
            'CANCELACION_MATRICULA_DISCIPLINARIO': 'CANCELACIÓN MATRÍCULA ÍNDOLE DISCIPLINARIO',
            'CONDICIONAMIENTO_MATRICULA': 'CONDICIONAMIENTO DE MATRÍCULA',
            'DESERCION_PROCESO_FORMACION': 'DESERCIÓN PROCESO DE FORMACIÓN',
            'NO_GENERACION_CERTIFICADO': 'NO GENERACIÓN-CERTIFICADO',
            'RETIRO_POR_FRAUDE': 'RETIRO POR FRAUDE',
            'RETIRO_PROCESO_FORMACION': 'RETIRO PROCESO DE FORMACIÓN',
            'TRASLADO_CENTRO': 'TRASLADO DE CENTRO',
            'TRASLADO_JORNADA': 'TRASLADO DE JORNADA',
            'TRASLADO_PROGRAMA': 'TRASLADO DE PROGRAMA',
            // Mantener compatibilidad con tipos antiguos
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
        // Almacenar el número de acta actual
        currentActaNumber = actNumber;
        
        let modalBody = document.getElementById('modalBody');

        // ✅ Fecha EXACTA igual a la de la tabla (d/m/Y), sin ajustar timezone
        let actaDate = actaGroup.length > 0 && actaGroup[0].minutes_date
            ? formatDateDMY(actaGroup[0].minutes_date)
            : 'No especificada';
        
        // Mostrar el número de acta, fecha y centro de formación
        let trainingCenter = actaGroup.length > 0 && actaGroup[0].training_center 
            ? actaGroup[0].training_center 
            : 'No especificado';
        
        let html = `
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">SERVICIO NACIONAL DE APRENDIZAJE</h1>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">CENTRO DE FORMACIÓN AGROINDUSTRIAL</h2>
                <h3 class="text-lg text-gray-600 mb-4">CONSOLIDADO DE NOVEDADES ACADÉMICAS Y DISCIPLINARIAS</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 inline-block">
                    <h4 class="text-xl font-bold text-blue-800">Acta #${actNumber || 'Sin número'}</h4>
                    <p class="text-blue-600">Fecha: ${actaDate}</p>
                    <p class="text-blue-600">Centro de Formación: ${trainingCenter}</p>
                </div>
            </div>
        `;
        
        // Obtener la información de la persona que reporta
        let reportingPerson = null;
        if (actaGroup.length > 0 && actaGroup[0].reporting_person) {
            reportingPerson = actaGroup[0].reporting_person;
        }

        // Mostrar información de la persona que reporta
        if (reportingPerson) {
            html += `
                <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            Persona que Reporta
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${reportingPerson.full_name || 'No especificado'}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${reportingPerson.email || 'No especificado'}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${reportingPerson.phone || 'No especificado'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Mostrar información de cada aprendiz
        actaGroup.forEach((trainee, index) => {
            html += `
                <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i>
                            Información del Aprendiz #${index + 1}
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Aprendiz</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${trainee.trainee_name || 'No especificado'}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono del Aprendiz</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${trainee.trainee_phone || 'No especificado'}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${trainee.document_type || 'No especificado'}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número de Documento</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${trainee.id_document || 'No especificado'}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Programa de Formación</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${trainee.program_name || 'No especificado'}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número de Ficha</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${trainee.batch_number || 'No especificado'}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Programa</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${trainee.program_type || 'No especificado'}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado del Aprendiz</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ${trainee.trainee_status || 'No especificado'}
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo del Aprendiz</label>
                            <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                ${trainee.email || 'No especificado'}
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Tiene Contrato?</label>
                            <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                ${trainee.has_contract == 1 ? 'Sí' : 'No'}
                            </div>
                        </div>

                        ${trainee.has_contract == 1 ? `
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
                                        <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                            ${trainee.company_name || 'No especificado'}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                                        <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                            ${trainee.company_address || 'No especificado'}
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Responsable RH</label>
                                        <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                            ${trainee.hr_manager_name || 'No especificado'}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Contacto</label>
                                        <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                            ${trainee.company_contact || 'No especificado'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ` : ''}

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
                                    <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                        ${getIncidentTypeInSpanish(trainee.incident_type) || 'No especificado'}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtipo de Novedad</label>
                                    <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                        ${(trainee.incident_subtype || 'No especificado').replace(/_/g, ' ')}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md min-h-[80px]">
                                    ${trainee.incident_description || 'No especificado'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        modalBody.innerHTML = html;
        
        // Mostrar el modal personalizado
        const modal = document.getElementById('detailsModal');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('detailsModal');
        modal.classList.add('hidden');
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

    function generateActaPDF() {
        if (!currentActaNumber) {
            Swal.fire({
                title: 'Error',
                text: 'No se ha seleccionado un acta',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // Mostrar loading
        Swal.fire({
            title: 'Generando PDF...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Generar PDF
        window.location.href = `/minutes/${currentActaNumber}/pdf`;
        
        // Cerrar loading después de un breve momento
        setTimeout(() => {
            Swal.close();
        }, 1000);
    }

// Inicializar DataTables
document.addEventListener('DOMContentLoaded', function() {
    if (typeof DataTable === 'undefined') {
        console.error('DataTable no está cargado. Verifica que el script de DataTables esté incluido.');
        return;
    }
    
    const tableElement = document.querySelector('#minutesTable');
    if (!tableElement) {
        console.error('No se encontró la tabla con id #minutesTable');
        return;
    }
    
    // Verificar si hay datos en la tabla
    const tbody = tableElement.querySelector('tbody');
    const dataRows = tbody ? tbody.querySelectorAll('tr') : [];
    
    // Si no hay filas de datos, no inicializar DataTables
    if (dataRows.length === 0) {
        console.log('No hay datos en la tabla, DataTables no se inicializará');
        return;
    }
    
    let table = new DataTable('#minutesTable', {
        language: {
            search: 'Buscar:',
            lengthMenu: 'Mostrar _MENU_ registros',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            infoEmpty: 'Mostrando 0 a 0 de 0 registros',
            infoFiltered: '(filtrado de _MAX_ registros totales)',
            zeroRecords: 'No se encontraron registros',
            emptyTable: 'No hay datos disponibles',
            paginate: {
                first: '«',
                previous: '<',
                next: '>',
                last: '»'
            }
        },
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        order: [[0, 'asc']], // Ordenar por número de acta ascendente
        processing: false,
        serverSide: false,
        dom: 'rtip',
        initComplete: function() {
            const lengthContainer = document.createElement('div');
            lengthContainer.className = 'dataTables_length';
            lengthContainer.innerHTML = `
                <label>
                    Mostrar
                    <select name="minutesTable_length" aria-controls="minutesTable" class="px-3 py-2 border border-gray-300 rounded-lg ml-2">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="-1">Todos</option>
                    </select>
                    registros
                </label>
            `;
            
            const filterContainer = document.createElement('div');
            filterContainer.className = 'dataTables_filter';
            filterContainer.innerHTML = `
                <label>
                    Buscar:
                    <input type="search" class="px-3 py-2 border border-gray-300 rounded-lg ml-2" placeholder="Buscar..." aria-controls="minutesTable" style="width: 250px; outline: none; transition: none;">
                </label>
            `;
            
            const lengthTarget = document.getElementById('dt-length-container');
            const filterTarget = document.getElementById('dt-filter-container');
            
            if (lengthTarget) lengthTarget.appendChild(lengthContainer);
            if (filterTarget) filterTarget.appendChild(filterContainer);
            
            const lengthSelect = lengthContainer.querySelector('select');
            const searchInput = filterContainer.querySelector('input');
            
            if (lengthSelect) {
                lengthSelect.addEventListener('change', function() {
                    table.page.len(parseInt(this.value)).draw();
                });
            }
            
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    table.search(this.value).draw();
                });
            }
        }
    });
});
</script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<style>
/* Estilos para DataTables */
.dataTables_wrapper {
    position: relative;
    clear: both;
    width: 100%;
}

.dataTables_wrapper .dataTables_length {
    float: left !important;
    margin-bottom: 1rem;
    padding: 0.5rem 0;
    clear: none !important;
    width: auto !important;
}

.dataTables_wrapper .dataTables_filter {
    float: right !important;
    margin-bottom: 1rem;
    padding: 0.5rem 0;
    text-align: right !important;
    clear: none !important;
    width: auto !important;
}

.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: #374151;
    margin: 0;
    white-space: nowrap;
}

.dataTables_wrapper .dataTables_length select {
    margin-left: 0.5rem;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    min-width: 60px;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5rem;
    padding: 0.5rem;
    border: 1px solid #d1d5db !important;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    width: 250px;
    outline: none !important;
    transition: none;
    background-color: white;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #d1d5db !important;
    box-shadow: none !important;
    outline: none !important;
    background-color: white !important;
}

.dataTables_wrapper .dataTables_filter input:hover {
    border-color: #9ca3af !important;
    box-shadow: none !important;
    background-color: white !important;
}

.dataTables_wrapper .dataTables_info {
    float: left;
    padding: 0.75rem 0;
    margin-top: 1.5rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    padding: 0.75rem 0;
    margin-top: 1.5rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.375rem 0.625rem;
    margin: 0 0.125rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background: white;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-block;
    text-decoration: none;
    font-size: 0.875rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #f3f4f6 !important;
    border-color: #d1d5db !important;
    color: #374151 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #22c55e;
    color: white;
    border-color: #22c55e;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.dataTables_wrapper::after {
    content: "";
    display: table;
    clear: both;
}
</style>
@endsection
