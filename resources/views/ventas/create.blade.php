<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Nueva Venta
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('ventas.store') }}" method="POST" id="form-venta">
                        @csrf

                        <div class="mb-6 border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Cliente</h3>
                            <div>
                                <x-input-label for="cliente_id" value="Cliente (Opcional)" />
                                <select id="cliente_id" name="cliente_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Venta al Público General --</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Muebles a Vender</h3>
                                <button type="button" id="btn-agregar-fila" class="px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-md hover:bg-blue-200 transition">
                                    + Agregar otro mueble
                                </button>
                            </div>
                            
                            <div id="productos-container">
                                <div class="producto-row grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center bg-gray-50 p-4 rounded-md border">
                                    <div class="md:col-span-8">
                                        <x-input-label value="Seleccionar Mueble" />
                                        <select name="productos[]" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                            <option value="" disabled selected>Elige un mueble en stock...</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}">
                                                    {{ $producto->nombre }} (Stock: {{ $producto->cantidad_stock }}) - ${{ number_format($producto->precio, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <x-input-label value="Cantidad" />
                                        <input type="number" name="cantidades[]" min="1" value="1" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                    <div class="md:col-span-1 text-center md:text-right mt-4 md:mt-0 flex justify-end items-end h-full">
                                        <button type="button" class="btn-eliminar text-red-600 hover:text-red-800 font-bold bg-red-100 hover:bg-red-200 rounded px-3 py-2 transition" title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <x-primary-button class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 text-lg">
                                Cobrar Venta
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('productos-container');
            const btnAgregar = document.getElementById('btn-agregar-fila');

            // 1. Clonar las opciones de muebles directamente desde PHP a una variable de JS
            const opcionesMuebles = `
                <option value="" disabled selected>Elige un mueble en stock...</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">
                        {{ $producto->nombre }} (Stock: {{ $producto->cantidad_stock }}) - ${{ number_format($producto->precio, 2) }}
                    </option>
                @endforeach
            `;

            // 2. Evento para agregar una nueva fila
            btnAgregar.addEventListener('click', function() {
                const nuevaFila = document.createElement('div');
                nuevaFila.className = 'producto-row grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center bg-gray-50 p-4 rounded-md border';
                
                nuevaFila.innerHTML = `
                    <div class="md:col-span-8">
                        <label class="block font-medium text-sm text-gray-700">Seleccionar Mueble</label>
                        <select name="productos[]" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            ${opcionesMuebles}
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block font-medium text-sm text-gray-700">Cantidad</label>
                        <input type="number" name="cantidades[]" min="1" value="1" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="md:col-span-1 text-center md:text-right mt-4 md:mt-0 flex justify-end items-end h-full">
                        <button type="button" class="btn-eliminar text-red-600 hover:text-red-800 font-bold bg-red-100 hover:bg-red-200 rounded px-3 py-2 transition" title="Eliminar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                `;
                
                container.appendChild(nuevaFila);
            });

            // 3. Evento para eliminar filas (Delegación de eventos para elementos creados dinámicamente)
            container.addEventListener('click', function(e) {
                const btnEliminar = e.target.closest('.btn-eliminar');
                if (btnEliminar) {
                    if (container.querySelectorAll('.producto-row').length > 1) {
                        btnEliminar.closest('.producto-row').remove();
                    } else {
                        alert('El ticket debe tener al menos un mueble para poder cobrar.');
                    }
                }
            });
        });
    </script>
</x-app-layout>