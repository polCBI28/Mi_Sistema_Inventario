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
        select:hover {
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
        select:focus {
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
            Registrar Nuevo Cliente
        </h1>

        <form action="{{ route('admin.cliente.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Tipo Documento -->
            <div style="animation: fade-in-up 0.3s ease-out 0.1s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Tipo de Documento <span class="text-red-500">*</span>
                </label>
                <select name="tipo_documento"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg
                        text-white focus:ring-2 focus:ring-blue-500"
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    <option value="">Seleccione…</option>
                    <option value="DNI">DNI</option>
                    <option value="CE">Carnet de Extranjería</option>
                    <option value="PASAPORTE">Pasaporte</option>
                </select>
            </div>

            <!-- Número Documento -->
            <div style="animation: fade-in-up 0.3s ease-out 0.2s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Número de Documento <span class="text-red-500">*</span>
                </label>
                <input type="text" name="numero_documento"
                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg
                       text-white focus:ring-2 focus:ring-blue-500"
                       placeholder="Ej: 12345678"
                       style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
            </div>

            <!-- Nombres -->
            <div style="animation: fade-in-up 0.3s ease-out 0.3s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Nombres <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nombres"
                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg
                       text-white focus:ring-2 focus:ring-blue-500"
                       placeholder="Ej: Juan"
                       style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
            </div>

            <!-- Apellidos -->
            <div style="animation: fade-in-up 0.3s ease-out 0.4s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Apellidos <span class="text-red-500">*</span>
                </label>
                <input type="text" name="apellidos"
                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg
                       text-white focus:ring-2 focus:ring-blue-500"
                       placeholder="Ej: Sánchez"
                       style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
            </div>

            <!-- Email -->
            <div style="animation: fade-in-up 0.3s ease-out 0.5s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Correo
                </label>
                <input type="email" name="email"
                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg 
                       text-white focus:ring-2 focus:ring-blue-500"
                       placeholder="Ej: ejemplo@gmail.com"
                       style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
            </div>

            <!-- Teléfono -->
            <div style="animation: fade-in-up 0.3s ease-out 0.6s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Teléfono
                </label>
                <input type="text" name="telefono"
                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg
                       text-white focus:ring-2 focus:ring-blue-500"
                       placeholder="Ej: 987654321"
                       style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
            </div>

            <!-- Dirección -->
            <div style="animation: fade-in-up 0.3s ease-out 0.7s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Dirección
                </label>
                <input type="text" name="direccion"
                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg
                       text-white focus:ring-2 focus:ring-blue-500"
                       placeholder="Ej: Av. Los Pinos 123"
                       style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
            </div>

            <!-- Fecha Nacimiento -->
            <div style="animation: fade-in-up 0.3s ease-out 0.8s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Fecha de nacimiento
                </label>
                <input type="date" name="fecha_nacimiento"
                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg
                       text-white focus:ring-2 focus:ring-blue-500"
                       style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
            </div>

            <!-- Estado -->
            <div style="animation: fade-in-up 0.3s ease-out 0.9s both;">
                <label class="block text-sm font-medium text-zinc-300 mb-1 field-label">
                    Estado <span class="text-red-500">*</span>
                </label>
                <select name="estado"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg
                        text-white focus:ring-2 focus:ring-blue-500"
                        style="transition: all 0.3s ease; background: rgba(39, 39, 42, 0.5);">
                    <option value="">Seleccione…</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <div class="relative my-8" style="animation: fade-in-up 0.3s ease-out 1s both;">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full divider-gradient"></div>
                </div>
            </div>

            <p class="text-sm text-zinc-500 mb-6" style="animation: fade-in-up 0.3s ease-out 1.1s both; padding: 12px; background: rgba(59, 130, 246, 0.05); border-left: 3px solid #3b82f6; border-radius: 4px;">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </p>

            <div class="flex justify-end" style="animation: fade-in-up 0.3s ease-out 1.2s both;">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 
                    focus:ring-2 focus:ring-blue-500 shadow-lg"
                    style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); position: relative; z-index: 1;">
                    Registrar Cliente
                </button>
            </div>

        </form>
    </div>
</div>