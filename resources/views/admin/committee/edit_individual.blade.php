@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-3">
            <div class="bg-gray-100 p-3 rounded-lg">
                <i class="fas fa-user text-gray-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar Comité Individual</h1>
                <p class="text-gray-600">Acta #{{ $individualCommittee->act_number }} - {{ $individualCommittee->trainee_name }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('committee.individual.show', $individualCommittee) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Ver">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('committee.individual.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white p-3 rounded-lg flex items-center transition-colors" title="Volver">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>

    <form action="{{ route('committee.individual.update', $individualCommittee) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="minutes_id" value="{{ $individualCommittee->minutes_id }}">

        <!-- Información de la Sesión -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-blue-100 text-blue-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    Información de Sesión
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="session_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-1 text-blue-500"></i>
                            Fecha de Sesión
                        </label>
                        <input type="date" name="session_date" id="session_date" 
                               value="{{ old('session_date', $individualCommittee->session_date) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @error('session_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="session_time" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-clock mr-1 text-blue-500"></i>
                            Hora de Sesión
                        </label>
                        <input type="time" name="session_time" id="session_time" 
                               value="{{ old('session_time', $individualCommittee->session_time) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @error('session_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="attendance_mode" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-users mr-1 text-blue-500"></i>
                            Modalidad de Asistencia
                        </label>
                        <select name="attendance_mode" id="attendance_mode" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">Seleccionar modalidad</option>
                            <option value="Presencial" {{ old('attendance_mode', $individualCommittee->attendance_mode) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="Virtual" {{ old('attendance_mode', $individualCommittee->attendance_mode) == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="No asistió" {{ old('attendance_mode', $individualCommittee->attendance_mode) == 'No asistió' ? 'selected' : '' }}>No asistió</option>
                        </select>
                        @error('attendance_mode')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="access_link" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-link mr-1 text-blue-500"></i>
                            Enlace de Acceso
                        </label>
                        <input type="url" name="access_link" id="access_link" 
                               value="{{ old('access_link', $individualCommittee->access_link) }}"
                               placeholder="https://..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @error('access_link')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Aprendiz -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-green-100 text-green-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-user-graduate mr-2"></i>
                    Información del Aprendiz
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Información Personal -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <h4 class="text-md font-bold text-blue-700 mb-3 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            Información Personal
                        </h4>
                        <div class="space-y-3">
                            <div>
                                <label for="trainee_name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Aprendiz</label>
                                <input type="text" name="trainee_name" id="trainee_name" 
                                       value="{{ old('trainee_name', $individualCommittee->trainee_name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('trainee_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="document_type" class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Documento</label>
                                    <select name="document_type" id="document_type" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="">Seleccionar...</option>
                                        <option value="CC" {{ old('document_type', $individualCommittee->document_type) == 'CC' ? 'selected' : '' }}>CC</option>
                                        <option value="CE" {{ old('document_type', $individualCommittee->document_type) == 'CE' ? 'selected' : '' }}>CE</option>
                                        <option value="TI" {{ old('document_type', $individualCommittee->document_type) == 'TI' ? 'selected' : '' }}>TI</option>
                                        <option value="PEP" {{ old('document_type', $individualCommittee->document_type) == 'PEP' ? 'selected' : '' }}>PEP</option>
                                        <option value="DNI" {{ old('document_type', $individualCommittee->document_type) == 'DNI' ? 'selected' : '' }}>DNI</option>
                                        <option value="NCS" {{ old('document_type', $individualCommittee->document_type) == 'NCS' ? 'selected' : '' }}>NCS</option>
                                        <option value="PA" {{ old('document_type', $individualCommittee->document_type) == 'PA' ? 'selected' : '' }}>PA</option>
                                        <option value="PPT" {{ old('document_type', $individualCommittee->document_type) == 'PPT' ? 'selected' : '' }}>PPT</option>
                                    </select>
                                    @error('document_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="id_document" class="block text-sm font-semibold text-gray-700 mb-1">Número de Documento</label>
                                    <input type="text" name="id_document" id="id_document" 
                                           value="{{ old('id_document', $individualCommittee->id_document) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('id_document')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="trainee_phone" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono del Aprendiz</label>
                                    <input type="text" name="trainee_phone" id="trainee_phone" 
                                           value="{{ old('trainee_phone', $individualCommittee->trainee_phone) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('trainee_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="program_name" class="block text-sm font-semibold text-gray-700 mb-1">Programa</label>
                                    <input type="text" name="program_name" id="program_name" 
                                           value="{{ old('program_name', $individualCommittee->program_name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('program_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="program_type" class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Programa</label>
                                    <input type="text" name="program_type" id="program_type" 
                                           value="{{ old('program_type', $individualCommittee->program_type) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('program_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="trainee_status" class="block text-sm font-semibold text-gray-700 mb-1">Estado del Aprendiz</label>
                                    <input type="text" name="trainee_status" id="trainee_status" 
                                           value="{{ old('trainee_status', $individualCommittee->trainee_status) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('trainee_status')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="training_center" class="block text-sm font-semibold text-gray-700 mb-1">Centro de Formación</label>
                                    <input type="text" name="training_center" id="training_center" 
                                           value="{{ old('training_center', $individualCommittee->training_center) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('training_center')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="batch_number" class="block text-sm font-semibold text-gray-700 mb-1">Ficha</label>
                                    <input type="text" name="batch_number" id="batch_number" 
                                           value="{{ old('batch_number', $individualCommittee->batch_number) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('batch_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email', $individualCommittee->email) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de la Empresa (solo si tiene contrato) -->
                    @if($individualCommittee->minutes && $individualCommittee->minutes->has_contract)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <h4 class="text-md font-bold text-blue-700 mb-3 flex items-center">
                            <i class="fas fa-building mr-2 text-blue-500"></i>
                            Información de la Empresa
                        </h4>
                        <div class="space-y-3">
                            <div>
                                <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-1">Empresa</label>
                                <input type="text" name="company_name" id="company_name" 
                                       value="{{ old('company_name', $individualCommittee->company_name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('company_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="company_address" class="block text-sm font-semibold text-gray-700 mb-1">Dirección de la Empresa</label>
                                <input type="text" name="company_address" id="company_address" 
                                       value="{{ old('company_address', $individualCommittee->company_address) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('company_address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="company_contact" class="block text-sm font-semibold text-gray-700 mb-1">
                                        <i class="fas fa-phone mr-1 text-blue-500"></i>
                                        Contacto de la Empresa
                                    </label>
                                    <input type="text" name="company_contact" id="company_contact" 
                                           value="{{ old('company_contact', $individualCommittee->company_contact ?? $individualCommittee->hr_contact) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('company_contact')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="hr_responsible" class="block text-sm font-semibold text-gray-700 mb-1">
                                        <i class="fas fa-user-tie mr-1 text-blue-500"></i>
                                        RRHH Responsable
                                    </label>
                                    <input type="text" name="hr_responsible" id="hr_responsible" 
                                           value="{{ old('hr_responsible', $individualCommittee->hr_responsible) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('hr_responsible')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información de la Novedad -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-yellow-100 text-yellow-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Información de la Novedad
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="incident_type" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-blue-500"></i>
                            Tipo de Novedad
                        </label>
                        <select name="incident_type" id="incident_type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">Seleccionar tipo</option>
                            <option value="CANCELACION_MATRICULA_ACADEMICO" {{ old('incident_type', $individualCommittee->incident_type) == 'CANCELACION_MATRICULA_ACADEMICO' ? 'selected' : '' }}>CANCELACIÓN MATRÍCULA ÍNDOLE ACADÉMICO</option>
                            <option value="CANCELACION_MATRICULA_DISCIPLINARIO" {{ old('incident_type', $individualCommittee->incident_type) == 'CANCELACION_MATRICULA_DISCIPLINARIO' ? 'selected' : '' }}>CANCELACIÓN MATRÍCULA ÍNDOLE DISCIPLINARIO</option>
                            <option value="CONDICIONAMIENTO_MATRICULA" {{ old('incident_type', $individualCommittee->incident_type) == 'CONDICIONAMIENTO_MATRICULA' ? 'selected' : '' }}>CONDICIONAMIENTO DE MATRÍCULA</option>
                            <option value="DESERCION_PROCESO_FORMACION" {{ old('incident_type', $individualCommittee->incident_type) == 'DESERCION_PROCESO_FORMACION' ? 'selected' : '' }}>DESERCIÓN PROCESO DE FORMACIÓN</option>
                            <option value="NO_GENERACION_CERTIFICADO" {{ old('incident_type', $individualCommittee->incident_type) == 'NO_GENERACION_CERTIFICADO' ? 'selected' : '' }}>NO GENERACIÓN-CERTIFICADO</option>
                            <option value="RETIRO_POR_FRAUDE" {{ old('incident_type', $individualCommittee->incident_type) == 'RETIRO_POR_FRAUDE' ? 'selected' : '' }}>RETIRO POR FRAUDE</option>
                            <option value="RETIRO_PROCESO_FORMACION" {{ old('incident_type', $individualCommittee->incident_type) == 'RETIRO_PROCESO_FORMACION' ? 'selected' : '' }}>RETIRO PROCESO DE FORMACIÓN</option>
                            <option value="TRASLADO_CENTRO" {{ old('incident_type', $individualCommittee->incident_type) == 'TRASLADO_CENTRO' ? 'selected' : '' }}>TRASLADO DE CENTRO</option>
                            <option value="TRASLADO_JORNADA" {{ old('incident_type', $individualCommittee->incident_type) == 'TRASLADO_JORNADA' ? 'selected' : '' }}>TRASLADO DE JORNADA</option>
                            <option value="TRASLADO_PROGRAMA" {{ old('incident_type', $individualCommittee->incident_type) == 'TRASLADO_PROGRAMA' ? 'selected' : '' }}>TRASLADO DE PROGRAMA</option>
                            <!-- Mantener compatibilidad con tipos antiguos -->
                            <option value="Academic" {{ old('incident_type', $individualCommittee->incident_type) == 'Academic' ? 'selected' : '' }}>Académica</option>
                            <option value="Disciplinary" {{ old('incident_type', $individualCommittee->incident_type) == 'Disciplinary' ? 'selected' : '' }}>Disciplinaria</option>
                            <option value="Other" {{ old('incident_type', $individualCommittee->incident_type) == 'Other' ? 'selected' : '' }}>Otra</option>
                        </select>
                        @error('incident_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 mt-4">
                    <div>
                        <label for="incident_subtype" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tags mr-1 text-blue-500"></i>
                            Subtipo de Novedad
                        </label>
                        <select name="incident_subtype" id="incident_subtype" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">Seleccionar subtipo</option>
                        </select>
                        @error('incident_subtype')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="incident_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-1 text-blue-500"></i>
                        Descripción de la Novedad
                    </label>
                    <textarea name="incident_description" id="incident_description" rows="3" 
                              placeholder="Describa detalladamente el incidente ocurrido..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('incident_description', $individualCommittee->incident_description) }}</textarea>
                    @error('incident_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Información de la Falta -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-blue-100 text-blue-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Información de la Falta
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="offense_class" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-blue-500"></i>
                            Tipo de Falta
                        </label>
                        <select name="offense_class" id="offense_class" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">Seleccionar tipo</option>
                            <option value="Leve" {{ old('offense_class', $individualCommittee->offense_class) == 'Leve' ? 'selected' : '' }}>Leve</option>
                            <option value="Grave" {{ old('offense_class', $individualCommittee->offense_class) == 'Grave' ? 'selected' : '' }}>Grave</option>
                            <option value="Gravísimo" {{ old('offense_class', $individualCommittee->offense_class) == 'Gravísimo' ? 'selected' : '' }}>Gravísimo</option>
                        </select>
                        @error('offense_class')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label for="offense_classification" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-1 text-blue-500"></i>
                        Descripción de la Falta
                    </label>
                    <textarea name="offense_classification" id="offense_classification" rows="3" 
                              placeholder="Describa detalladamente la clasificación de la falta..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('offense_classification', $individualCommittee->offense_classification) }}</textarea>
                    @error('offense_classification')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Descargos del Aprendiz -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-green-100 text-green-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-comments mr-2"></i>
                    Descargos del Aprendiz
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <label for="statement" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas a-user-edit mr-1 text-blue-500"></i>
                        Descargos del Aprendiz
                    </label>
                    <textarea name="statement" id="statement" rows="3" 
                              placeholder="Escriba aquí los descargos presentados por el aprendiz..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('statement', $individualCommittee->statement) }}</textarea>
                    @error('statement')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>


        <!-- Información Adicional -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-indigo-100 text-indigo-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Información Adicional
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                        <label for="missing_rating" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-star mr-1 text-blue-500"></i>
                            Calificación Faltante
                        </label>
                        <textarea name="missing_rating" id="missing_rating" rows="3" 
                                  placeholder="Especifique las calificaciones faltantes..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('missing_rating', $individualCommittee->missing_rating) }}</textarea>
                        @error('missing_rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                        <label for="recommendations" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lightbulb mr-1 text-blue-500"></i>
                            Recomendaciones
                        </label>
                        <textarea name="recommendations" id="recommendations" rows="3" 
                                  placeholder="Escriba las recomendaciones..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('recommendations', $individualCommittee->recommendations) }}</textarea>
                        @error('recommendations')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                        <label for="observations" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-eye mr-1 text-blue-500"></i>
                            Observaciones
                        </label>
                        <textarea name="observations" id="observations" rows="3" 
                                  placeholder="Escriba observaciones adicionales..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('observations', $individualCommittee->observations) }}</textarea>
                        @error('observations')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Decisión y Compromisos -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-orange-100 text-orange-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-gavel mr-2"></i>
                    Decisión y Compromisos
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                        <label for="commitments" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-handshake mr-1 text-blue-500"></i>
                            Compromisos
                        </label>
                        <textarea name="commitments" id="commitments" rows="5" 
                                  placeholder="Escriba aquí los compromisos acordados..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('commitments', $individualCommittee->commitments) }}</textarea>
                        @error('commitments')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                        <label for="decision" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-balance-scale mr-1 text-blue-500"></i>
                            Decisión
                        </label>
                        <textarea name="decision" id="decision" rows="5" 
                                  placeholder="Escriba aquí la decisión del comité..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('decision', $individualCommittee->decision) }}</textarea>
                        @error('decision')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4">
            <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('committee.individual.show', $individualCommittee) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-all duration-200 flex items-center justify-center space-x-2 font-medium text-sm">
                    <i class="fas fa-times"></i>
                    <span>Cancelar</span>
                </a>
                <button type="submit" 
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-md transition-all duration-200 flex items-center justify-center space-x-2 font-medium text-sm">
                    <i class="fas fa-save"></i>
                    <span>Actualizar Comité</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const incidentTypeSelect = document.getElementById('incident_type');
    const incidentSubtypeSelect = document.getElementById('incident_subtype');
    
    // Almacenar el valor original del subtipo
    const originalSubtype = '{{ old("incident_subtype", $individualCommittee->incident_subtype) }}';
    
    // Configurar el atributo data-original-value
    if (incidentSubtypeSelect) {
        incidentSubtypeSelect.setAttribute('data-original-value', originalSubtype);
    }
    
    // Función para poblar subtipos basado en el tipo seleccionado
    function populateSubtypes(incidentType) {
        if (!incidentSubtypeSelect) return;
        
        // Limpiar opciones existentes
        incidentSubtypeSelect.innerHTML = '<option value="">Seleccionar subtipo</option>';
        
        const subtypes = {
            'CANCELACION_MATRICULA_ACADEMICO': [
                { value: 'INCUMPLIMIENTO_CONTRATO_APRENDIZAJE', text: 'INCUMPLIMIENTO CONTRATO DE APRENDIZAJE' },
                { value: 'NO_CUMPLIO_PLAN_MEJORAMIENTO', text: 'NO CUMPLIÓ PLAN DE MEJORAMIENTO' }
            ],
            'CANCELACION_MATRICULA_DISCIPLINARIO': [
                { value: 'NO_CUMPLIO_PLAN_MEJORAMIENTO', text: 'NO CUMPLIÓ PLAN DE MEJORAMIENTO' },
                { value: 'SANCION_IMPUESTA_MEDIANTE_DEBIDO_PROCESO', text: 'SANCIÓN IMPUESTA MEDIANTE DEBIDO PROCESO' }
            ],
            'CONDICIONAMIENTO_MATRICULA': [
                { value: 'CONCERTACION_PLAN_DE_MEJORAMIENTO', text: 'CONCERTACIÓN PLAN DE MEJORAMIENTO' }
            ],
            'DESERCION_PROCESO_FORMACION': [
                { value: 'INCUMPLIMIENTO_INASISTENCIA_3_DIAS', text: 'INCUMPLIMIENTO - INASISTENCIA 3 DIAS CONSECUTIVOS O MÁS SIN JUSTIFICACIÓN' },
                { value: 'NO_PRESENTA_EVIDENCIA_ETAPA_PRODUCTIVA', text: 'NO PRESENTA EVIDENCIA REALIZACIÓN ETAPA PRODUCTIVA' },
                { value: 'NO_SE_REINTEGRA_APLAZAMIENTO', text: 'NO SE REINTEGRA A PARTIR DE LA FECHA LÍMITE AUTORIZADO APLAZAMIENTO' }
            ],
            'NO_GENERACION_CERTIFICADO': [
                { value: 'FORMACION_NO_REALIZADA', text: 'FORMACIÓN NO REALIZADA' },
                { value: 'PROGRAMA_DE_FORMACION_REALIZADO_NO_CORRESPONDE', text: 'PROGRAMA DE FORMACIÓN REALIZADO NO CORRESPONDE' }
            ],
            'RETIRO_POR_FRAUDE': [
                { value: 'SUPLANTACION_DATOS_BASICOS_PARA_CERTIFICARSE', text: 'SUPLANTACIÓN DATOS BÁSICOS PARA CERTIFICARSE' }
            ],
            'RETIRO_PROCESO_FORMACION': [
                { value: 'NO_INICIO_PROCESO_FORMACION', text: 'NO INICIÓ PROCESO DE FORMACIÓN' },
                { value: 'POR_FALLECIMIENTO', text: 'POR FALLECIMIENTO' }
            ],
            'TRASLADO_CENTRO': [
                { value: 'CAMBIO_DE_DOMICILIO', text: 'CAMBIO DE DOMICILIO' },
                { value: 'MOTIVOS_LABORALES', text: 'MOTIVOS LABORALES' },
                { value: 'MOTIVOS_PERSONALES', text: 'MOTIVOS PERSONALES' }
            ],
            'TRASLADO_JORNADA': [
                { value: 'MOTIVOS_LABORALES', text: 'MOTIVOS LABORALES' },
                { value: 'MOTIVOS_PERSONALES', text: 'MOTIVOS PERSONALES' }
            ],
            'TRASLADO_PROGRAMA': [
                { value: 'MOTIVOS_PERSONALES', text: 'MOTIVOS PERSONALES' }
            ]
        };
        
        if (subtypes[incidentType]) {
            subtypes[incidentType].forEach(subtype => {
                const option = document.createElement('option');
                option.value = subtype.value;
                option.textContent = subtype.text;
                incidentSubtypeSelect.appendChild(option);
            });
        }
        
        // Restaurar el valor original si existe
        if (originalSubtype && originalSubtype !== '') {
            incidentSubtypeSelect.value = originalSubtype;
        }
    }
    
    // Función para inicializar subtipos
    function initializeIncidentSubtypes() {
        if (incidentTypeSelect && incidentSubtypeSelect) {
            const currentType = incidentTypeSelect.value;
            if (currentType) {
                populateSubtypes(currentType);
            }
        }
    }
    
    // Event listener para cambio de tipo de novedad
    if (incidentTypeSelect) {
        incidentTypeSelect.addEventListener('change', function() {
            populateSubtypes(this.value);
        });
        
        // Inicializar subtipos con el valor actual
        initializeIncidentSubtypes();
    }
});
</script>
@endsection
