@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Mensajes -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Principal tipo Modal -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header con foto de perfil -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center overflow-hidden border-4 border-white shadow-xl">
                                <span class="text-blue-600 text-3xl font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                            <p class="text-blue-100 mt-1">{{ $user->email }}</p>
                            <span class="inline-block mt-2 px-3 py-1 bg-white bg-opacity-20 text-white rounded-full text-sm font-medium">
                                <i class="fas fa-shield-alt mr-1"></i>Administrador
                            </span>
                        </div>
                    </div>
                    <button onclick="toggleEdit()" id="edit-btn" class="px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition-colors font-medium shadow-lg">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-8">
                <!-- Vista de solo lectura -->
                <div id="view-mode">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Columna Izquierda -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-user text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600 font-medium">Nombre</span>
                                </div>
                                <p class="text-gray-900 font-semibold ml-8">{{ $user->name ?? 'No especificado' }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-envelope text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600 font-medium">Correo Electrónico</span>
                                </div>
                                <p class="text-gray-900 font-semibold ml-8">{{ $user->email }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-phone text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600 font-medium">Teléfono</span>
                                </div>
                                <p class="text-gray-900 font-semibold ml-8">{{ $user->phone ?? 'No especificado' }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-building text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600 font-medium">Empresa</span>
                                </div>
                                <p class="text-gray-900 font-semibold ml-8">{{ $user->company ?? 'No especificado' }}</p>
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-briefcase text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600 font-medium">Cargo</span>
                                </div>
                                <p class="text-gray-900 font-semibold ml-8">{{ $user->position ?? 'No especificado' }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600 font-medium">Dirección</span>
                                </div>
                                <p class="text-gray-900 font-semibold ml-8">{{ $user->address ?? 'No especificado' }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-file-alt text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600 font-medium">Biografía</span>
                                </div>
                                <p class="text-gray-900 ml-8">{{ $user->biography ?? 'No especificado' }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-calendar text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600 font-medium">Miembro desde</span>
                                </div>
                                <p class="text-gray-900 font-semibold ml-8">{{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Volver -->
                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Volver al Dashboard
                        </a>
                    </div>
                </div>

                <!-- Formulario de edición -->
                <form id="edit-mode" method="POST" action="{{ route('profile.update') }}" class="hidden">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2"></i>Nombre
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2"></i>Correo Electrónico
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone mr-2"></i>Teléfono
                            </label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building mr-2"></i>Empresa
                            </label>
                            <input type="text" name="company" id="company" value="{{ old('company', $user->company) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-briefcase mr-2"></i>Cargo
                            </label>
                            <input type="text" name="position" id="position" value="{{ old('position', $user->position) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>Dirección
                            </label>
                            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="biography" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-file-alt mr-2"></i>Biografía
                        </label>
                        <textarea name="biography" id="biography" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('biography', $user->biography) }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <button type="button" onclick="toggleEdit()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Cancelar
                        </button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-save mr-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEdit() {
    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');
    const editBtn = document.getElementById('edit-btn');
    
    if (viewMode.classList.contains('hidden')) {
        viewMode.classList.remove('hidden');
        editMode.classList.add('hidden');
        editBtn.innerHTML = '<i class="fas fa-edit mr-2"></i>Editar';
    } else {
        viewMode.classList.add('hidden');
        editMode.classList.remove('hidden');
        editBtn.innerHTML = '<i class="fas fa-times mr-2"></i>Cancelar';
    }
}

</script>
@endsection
