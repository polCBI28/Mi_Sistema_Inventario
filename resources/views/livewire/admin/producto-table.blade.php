<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="productoTable()">
    {{-- ✅ Mensajes de Éxito --}}
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

    {{-- ❌ Mensajes de Error --}}
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

    {{-- 📦 Tabla de Productos --}}
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Lista de Productos</h1>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Nombre</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Descripción</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Precio Venta</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Stock</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @forelse ($productos as $producto)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $producto->nombre }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">
                                {{ $producto->descripcion ? Str::limit($producto->descripcion, 50) : 'Sin descripción' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-zinc-300">S/. {{ number_format($producto->precio_venta, 2) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $producto->stock }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                {{-- ✏️ Botón Editar --}}
                                <button
                                    @click="openModal({{ $producto->id }}, '{{ addslashes($producto->nombre) }}', '{{ addslashes($producto->descripcion ?? '') }}', {{ $producto->precio_venta }}, {{ $producto->stock }})"
                                    class="text-blue-500 hover:text-blue-400 mr-3 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>

                                {{-- 🗑️ Botón Eliminar --}}
                                <button onclick="confirmDelete({{ $producto->id }})"
                                    class="text-red-500 hover:text-red-400 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $producto->id }}"
                                    action="{{ route('admin.producto.destroy', $producto->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-zinc-400">
                                No hay productos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 🔁 Paginación --}}
        @if ($productos->hasPages())
            <div class="mt-6">
                {{ $productos->links() }}
            </div>
        @endif
    </div>

    {{-- ✏️ Modal de Edición --}}
    <div x-show="isOpen" x-cloak @keydown.escape.window="closeModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 overflow-y-auto"
         style="z-index: 9999; display: none;">

        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" aria-hidden="true" @click="closeModal"></div>

            <div class="relative bg-zinc-900 rounded-xl shadow-2xl w-full max-w-2xl border border-zinc-700"
                @click.stop>
                <form :action="'/admin/producto/' + currentId" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-5 border-b border-zinc-700 flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-white">Editar Producto</h3>
                        <button type="button" @click="closeModal" class="text-zinc-400 hover:text-white">
                            ✕
                        </button>
                    </div>

                    <div class="px-6 py-6 space-y-5">
                        <div>
                            <label class="text-zinc-300">Nombre</label>
                            <input type="text" x-model="currentNombre" name="nombre"
                                class="w-full bg-zinc-800 border border-zinc-600 rounded-lg text-white p-3" required>
                        </div>

                        <div>
                            <label class="text-zinc-300">Descripción</label>
                            <textarea x-model="currentDescripcion" name="descripcion" rows="3"
                                class="w-full bg-zinc-800 border border-zinc-600 rounded-lg text-white p-3"></textarea>
                        </div>

                        <div>
                            <label class="text-zinc-300">Precio Venta</label>
                            <input type="number" x-model="currentPrecioVenta" name="precio_venta" step="0.01"
                                min="0"
                                class="w-full bg-zinc-800 border border-zinc-600 rounded-lg text-white p-3" required>
                        </div>

                        <div>
                            <label class="text-zinc-300">Stock</label>
                            <input type="number" x-model="currentStock" name="stock" min="0"
                                class="w-full bg-zinc-800 border border-zinc-600 rounded-lg text-white p-3" required>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-zinc-800/50 border-t border-zinc-700 flex justify-end gap-3">
                        <button type="button" @click="closeModal"
                            class="px-5 py-2.5 bg-zinc-700 text-zinc-300 rounded-lg hover:bg-zinc-600">Cancelar</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar producto?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            background: '#18181b',
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function productoTable() {
        return {
            isOpen: false,
            currentId: null,
            currentNombre: '',
            currentDescripcion: '',
            currentPrecioVenta: 0,
            currentStock: 0,

            openModal(id, nombre, descripcion, precio_venta, stock) {
                this.currentId = id;
                this.currentNombre = nombre;
                this.currentDescripcion = descripcion;
                this.currentPrecioVenta = precio_venta;
                this.currentStock = stock;
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
