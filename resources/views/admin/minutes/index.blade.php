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
            </h2>
        </div>
        <a href="{{ route('minutes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i> Crear Nueva Acta
        </a>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">
            {{-- Filtro por tipo --}}
            <div class="flex-1">
                <form method="GET" action="{{ route('minutes.index') }}" class="flex gap-2">
                    <select name="incident_type" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                        <option value="">Filtrar por tipo</option>
                        <option value="Academic" {{ request('incident_type') == 'Academic' ? 'selected' : '' }}>Académica</option>
                        <option value="Disciplinary" {{ request('incident_type') == 'Disciplinary' ? 'selected' : '' }}>Disciplinaria</option>
                        <option value="Dropout" {{ request('incident_type') == 'Dropout' ? 'selected' : '' }}>Deserción</option>
                    </select>
                    @if(request()->has('incident_type'))
                    <a href="{{ route('minutes.index', request()->only('reporting_person')) }}" class="px-3 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors" title="Limpiar filtro">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </form>
            </div>

            {{-- Filtro por nombre --}}
            <div class="flex-1">
                <form method="GET" action="{{ route('minutes.index') }}" class="flex gap-2">
                    @if(request()->has('incident_type'))
                    <input type="hidden" name="incident_type" value="{{ request('incident_type') }}">
                    @endif
                    <input type="text" name="reporting_person" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar por nombre" value="{{ request('reporting_person') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->has('reporting_person'))
                    <a href="{{ route('minutes.index', request()->only('incident_type')) }}" class="px-3 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors" title="Limpiar búsqueda">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- Tabla de Actas --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        @if(!empty($minutes) && count($minutes) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
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
                        @if(!request()->has('reporting_person') || 
                            (request()->has('reporting_person') && 
                            $reportingPerson && 
                            stripos($reportingPerson->full_name, request('reporting_person')) !== false))
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
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-file-alt text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">
                @if(request()->has('incident_type') && request()->has('reporting_person'))
                    No hay actas registradas de tipo "{{ 
                        request('incident_type') == 'Academic' ? 'Académica' : 
                        (request('incident_type') == 'Disciplinary' ? 'Disciplinaria' : 
                        'Deserción') 
                    }}" reportadas por "{{ request('reporting_person') }}"
                @elseif(request()->has('incident_type'))
                    No hay actas registradas de tipo "{{ 
                        request('incident_type') == 'Academic' ? 'Académica' : 
                        (request('incident_type') == 'Disciplinary' ? 'Disciplinaria' : 
                        'Deserción') 
                    }}"
                @elseif(request()->has('reporting_person'))
                    No hay actas registradas reportadas por "{{ request('reporting_person') }}"
                @else
                    No hay actas registradas aún
                @endif
            </h3>
            <p class="text-gray-500 mb-6">Utiliza el botón "Crear Nueva Acta" para crear la primera acta.</p>
            <a href="{{ route('minutes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i> Crear Nueva Acta
            </a>
        </div>
        @endif
    </div>

    {{-- Paginación --}}
    @if(!empty($minutes) && count($minutes) > 0)
    <div class="mt-6 flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Mostrando {{ $actNumbers->firstItem() ?? 0 }} a {{ $actNumbers->lastItem() ?? 0 }} de {{ $actNumbers->total() }} actas
        </div>
        <div class="flex items-center space-x-2">
            {{ $actNumbers->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
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

</script>
@endsection
