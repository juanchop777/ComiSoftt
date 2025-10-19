@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-2xl font-bold text-gray-800">Comités Generales</h2>
    <a href="{{ route('committee.general.create') }}" class="p-3 rounded bg-blue-600 text-white hover:bg-blue-700 transition-colors" title="Nuevo Comité General">
      <i class="fas fa-plus"></i>
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-50 text-green-800 border border-green-200 rounded p-3 mb-4">{{ session('success') }}</div>
  @endif

  {{-- Filtros de búsqueda --}}
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="{{ route('committee.general.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
      <div class="flex-1">
        <input type="text" 
               id="act_number" 
               name="act_number" 
               value="{{ request('act_number') }}"
               placeholder="Buscar por acta..."
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
      </div>
      
      <div class="flex-1">
        <input type="date" 
               id="session_date" 
               name="session_date" 
               value="{{ request('session_date') }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
      </div>
      
      <div class="flex gap-2">
        <button type="submit" 
                class="p-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center" title="Buscar">
          <i class="fas fa-search"></i>
        </button>
        
        @if(request()->hasAny(['act_number', 'session_date']))
        <a href="{{ route('committee.general.index') }}" 
           class="p-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center" title="Limpiar">
          <i class="fas fa-times"></i>
        </a>
        @endif
      </div>
    </form>
    
    @if(request()->hasAny(['act_number', 'session_date']))
    <div class="mt-3 p-2 bg-blue-50 border border-blue-200 rounded-md">
      <div class="flex items-center">
        <i class="fas fa-info-circle text-blue-600 mr-2 text-sm"></i>
        <span class="text-sm text-blue-800">
          <strong>Filtros activos:</strong>
          @if(request('act_number'))
            Acta: "{{ request('act_number') }}"
          @endif
          @if(request('act_number') && request('session_date'))
            |
          @endif
          @if(request('session_date'))
            Fecha: "{{ request('session_date') }}"
          @endif
        </span>
      </div>
    </div>
    @endif
  </div>

  <div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Fecha Sesión</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Acta</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Modalidad</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Tipo de falta</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($committees as $c)
          <tr>
            <td class="px-4 py-2 text-sm text-gray-800">{{ $c->session_date }} {{ $c->session_time }}</td>
            <td class="px-4 py-2 text-sm text-gray-800">#{{ $c->act_number }}</td>
            <td class="px-4 py-2 text-sm">
              <span class="px-2 py-1 rounded text-white {{ $c->attendance_mode==='Virtual' ? 'bg-indigo-500' : ($c->attendance_mode==='No asistió' ? 'bg-gray-500' : 'bg-green-600') }}">{{ $c->attendance_mode }}</span>
            </td>
            <td class="px-4 py-2 text-sm text-gray-800">{{ $c->offense_class }}</td>
            <td class="px-4 py-2 text-sm">
              <div class="flex gap-2">
                <a href="{{ route('committee.general.show', $c->general_committee_id) }}" 
                   class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors" 
                   title="Ver detalles">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('committee.general.edit', $c->general_committee_id) }}" 
                   class="p-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors" 
                   title="Editar comité">
                  <i class="fas fa-edit"></i>
                </a>
                <button onclick="confirmDelete({{ $c->general_committee_id }}, '{{ $c->act_number }}')" 
                        class="p-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors" 
                        title="Eliminar comité">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No hay comités generales registrados.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginación --}}
  @if($committees->count() > 0)
  <div class="mt-6 flex items-center justify-between">
      <div class="text-sm text-gray-700">
          Mostrando {{ $committees->firstItem() ?? 0 }} a {{ $committees->lastItem() ?? 0 }} de {{ $committees->total() }} resultados
      </div>
      <div class="flex items-center space-x-2">
          {{ $committees->appends(request()->query())->links('pagination::tailwind') }}
      </div>
  </div>
  @endif
</div>

<!-- Formulario oculto para eliminación -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
function confirmDelete(committeeId, actNumber) {
    Swal.fire({
        title: '¿Eliminar comité?',
        html: `¿Estás seguro de que quieres eliminar el comité del <strong>Acta #${actNumber}</strong>?<br><br>Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Sí, eliminar',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancelar',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espera',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            const form = document.getElementById('deleteForm');
            form.action = `/committee/general/${committeeId}`;
            form.submit();
        }
    });
}

</script>
@endsection



