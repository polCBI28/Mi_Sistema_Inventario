<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="ventaTable()">
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

    {{-- Tabla de Ventas --}}
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Lista de Ventas</h1>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Fecha</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Cliente</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Tipo Comp.</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">N° Comprobante</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Estado</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @forelse ($ventas as $venta)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $venta->fecha }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $venta->cliente?->nombre ?? 'Consumidor final' }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">S/. {{ number_format($venta->total,2) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $venta->tipo_comprobante }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $venta->numero_comprobante }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $venta->estado }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                <!-- Botón Editar -->
                                <button 
                                    @click="openModal({{ $venta->id }}, '{{ $venta->fecha }}', {{ $venta->total }}, '{{ $venta->cliente_id }}', '{{ $venta->tipo_comprobante }}', '{{ $venta->numero_comprobante }}', {{ $venta->subtotal }}, {{ $venta->igv ?? 0 }}, {{ $venta->descuento ?? 0 }}, '{{ $venta->estado }}', '{{ $venta->metodo_pago }}', '{{ addslashes($venta->observaciones ?? '') }}')"
                                    class="text-blue-500 hover:text-blue-400 mr-3 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </button>

                                <!-- Botón Eliminar -->
                                <button onclick="confirmDelete({{ $venta->id }})"
                                    class="text-red-500 hover:text-red-400 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                </button>

                                <!-- Formulario Eliminar (oculto) -->
                                <form id="delete-form-{{ $venta->id }}" action="{{ route('admin.venta.destroy', $venta->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-zinc-400">
                                No hay ventas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL DE EDICIÓN -->
    <div x-show="isOpen" x-cloak @keydown.escape.window="closeModal" class="fixed inset-0 overflow-y-auto" style="z-index: 9999; display:none;">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="closeModal"></div>
            <div class="relative bg-zinc-900 rounded-xl shadow-2xl w-full max-w-2xl border border-zinc-700 p-6" @click.stop>
                <form :action="'/admin/venta/' + currentId" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <label class="block text-sm text-zinc-300">Fecha</label>
                        <input type="datetime-local" x-model="currentFecha" name="fecha" class="w-full px-4 py-2 bg-zinc-800 text-white rounded-lg" required>

                        <label class="block text-sm text-zinc-300">Total</label>
                        <input type="number" x-model="currentTotal" name="total" step="0.01" min="0" class="w-full px-4 py-2 bg-zinc-800 text-white rounded-lg" required>

                        <label class="block text-sm text-zinc-300">Estado</label>
                        <input type="text" x-model="currentEstado" name="estado" class="w-full px-4 py-2 bg-zinc-800 text-white rounded-lg" required>

                        <label class="block text-sm text-zinc-300">Método de Pago</label>
                        <input type="text" x-model="currentMetodoPago" name="metodo_pago" class="w-full px-4 py-2 bg-zinc-800 text-white rounded-lg" required>

                        <label class="block text-sm text-zinc-300">Observaciones</label>
                        <textarea x-model="currentObservaciones" name="observaciones" rows="3" class="w-full px-4 py-2 bg-zinc-800 text-white rounded-lg"></textarea>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="closeModal" class="px-4 py-2 text-sm text-zinc-300 bg-zinc-700 rounded-lg hover:bg-zinc-600">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar venta?',
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

    function ventaTable() {
        return {
            isOpen: false,
            currentId: null,
            currentFecha: '',
            currentTotal: 0,
            currentEstado: '',
            currentMetodoPago: '',
            currentObservaciones: '',

            openModal(id, fecha, total, cliente_id, tipo_comprobante, numero_comprobante, subtotal, igv, descuento, estado, metodo_pago, observaciones) {
                this.currentId = id;
                this.currentFecha = fecha;
                this.currentTotal = total;
                this.currentEstado = estado;
                this.currentMetodoPago = metodo_pago;
                this.currentObservaciones = observaciones;
                this.isOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeModal() {
                this.isOpen = false;
                document.body.classList.remove('overflow-hidden');
            }
        }
    }
</script>
