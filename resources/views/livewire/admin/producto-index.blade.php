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
            Registrar Producto
        </h1>

        <form action="{{ route('admin.producto.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Categoría -->
            <div style="animation: fade-in-up 0.3s ease-out 0.1s both;">
                <label for="categoria_id" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Categoría <span class="text-red-500">*</span>
                </label>
                <select id="categoria_id" name="categoria_id"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    <option value="">-- Seleccione una categoría --</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Proveedor -->
            <div style="animation: fade-in-up 0.3s ease-out 0.2s both;">
                <label for="proveedor_id" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Proveedor <span class="text-red-500">*</span>
                </label>
                <select id="proveedor_id" name="proveedor_id"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    <option value="">-- Seleccione un proveedor --</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->razon_social }}</option>
                    @endforeach
                </select>
                @error('proveedor_id')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombre -->
            <div style="animation: fade-in-up 0.3s ease-out 0.3s both;">
                <label for="nombre" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Nombre del producto <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nombre" name="nombre"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500"
                    placeholder="Ej: Paracetamol, Vitamina C" value="{{ old('nombre') }}" required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('nombre')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div style="animation: fade-in-up 0.3s ease-out 0.4s both;">
                <label for="descripcion" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="3"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500"
                    placeholder="Describe el producto"
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Código de barra -->
            <div style="animation: fade-in-up 0.3s ease-out 0.5s both;">
                <label for="codigo_barra" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Código de barra
                </label>
                <input type="text" id="codigo_barra" name="codigo_barra"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500"
                    placeholder="Ej: 7501234567890" value="{{ old('codigo_barra') }}"
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('codigo_barra')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Precio de compra -->
            <div style="animation: fade-in-up 0.3s ease-out 0.6s both;">
                <label for="precio_compra" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Precio de compra <span class="text-red-500">*</span>
                </label>
                <input type="number" id="precio_compra" name="precio_compra" step="0.01" min="0"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500"
                    placeholder="Ej: 8.50" value="{{ old('precio_compra') }}" required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('precio_compra')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Precio de venta -->
            <div style="animation: fade-in-up 0.3s ease-out 0.7s both;">
                <label for="precio_venta" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Precio de venta <span class="text-red-500">*</span>
                </label>
                <input type="number" id="precio_venta" name="precio_venta" step="0.01" min="0"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500"
                    placeholder="Ej: 10.50" value="{{ old('precio_venta') }}" required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('precio_venta')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock -->
            <div class="grid grid-cols-2 gap-6" style="animation: fade-in-up 0.3s ease-out 0.8s both;">
                <div>
                    <label for="stock" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                        Stock actual <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock" name="stock" min="0"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500"
                        placeholder="Ej: 100" value="{{ old('stock') }}" required
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock_minimo" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                        Stock mínimo <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock_minimo" name="stock_minimo" min="0"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500"
                        placeholder="Ej: 10" value="{{ old('stock_minimo') }}" required
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    @error('stock_minimo')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Estado -->
            <div style="animation: fade-in-up 0.3s ease-out 0.9s both;">
                <label for="estado" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Estado del producto <span class="text-red-500">*</span>
                </label>
                <select id="estado" name="estado"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500"
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative my-8" style="animation: fade-in-up 0.3s ease-out 1s both;">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full divider-gradient"></div>
                </div>
            </div>

            <div class="text-sm text-zinc-500 mb-6" style="animation: fade-in-up 0.3s ease-out 1.1s both; padding: 12px; background: rgba(59, 130, 246, 0.05); border-left: 3px solid #3b82f6; border-radius: 4px;">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <div class="flex justify-end" style="animation: fade-in-up 0.3s ease-out 1.2s both;">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl"
                    style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); position: relative; z-index: 1;">
                    Registrar Producto
                </button>
            </div>
        </form>
    </div>
</div>