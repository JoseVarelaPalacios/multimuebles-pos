<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administración de Usuarios y Empleados
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold mb-4 text-indigo-700">Registrar Nuevo Empleado</h3>
                    
                    <form action="{{ route('usuarios.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-1">
                            <x-input-label value="Nombre Completo" />
                            <x-text-input name="nombre" type="text" class="mt-1 block w-full" required placeholder="Ej. Juan Pérez" />
                        </div>
                        <div class="md:col-span-1">
                            <x-input-label value="Usuario de Ingreso" />
                            <x-text-input name="username" type="text" class="mt-1 block w-full" required placeholder="Ej. juan_ventas" />
                        </div>
                        <div class="md:col-span-1">
                            <x-input-label value="Contraseña Temporal" />
                            <x-text-input name="password" type="password" class="mt-1 block w-full" required placeholder="****" />
                        </div>
                        <div class="md:col-span-1">
                            <x-input-label value="Asignar Rol" />
                            <select name="rol" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="vendedor">Vendedor / Cajero</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700">
                                + Crear Cuenta
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Plantilla de Personal</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol Actual</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cambiar Rol</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $usuario->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $usuario->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $usuario->rol === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                            {{ strtoupper($usuario->rol ?? 'VENDEDOR') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PUT')
                                            <select name="rol" class="text-sm border-gray-300 rounded-md shadow-sm mr-2">
                                                <option value="vendedor" {{ $usuario->rol === 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                                                <option value="admin" {{ $usuario->rol === 'admin' ? 'selected' : '' }}>Administrador</option>
                                            </select>
                                            <button type="submit" class="text-white bg-gray-800 hover:bg-gray-700 px-3 py-1 rounded-md text-xs font-bold transition">
                                                Guardar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>