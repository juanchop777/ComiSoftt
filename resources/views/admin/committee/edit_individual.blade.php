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
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-eye"></i>
                <span>Ver</span>
            </a>
            <a href="{{ route('committee.individual.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
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
                                    <label for="id_document" class="block text-sm font-semibold text-gray-700 mb-1">Documento</label>
                                    <input type="text" name="id_document" id="id_document" 
                                           value="{{ old('id_document', $individualCommittee->id_document) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('id_document')
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="incident_type" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-blue-500"></i>
                            Tipo de Novedad
                        </label>
                        <select name="incident_type" id="incident_type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">Seleccionar tipo</option>
                            <option value="Academic" {{ old('incident_type', $individualCommittee->incident_type) == 'Academic' ? 'selected' : '' }}>Académica</option>
                            <option value="Disciplinary" {{ old('incident_type', $individualCommittee->incident_type) == 'Disciplinary' ? 'selected' : '' }}>Disciplinaria</option>
                            <option value="Other" {{ old('incident_type', $individualCommittee->incident_type) == 'Other' ? 'selected' : '' }}>Otra</option>
                        </select>
                        @error('incident_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label for="incident_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-1 text-blue-500"></i>
                        Descripción de la novedad
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

        <!-- Decisión del Comité -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-yellow-100 text-yellow-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-gavel mr-2"></i>
                    Decisión del Comité
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label for="decision" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-balance-scale mr-1 text-blue-500"></i>
                        Decisión del Comité
                    </label>
                    <textarea name="decision" id="decision" rows="3" 
                              placeholder="Escriba aquí la decisión tomada por el comité..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('decision', $individualCommittee->decision) }}</textarea>
                    @error('decision')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Compromisos y Seguimiento -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-blue-100 text-blue-800 px-4 py-3">
                <h3 class="text-lg font-bold flex items-center">
                    <i class="fas fa-clipboard-check mr-2"></i>
                    Compromisos y Seguimiento
                </h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                        <label for="commitments" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-handshake mr-1 text-blue-500"></i>
                            Compromisos Acordados
                        </label>
                        <textarea name="commitments" id="commitments" rows="3" 
                                  placeholder="Escriba aquí los compromisos acordados..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('commitments', $individualCommittee->commitments) }}</textarea>
                        @error('commitments')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                        <label for="missing_rating" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-star mr-1 text-blue-500"></i>
                            Calificación Faltante
                        </label>
                        <textarea name="missing_rating" id="missing_rating" rows="3" 
                                  placeholder="Escriba aquí la calificación faltante..."
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
                                  placeholder="Escriba aquí las recomendaciones..."
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
                                  placeholder="Escriba aquí las observaciones..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('observations', $individualCommittee->observations) }}</textarea>
                        @error('observations')
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
@endsection
