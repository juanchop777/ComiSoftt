@extends('layouts.admin')

@section('title', 'Actas Finales')

@section('content')

<div class="max-w-7xl mx-auto p-8">
    <!-- Header -->
    <div class="bg-blue-600 text-white p-8 rounded-xl text-center shadow-lg -m-8 mb-8">
        <i class="fas fa-file-contract text-4xl mb-4 block"></i>
        <h1 class="text-3xl font-bold">Actas Finales</h1>
        <p class="text-blue-100 mt-2">Gestión de actas de reunión</p>
    </div>

    <!-- Botón Crear -->
    <div class="mb-6">
        <a href="{{ route('final-minutes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <i class="fas fa-plus mr-2"></i>
            Nueva Acta Final
        </a>
    </div>

    <!-- Tabla de Actas -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wide">Número de Acta</th>
                    <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wide">Comité</th>
                    <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wide">Ciudad</th>
                    <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wide">Fecha</th>
                    <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wide">Horario</th>
                    <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($finalMinutes as $finalMinute)
                <tr class="hover:bg-gray-50 border-b border-gray-200">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $finalMinute->act_number }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $finalMinute->committee_name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $finalMinute->city }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $finalMinute->date->format('d/m/Y') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $finalMinute->start_time->format('H:i') }} - {{ $finalMinute->end_time->format('H:i') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('final-minutes.show', $finalMinute) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-sm transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('final-minutes.edit', $finalMinute) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-sm transition-all duration-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('final-minutes.destroy', $finalMinute) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta acta?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm transition-all duration-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-file-contract text-4xl mb-4 block text-gray-300"></i>
                        <p class="text-lg">No hay actas finales registradas</p>
                        <p class="text-sm text-gray-400 mt-2">Crea tu primera acta final</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    @if($finalMinutes->hasPages())
    <div class="mt-6">
        {{ $finalMinutes->links() }}
    </div>
    @endif
</div>

@endsection


