<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="{ isOpen: @entangle('isOpen') }">
    {{-- Notificaciones --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "{{ session('success') }}",
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#22c55e',
                confirmButtonColor: '#3b82f6',
                customClass: { popup: 'rounded-lg shadow-lg' }
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#ef4444',
                confirmButtonColor: '#3b82f6',
                customClass: { popup: 'rounded-lg shadow-lg text-left' }
            });
        </script>
    @endif

    <!-- Tabla de Movimientos -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Lista de Movimientos de Stock</h1>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Producto</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Tipo</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Cantidad</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Stock Anterior</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Stock Actual</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Motivo</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Usuario</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Fecha</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @forelse ($movimientos as $mov)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $mov->producto->nombre }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ ucfirst($mov->tipo_movimiento) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $mov->cantidad }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $mov->stock_anterior }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $mov->stock_actual }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $mov->motivo ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $mov->usuario ? $mov->usuario->name : '-' }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $mov->fecha_movimiento->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                <button wire:click="openModal({{ $mov->id }})" class="text-blue-500 hover:text-blue-400 mr-3 inline-flex">
                                    <!-- Icono editar -->
                                </button>
                                <button onclick="confirmDelete({{ $mov->id }})" class="text-red-500 hover:text-red-400 inline-flex">
                                    <!-- Icono eliminar -->
                                </button>
                                <form id="delete-form-{{ $mov->id }}" action="{{ route('admin.movimiento_stock.destroy', $mov->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-zinc-400">No hay movimientos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $movimientos->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Livewire (ejemplo simple) -->
    <div x-show="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-zinc-900 p-6 rounded-xl w-1/2">
            <h2 class="text-white font-bold text-lg mb-4">Editar Movimiento</h2>
            <form wire:submit.prevent="update">
                <div class="mb-4">
                    <label class="text-white">Producto</label>
                    <select wire:model="producto_id" class="w-full p-2 rounded bg-zinc-800 text-white">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="isOpen = false" class="bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Eliminar movimiento?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        background: '#18181b',
        color: '#f4f4f5',
        iconColor: '#ef4444',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: { popup: 'rounded-lg shadow-lg' }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
