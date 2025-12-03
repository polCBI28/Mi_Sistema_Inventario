<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.3s ease-out;
        }

        /* Efecto de brillo en hover para inputs */
        input:hover,
        select:hover,
        textarea:hover {
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.1);
        }

        /* Transición suave para el botón */
        button[type="submit"]:active {
            transform: scale(0.98);
        }

        /* Icono decorativo en labels */
        .field-label::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 16px;
            background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
            border-radius: 2px;
            margin-right: 8px;
            vertical-align: middle;
        }

        /* Gradiente sutil en el borde superior */
        .top-gradient {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
        }

        /* Efecto de resplandor en focus */
        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Animación del botón submit */
        button[type="submit"] {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
        }

        button[type="submit"]::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        button[type="submit"]:hover::before {
            width: 300px;
            height: 300px;
        }

        /* Separador decorativo */
        .divider-gradient {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #3b82f6 50%, transparent 100%);
        }
    </style>
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
    {{-- Alerta de Éxito --}}
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

    {{-- Alerta de Error --}}
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

    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800" style="position: relative; background: linear-gradient(135deg, #18181b 0%, #27272a 100%); backdrop-filter: blur(10px);">
        <div class="top-gradient"></div>
        
        <h1 class="text-2xl font-bold text-white mb-6" style="background: linear-gradient(90deg, #60a5fa 0%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            Registrar Nueva Venta
        </h1>

        <form action="{{ route('admin.venta.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Fecha -->
            <div style="animation: fade-in-up 0.3s ease-out 0.1s both;">
                <label for="fecha" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Fecha <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" id="fecha" name="fecha"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                    required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('fecha')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total -->
            <div style="animation: fade-in-up 0.3s ease-out 0.2s both;">
                <label for="total" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Total <span class="text-red-500">*</span>
                </label>
                <input type="number" id="total" name="total" step="0.01" min="0"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                    required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('total')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Usuario -->
            <div style="animation: fade-in-up 0.3s ease-out 0.3s both;">
                <label for="usuario_id" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Usuario <span class="text-red-500">*</span>
                </label>
                <select id="usuario_id" name="usuario_id"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white" required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    <option value="">Seleccione un usuario</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
                @error('usuario_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cliente -->
            <div style="animation: fade-in-up 0.3s ease-out 0.4s both;">
                <label for="cliente_id" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Cliente
                </label>
                <select id="cliente_id" name="cliente_id"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombres }}</option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de comprobante -->
            <div style="animation: fade-in-up 0.3s ease-out 0.5s both;">
                <label for="tipo_comprobante" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Tipo de Comprobante <span class="text-red-500">*</span>
                </label>
                <input type="text" id="tipo_comprobante" name="tipo_comprobante"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                    required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('tipo_comprobante')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Número de comprobante -->
            <div style="animation: fade-in-up 0.3s ease-out 0.6s both;">
                <label for="numero_comprobante" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Número de Comprobante <span class="text-red-500">*</span>
                </label>
                <input type="text" id="numero_comprobante" name="numero_comprobante"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                    required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('numero_comprobante')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subtotal, IGV, Descuento -->
            <div class="grid grid-cols-3 gap-4" style="animation: fade-in-up 0.3s ease-out 0.7s both;">
                <div>
                    <label for="subtotal" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                        Subtotal <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="subtotal" name="subtotal" step="0.01" min="0"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    @error('subtotal')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="igv" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                        IGV
                    </label>
                    <input type="number" id="igv" name="igv" step="0.01" min="0"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    @error('igv')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="descuento" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                        Descuento
                    </label>
                    <input type="number" id="descuento" name="descuento" step="0.01" min="0"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    @error('descuento')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Estado y Método de Pago -->
            <div class="grid grid-cols-2 gap-4" style="animation: fade-in-up 0.3s ease-out 0.8s both;">
                <div>
                    <label for="estado" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="estado" name="estado"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    @error('estado')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="metodo_pago" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                        Método de Pago <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="metodo_pago" name="metodo_pago"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    @error('metodo_pago')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Observaciones -->
            <div style="animation: fade-in-up 0.3s ease-out 0.9s both;">
                <label for="observaciones" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Observaciones
                </label>
                <textarea id="observaciones" name="observaciones" rows="3"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                    placeholder="Notas adicionales..."
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);"></textarea>
                @error('observaciones')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón de acción principal -->
            <div class="flex justify-end mt-6" style="animation: fade-in-up 0.3s ease-out 1s both;">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 shadow-lg"
                    style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); position: relative; z-index: 1;">
                    Registrar Venta
                </button>
            </div>
        </form>
    </div>
</div>