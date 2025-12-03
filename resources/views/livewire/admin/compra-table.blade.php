<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="compraTable()">

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


    {{-- TABLA --}}
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Lista de Compras</h1>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Fecha</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Usuario</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Proveedor</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Comprobante</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Total</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-800">

                    @forelse ($compras as $compra)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $compra->fecha }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $compra->usuario_id }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $compra->proveedor_id }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">
                                {{ $compra->tipo_comprobante }} - {{ $compra->numero_comprobante }}
                            </td>
                            <td class="px-4 py-4 text-sm text-zinc-300">S/. {{ number_format($compra->total, 2) }}</td>

                            <td class="px-4 py-4 text-sm text-right">

                                {{-- Botón Editar --}}
                                <button 
                                    @click="openModal(
                                        {{ $compra->id }},
                                        '{{ $compra->fecha }}',
                                        '{{ $compra->usuario_id }}',
                                        '{{ $compra->proveedor_id }}',
                                        '{{ $compra->tipo_comprobante }}',
                                        '{{ $compra->numero_comprobante }}',
                                        {{ $compra->subtotal }},
                                        {{ $compra->igv }},
                                        {{ $compra->total }},
                                        '{{ addslashes($compra->estado) }}',
                                        '{{ addslashes($compra->observaciones) }}'
                                    )"
                                    class="text-blue-500 hover:text-blue-400 mr-3 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </button>

                                {{-- Botón Eliminar --}}
                                <button onclick="confirmDelete({{ $compra->id }})"
                                    class="text-red-500 hover:text-red-400 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $compra->id }}"
                                      action="{{ route('admin.compra.destroy', $compra->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-zinc-400">
                                No hay compras registradas
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        @if ($compras->hasPages())
            <div class="mt-6">
                {{ $compras->links() }}
            </div>
        @endif
    </div>


    {{-- MODAL DE EDICIÓN --}}
    <div x-show="isOpen" x-cloak class="fixed inset-0 overflow-y-auto" style="z-index: 9999; display:none;">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">

            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="closeModal"></div>

            <div class="relative bg-zinc-900 rounded-xl shadow-2xl w-full max-w-3xl border border-zinc-700"
                 @click.stop>

                <form :action="'/admin/compra/' + currentId" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-5 border-b border-zinc-700 flex justify-between">
                        <h3 class="text-xl font-semibold text-white">Editar Compra</h3>
                        <button type="button" @click="closeModal" class="text-zinc-400 hover:text-white">
                            ✕
                        </button>
                    </div>

                    <div class="px-6 py-6 grid grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm text-zinc-300 mb-1 block">Fecha *</label>
                            <input type="date" x-model="fecha" name="fecha"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                        </div>

                        <div>
                            <label class="text-sm text-zinc-300 mb-1 block">Usuario *</label>
                            <input type="number" x-model="usuario_id" name="usuario_id"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                        </div>

                        <div>
                            <label class="text-sm text-zinc-300 mb-1 block">Proveedor *</label>
                            <input type="number" x-model="proveedor_id" name="proveedor_id"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                        </div>

                        <div>
                            <label class="text-sm text-zinc-300 mb-1 block">Tipo Comprobante *</label>
                            <input type="text" x-model="tipo_comprobante" name="tipo_comprobante"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                        </div>

                        <div class="col-span-2">
                            <label class="text-sm text-zinc-300 mb-1 block">Número *</label>
                            <input type="text" x-model="numero_comprobante" name="numero_comprobante"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                        </div>

                        <div>
                            <label class="text-sm text-zinc-300 mb-1 block">Subtotal *</label>
                            <input type="number" step="0.01" x-model="subtotal" name="subtotal"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                        </div>

                        <div>
                            <label class="text-sm text-zinc-300 mb-1 block">IGV *</label>
                            <input type="number" step="0.01" x-model="igv" name="igv"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                        </div>

                        <div class="col-span-2">
                            <label class="text-sm text-zinc-300 mb-1 block">Total *</label>
                            <input type="number" step="0.01" x-model="total" name="total"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                        </div>

                        <div class="col-span-2">
                            <label class="text-sm text-zinc-300 mb-1 block">Estado *</label>
                            <select x-model="estado" name="estado"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white">
                                <option value="PENDIENTE">PENDIENTE</option>
                                <option value="PAGADO">PAGADO</option>
                                <option value="ANULADO">ANULADO</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="text-sm text-zinc-300 mb-1 block">Observaciones</label>
                            <textarea rows="3" x-model="observaciones" name="observaciones"
                                class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white"></textarea>
                        </div>

                    </div>

                    <div class="px-6 py-4 bg-zinc-800/50 border-t border-zinc-700 flex justify-end gap-3">
                        <button type="button" @click="closeModal"
                            class="px-5 py-2 bg-zinc-700 text-zinc-300 hover:bg-zinc-600 rounded-lg">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg shadow-lg">
                            Guardar Cambios
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>


<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar compra?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            background: '#18181b',
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((r) => {
            if (r.isConfirmed) document.getElementById('delete-form-' + id).submit();
        });
    }

    function compraTable() {
        return {
            isOpen: false,
            currentId: null,

            fecha: '',
            usuario_id: '',
            proveedor_id: '',
            tipo_comprobante: '',
            numero_comprobante: '',
            subtotal: 0,
            igv: 0,
            total: 0,
            estado: '',
            observaciones: '',

            openModal(id, fecha, usuario, proveedor, tipo, numero, subtotal, igv, total, estado, obs) {
                this.currentId = id;
                this.fecha = fecha;
                this.usuario_id = usuario;
                this.proveedor_id = proveedor;
                this.tipo_comprobante = tipo;
                this.numero_comprobante = numero;
                this.subtotal = subtotal;
                this.igv = igv;
                this.total = total;
                this.estado = estado;
                this.observaciones = obs;
                this.isOpen = true;
            },

            closeModal() {
                this.isOpen = false;
            }
        }
    }
</script>
