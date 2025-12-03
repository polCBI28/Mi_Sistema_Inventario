<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="detalleCompraTable()">

    {{-- ALERTA ÉXITO --}}
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

    {{-- ALERTA ERROR --}}
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


    <!-- TABLA PRINCIPAL -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">
                Lista de Detalles de Compra
            </h1>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Compra</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Producto</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Cantidad</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Precio Unit.</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Subtotal</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-800">
                    @forelse ($detalles as $detalle)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>

                            <td class="px-4 py-4 text-sm text-zinc-300">
                                Compra #{{ $detalle->compra_id }}
                            </td>

                            <td class="px-4 py-4 text-sm text-zinc-300">
                                {{ $detalle->producto->nombre ?? 'Sin nombre' }}
                            </td>

                            <td class="px-4 py-4 text-sm text-zinc-300">
                                {{ $detalle->cantidad }}
                            </td>

                            <td class="px-4 py-4 text-sm text-zinc-300">
                                S/. {{ number_format($detalle->precio_unitario, 2) }}
                            </td>

                            <td class="px-4 py-4 text-sm text-zinc-300 font-semibold">
                                S/. {{ number_format($detalle->subtotal, 2) }}
                            </td>

                            <td class="px-4 py-4 text-sm text-right">

                                <!-- BOTÓN EDITAR -->
                                <button
                                    @click="openModal(
                                        {{ $detalle->id }},
                                        {{ $detalle->producto_id }},
                                        {{ $detalle->cantidad }},
                                        {{ $detalle->precio_unitario }}
                                    )"
                                    class="text-blue-500 hover:text-blue-400 mr-3 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <button onclick="confirmDelete({{ $detalle->id }})"
                                    class="text-red-500 hover:text-red-400 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $detalle->id }}"
                                    action="{{ route('admin.detallecompra.destroy', $detalle->id) }}"
                                    method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-zinc-400">
                                No hay detalles registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        @if ($detalles->hasPages())
            <div class="mt-6">
                {{ $detalles->links() }}
            </div>
        @endif

    </div>



    <!-- ============== MODAL EDITAR ============== -->
    <div x-show="isOpen" x-cloak
        @keydown.escape.window="closeModal"
        class="fixed inset-0 overflow-y-auto"
        style="z-index: 9999; display: none;">

        <div class="flex items-center justify-center min-h-screen px-4 py-6">

            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm"
                @click="closeModal"
                style="z-index: 9998;"></div>

            <div class="relative bg-zinc-900 rounded-xl shadow-2xl w-full max-w-xl border border-zinc-700"
                style="z-index: 9999;" @click.stop>

                <form :action="'/admin/detallecompra/' + currentId" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-5 border-b border-zinc-700">
                        <h3 class="text-xl font-semibold text-white">Editar Detalle</h3>
                    </div>

                    <div class="px-6 py-6 space-y-5">

                        <!-- PRODUCTO -->
                        <div>
                            <label class="text-sm text-zinc-300">Producto</label>
                            <select name="producto_id" x-model="producto"
                                class="w-full px-4 py-3 bg-zinc-800 border border-zinc-600 text-white rounded-lg">
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- CANTIDAD -->
                        <div>
                            <label class="text-sm text-zinc-300">Cantidad</label>
                            <input type="number" min="1" x-model="cantidad" name="cantidad"
                                class="w-full px-4 py-3 bg-zinc-800 border border-zinc-600 text-white rounded-lg">
                        </div>

                        <!-- PRECIO -->
                        <div>
                            <label class="text-sm text-zinc-300">Precio Unitario</label>
                            <input type="number" step="0.01" min="0" x-model="precio" name="precio_unitario"
                                class="w-full px-4 py-3 bg-zinc-800 border border-zinc-600 text-white rounded-lg">
                        </div>

                    </div>

                    <div class="px-6 py-4 bg-zinc-800/50 border-t border-zinc-700 flex justify-end gap-3">
                        <button type="button" @click="closeModal"
                            class="px-5 py-2 bg-zinc-700 text-zinc-300 rounded-lg">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg">
                            Guardar Cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>




<script>
    // SWEETALERT ELIMINAR
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar detalle?',
            icon: 'warning',
            background: '#18181b',
            color: '#f4f4f5',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((res) => {
            if (res.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }


    // COMPONENTE ALPINE
    function detalleCompraTable() {
        return {
            isOpen: false,
            currentId: null,
            producto: null,
            cantidad: 1,
            precio: 0,

            openModal(id, producto, cantidad, precio) {
                this.currentId = id;
                this.producto = producto;
                this.cantidad = cantidad;
                this.precio = precio;
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
