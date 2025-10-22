@extends('layouts.admin')

@section('title', 'Editar Acta final')

@section('content')
<div class="max-w-6xl mx-auto p-8 bg-white rounded-xl shadow-lg border border-gray-200">
    <form action="{{ route('final-minutes.update', $finalMinute) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Header -->
        <div class="bg-blue-600 text-white p-8 rounded-xl text-center shadow-lg -m-8 mb-8">
            <i class="fas fa-edit text-4xl mb-4 block"></i>
            <h2 class="text-3xl font-bold">Editar Acta Final #{{ $finalMinute->act_number }}</h2>
        </div>
        
        <!-- ACTA No. -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="text-center mb-4">
                <label class="text-blue-600 text-3xl font-bold block mb-4">ACTA No.</label>
                <input type="text" name="act_number" value="{{ old('act_number', $finalMinute->act_number) }}" class="text-center text-2xl font-bold text-blue-600 border-2 border-blue-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 w-32" required>
            </div>
        </div>

        <!-- NOMBRE DEL COMITÉ O DE LA REUNIÓN -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="flex items-center bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <label class="font-bold text-gray-800 min-w-64 mr-5 text-sm uppercase tracking-wide">NOMBRE DEL COMITÉ O DE LA REUNIÓN:</label>
                <input type="text" name="committee_name" value="{{ old('committee_name', $finalMinute->committee_name) }}" class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" required>
            </div>
        </div>

        <!-- CIUDAD Y FECHA / HORAS -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="flex gap-6 mb-6">
                <!-- Columna izquierda: CIUDAD Y FECHA -->
                <div class="flex-1 bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="space-y-4">
                        <div>
                            <label class="font-bold text-gray-800 mb-2 block text-sm uppercase tracking-wide">CIUDAD:</label>
                            <input type="text" name="city" value="{{ old('city', $finalMinute->city) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" required>
                        </div>
                        <div>
                            <label class="font-bold text-gray-800 mb-2 block text-sm uppercase tracking-wide">FECHA:</label>
                            <input type="date" name="date" value="{{ old('date', $finalMinute->date->format('Y-m-d')) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" required>
                        </div>
                    </div>
                </div>
                
                <!-- Columna derecha: HORAS -->
                <div class="flex-1 bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="space-y-4">
                        <div>
                            <label class="font-bold text-gray-800 mb-2 block text-sm uppercase tracking-wide">HORA INICIO:</label>
                            <input type="time" name="start_time" value="{{ old('start_time', $finalMinute->start_time ? $finalMinute->start_time->format('H:i') : '') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" required>
                        </div>
                        <div>
                            <label class="font-bold text-gray-800 mb-2 block text-sm uppercase tracking-wide">HORA FIN:</label>
                            <input type="time" name="end_time" value="{{ old('end_time', $finalMinute->end_time ? $finalMinute->end_time->format('H:i') : '') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LUGAR Y DIRECCIÓN -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="flex gap-6">
                <!-- Columna izquierda: LUGAR Y/O ENLACE -->
                <div class="flex-1 bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <label class="font-bold text-gray-800 mb-3 block text-sm uppercase tracking-wide">LUGAR Y/O ENLACE:</label>
                    <input type="text" name="place_link" value="{{ old('place_link', $finalMinute->place_link) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                </div>
                
                <!-- Columna derecha: DIRECCIÓN -->
                <div class="flex-1 bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <label class="font-bold text-gray-800 mb-3 block text-sm uppercase tracking-wide">DIRECCIÓN / REGIONAL / CENTRO:</label>
                    <input type="text" name="address_regional_center" value="{{ old('address_regional_center', $finalMinute->address_regional_center) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                </div>
            </div>
        </div>

        <!-- CONCLUSIONES -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="text-center font-bold text-gray-800 text-xl mb-6 uppercase tracking-wide relative pb-4">
                CONCLUSIONES
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-blue-500 rounded-full"></div>
            </div>
            <textarea name="conclusions" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 min-h-32 resize-y">{{ old('conclusions', $finalMinute->conclusions) }}</textarea>
        </div>

        <!-- ARCHIVOS EXISTENTES -->
        @if($finalMinute->attachments && count($finalMinute->attachments) > 0)
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-green-500">
            <div class="text-center font-bold text-gray-800 text-xl mb-6 uppercase tracking-wide relative pb-4">
                ARCHIVOS ACTUALES ({{ count($finalMinute->attachments) }})
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-green-500 rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($finalMinute->attachments as $index => $attachment)
                <div class="bg-white p-4 rounded-lg border border-gray-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @php
                            $extension = pathinfo($attachment['original_name'], PATHINFO_EXTENSION);
                            $iconClass = match(strtolower($extension)) {
                                'pdf' => 'fas fa-file-pdf text-red-500',
                                'doc', 'docx' => 'fas fa-file-word text-blue-500',
                                'xls', 'xlsx' => 'fas fa-file-excel text-green-500',
                                'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-purple-500',
                                'txt' => 'fas fa-file-alt text-gray-500',
                                default => 'fas fa-file text-gray-500'
                            };
                        @endphp
                        <i class="{{ $iconClass }} text-xl"></i>
                        <div>
                            <p class="font-medium text-gray-900">{{ $attachment['original_name'] }}</p>
                            <p class="text-sm text-gray-500">{{ number_format($attachment['size'] / 1024, 1) }} KB</p>
                        </div>
                    </div>
                    <a href="{{ route('final-minutes.download', ['finalMinute' => $finalMinute->id, 'attachmentIndex' => $index]) }}" 
                       class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50 transition-colors duration-200" 
                       title="Descargar">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- NUEVOS ANEXOS -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="text-center font-bold text-gray-800 text-xl mb-6 uppercase tracking-wide relative pb-4">
                AGREGAR NUEVOS ANEXOS
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-blue-500 rounded-full"></div>
            </div>
            <p class="text-center text-blue-600 text-sm italic bg-blue-50 px-4 py-2 rounded-full inline-block mb-4">
                (Fotografías o pantallazos del encuentro o evidencias de fallas en la plataforma)
            </p>
            
            <!-- Contenedor de archivos -->
            <div id="attachments-container" class="space-y-4">
                <!-- Archivo inicial -->
                <div class="attachment-item bg-white p-4 rounded-lg border-2 border-gray-300 hover:border-blue-400 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 flex-1">
                            <i class="fas fa-paperclip text-blue-500 text-xl"></i>
                            <input type="file" name="attachments[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" accept="image/*,.pdf,.doc,.docx,.txt,.xls,.xlsx" onchange="updateFileName(this)">
                            <span class="file-name text-sm text-gray-600 min-w-0 flex-1">Sin archivo seleccionado</span>
                        </div>
                        <button type="button" onclick="removeAttachment(this)" class="ml-4 text-red-500 hover:text-red-700 transition-colors duration-200 p-2 rounded-full hover:bg-red-50" title="Eliminar archivo">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Botón para agregar más archivos -->
            <div class="text-center mt-6">
                <button type="button" onclick="addAttachment()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>
                    Agregar Otro Archivo
                </button>
            </div>
        </div>

        <!-- AVISO LEGAL -->
        <div class="bg-gray-100 p-6 rounded-lg border-l-4 border-blue-500">
            <p class="text-sm text-gray-700 leading-relaxed text-justify">
                <strong>De acuerdo con La Ley 1581 de 2012, Protección de Datos Personales,</strong> el Servicio Nacional de Aprendizaje SENA, se compromete a garantizar la seguridad y protección de los datos personales que se encuentran almacenados en este documento, y les dará el tratamiento correspondiente en cumplimiento de lo establecido legalmente.
            </p>
        </div>

        <!-- BOTONES -->
        <div class="text-center pt-8 border-t-2 border-gray-200">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 uppercase tracking-wide mr-4">
                <i class="fas fa-save mr-2"></i>
                Actualizar Acta
            </button>
            <a href="{{ route('final-minutes.show', $finalMinute) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 uppercase tracking-wide">
                <i class="fas fa-arrow-left mr-2"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script de anexos cargado correctamente');
});

// Función para actualizar el nombre del archivo seleccionado
function updateFileName(input) {
    const fileNameSpan = input.parentElement.querySelector('.file-name');
    if (input.files && input.files[0]) {
        fileNameSpan.textContent = input.files[0].name;
        fileNameSpan.classList.remove('text-gray-600');
        fileNameSpan.classList.add('text-green-600', 'font-medium');
    } else {
        fileNameSpan.textContent = 'Sin archivo seleccionado';
        fileNameSpan.classList.remove('text-green-600', 'font-medium');
        fileNameSpan.classList.add('text-gray-600');
    }
}

// Función para agregar un nuevo campo de archivo
function addAttachment() {
    const container = document.getElementById('attachments-container');
    const attachmentCount = container.children.length;
    
    // Crear nuevo elemento de archivo
    const newAttachment = document.createElement('div');
    newAttachment.className = 'attachment-item bg-white p-4 rounded-lg border-2 border-gray-300 hover:border-blue-400 transition-all duration-300';
    newAttachment.innerHTML = `
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4 flex-1">
                <i class="fas fa-paperclip text-blue-500 text-xl"></i>
                <input type="file" name="attachments[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" accept="image/*,.pdf,.doc,.docx,.txt,.xls,.xlsx" onchange="updateFileName(this)">
                <span class="file-name text-sm text-gray-600 min-w-0 flex-1">Sin archivo seleccionado</span>
            </div>
            <button type="button" onclick="removeAttachment(this)" class="ml-4 text-red-500 hover:text-red-700 transition-colors duration-200 p-2 rounded-full hover:bg-red-50" title="Eliminar archivo">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    // Agregar con animación
    newAttachment.style.opacity = '0';
    newAttachment.style.transform = 'translateY(-20px)';
    container.appendChild(newAttachment);
    
    // Animar la entrada
    setTimeout(() => {
        newAttachment.style.transition = 'all 0.3s ease';
        newAttachment.style.opacity = '1';
        newAttachment.style.transform = 'translateY(0)';
    }, 10);
    
    // Mostrar mensaje de éxito
    showMessage('Nuevo campo de archivo agregado', 'success');
}

// Función para eliminar un campo de archivo
function removeAttachment(button) {
    const attachmentItem = button.closest('.attachment-item');
    const container = document.getElementById('attachments-container');
    
    // No permitir eliminar si solo queda un campo
    if (container.children.length <= 1) {
        showMessage('Debe mantener al menos un campo de archivo', 'warning');
        return;
    }
    
    // Animar la salida
    attachmentItem.style.transition = 'all 0.3s ease';
    attachmentItem.style.opacity = '0';
    attachmentItem.style.transform = 'translateX(-100%)';
    
    setTimeout(() => {
        container.removeChild(attachmentItem);
        showMessage('Campo de archivo eliminado', 'info');
    }, 300);
}

// Función para mostrar mensajes
function showMessage(message, type = 'info') {
    // Crear elemento de mensaje
    const messageDiv = document.createElement('div');
    messageDiv.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    const colors = {
        success: 'bg-green-500 text-white',
        warning: 'bg-yellow-500 text-white',
        info: 'bg-blue-500 text-white',
        error: 'bg-red-500 text-white'
    };
    
    messageDiv.className += ` ${colors[type] || colors.info}`;
    messageDiv.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'times' : 'info'}-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(messageDiv);
    
    // Animar entrada
    setTimeout(() => {
        messageDiv.style.transform = 'translateX(0)';
    }, 10);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        messageDiv.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.parentNode.removeChild(messageDiv);
            }
        }, 300);
    }, 3000);
}

// Validación del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    const fileInputs = document.querySelectorAll('input[type="file"][name="attachments[]"]');
    let hasFiles = false;
    
    fileInputs.forEach(input => {
        if (input.files && input.files.length > 0) {
            hasFiles = true;
        }
    });
    
    // En edición, no es obligatorio tener archivos nuevos
    if (!hasFiles) {
        // Permitir envío sin archivos nuevos
        return true;
    }
    
    // Validar tipos de archivo si hay archivos
    let invalidFiles = [];
    fileInputs.forEach(input => {
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach(file => {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
                if (!allowedTypes.includes(file.type)) {
                    invalidFiles.push(file.name);
                }
            });
        }
    });
    
    if (invalidFiles.length > 0) {
        e.preventDefault();
        showMessage(`Archivos no válidos: ${invalidFiles.join(', ')}. Solo se permiten imágenes, PDF, Word, Excel y archivos de texto.`, 'error');
        return false;
    }
});
</script>
@endsection

