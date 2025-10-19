@extends('layouts.admin')

@section('title', 'Crear Acta de Reunión')

@section('content')

<div class="max-w-6xl mx-auto p-8 bg-white rounded-xl shadow-lg border border-gray-200">
    <form action="{{ route('final-minutes.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Header -->
        <div class="bg-blue-600 text-white p-8 rounded-xl text-center shadow-lg -m-8 mb-8">
            <i class="fas fa-file-contract text-4xl mb-4 block"></i>
            <h2 class="text-3xl font-bold">Crear Acta de Reunión</h2>
        </div>
        
        <!-- ACTA No. -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="text-center mb-4">
                <label class="text-blue-600 text-3xl font-bold block mb-4">ACTA No.</label>
                <input type="text" name="act_number" class="text-center text-2xl font-bold text-blue-600 border-2 border-blue-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 w-32" placeholder="00" required>
            </div>
        </div>

        <!-- NOMBRE DEL COMITÉ O DE LA REUNIÓN -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="flex items-center bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <label class="font-bold text-gray-800 min-w-64 mr-5 text-sm uppercase tracking-wide">NOMBRE DEL COMITÉ O DE LA REUNIÓN:</label>
                <input type="text" name="committee_name" class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" placeholder="Ingrese el nombre del comité o reunión" required>
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
                            <input type="text" name="city" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" placeholder="Ej: Bogotá" required>
                        </div>
                        <div>
                            <label class="font-bold text-gray-800 mb-2 block text-sm uppercase tracking-wide">FECHA:</label>
                            <input type="date" name="date" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" required>
                        </div>
                    </div>
                </div>
                
                <!-- Columna derecha: HORAS -->
                <div class="flex-1 bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="space-y-4">
                        <div>
                            <label class="font-bold text-gray-800 mb-2 block text-sm uppercase tracking-wide">HORA INICIO:</label>
                            <input type="time" name="start_time" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" required>
                        </div>
                        <div>
                            <label class="font-bold text-gray-800 mb-2 block text-sm uppercase tracking-wide">HORA FIN:</label>
                            <input type="time" name="end_time" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" required>
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
                    <input type="text" name="place_link" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" placeholder="Lugar físico o enlace virtual">
                </div>
                
                <!-- Columna derecha: DIRECCIÓN -->
                <div class="flex-1 bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <label class="font-bold text-gray-800 mb-3 block text-sm uppercase tracking-wide">DIRECCIÓN / REGIONAL / CENTRO:</label>
                    <input type="text" name="address_regional_center" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" placeholder="Dirección del centro regional">
                </div>
            </div>
        </div>

        <!-- CONCLUSIONES -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="text-center font-bold text-gray-800 text-xl mb-6 uppercase tracking-wide relative pb-4">
                CONCLUSIONES
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-blue-500 rounded-full"></div>
            </div>
            <textarea name="conclusions" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 min-h-32 resize-y" placeholder="Escriba las conclusiones de la reunión"></textarea>
        </div>

        <!-- ANEXOS -->
        <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
            <div class="text-center font-bold text-gray-800 text-xl mb-6 uppercase tracking-wide relative pb-4">
                ANEXOS
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-blue-500 rounded-full"></div>
            </div>
            <p class="text-center text-blue-600 text-sm italic bg-blue-50 px-4 py-2 rounded-full inline-block mb-4">
                (Fotografías o pantallazos del encuentro o evidencias de fallas en la plataforma)
            </p>
            <input type="file" name="attachments[]" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" multiple accept="image/*,.pdf,.doc,.docx">
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
                Guardar Acta
            </button>
            <a href="{{ route('final-minutes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 uppercase tracking-wide">
                <i class="fas fa-arrow-left mr-2"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
// Script simplificado - solo funcionalidades básicas del formulario
</script>
@endsection
