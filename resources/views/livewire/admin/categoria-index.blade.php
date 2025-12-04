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

<div class="w-full py-8 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #23448b 0%, #4946cc 100%); min-height: 100vh;">
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
            Registrar Nueva Categoría
        </h1>

        <form action="{{ route('admin.categoria.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Campo Nombre -->
            <div style="animation: fade-in-up 0.3s ease-out 0.1s both;">
                <label for="nombre" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nombre" name="nombre"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white placeholder-zinc-500"
                    placeholder="Ej: Medicamentos, Vitaminas" required
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                @error('nombre')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Descripción -->
            <div style="animation: fade-in-up 0.3s ease-out 0.2s both;">
                <label for="descripcion" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="3"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white placeholder-zinc-500"
                    placeholder="Describe la categoría"
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);"></textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Estado -->
            <div style="animation: fade-in-up 0.3s ease-out 0.3s both;">
                <label for="estado" class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Estado <span class="text-red-500">*</span>
                </label>
                <select id="estado" name="estado"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                    style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
                @error('estado')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-sm text-zinc-500 mb-6" style="animation: fade-in-up 0.3s ease-out 0.4s both; padding: 12px; background: rgba(59, 130, 246, 0.05); border-left: 3px solid #3b82f6; border-radius: 4px;">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <div class="flex justify-end" style="animation: fade-in-up 0.3s ease-out 0.5s both;">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl"
                    style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); position: relative; z-index: 1;">
                    Registrar Categoría
                </button>
            </div>
        </form>
    </div>
</div>