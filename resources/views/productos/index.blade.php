<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inventario de Muebles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Catálogo Actual</h3>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('reportes.inventario') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                📄 Generar PDF
                            </a>

                            <a href="{{ route('productos.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                + Añadir Mueble
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">

                        <div class="mb-6 flex justify-between items-center bg-gray-50 p-4 rounded-md border border-gray-200">
                            <form action="{{ route('productos.index') }}" method="GET" class="flex w-full md:w-1/2">
                                <x-text-input type="text" name="buscar" value="{{ $buscar }}" placeholder="Buscar por nombre o categoría..." class="w-full rounded-r-none" />
                                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-700 font-bold transition">
                                    Buscar
                                </button>
                                @if($buscar)
                                    <a href="{{ route('productos.index') }}" class="ml-3 text-red-500 hover:text-red-700 font-bold py-2">
                                        Limpiar
                                    </a>
                                @endif
                            </form>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($productos as $producto)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    @if($producto->imagen)
                                                        <img class="h-12 w-12 rounded-md object-cover shadow-sm border border-gray-200" src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                                                    @else
                                                        <div class="h-12 w-12 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 text-[10px] shadow-sm border border-gray-200 text-center leading-tight">
                                                            Sin<br>Foto
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $producto->nombre }}</div>
                                                    <div class="text-xs text-gray-500">{{ $producto->color }} {{ $producto->dimensiones ? '- ' . $producto->dimensiones : '' }}</div>
                                                    <div class="text-xs text-gray-400 mt-1 max-w-[200px] truncate" title="{{ $producto->descripcion }}">
                                                        {{ $producto->descripcion ?? 'Sin descripción registrada' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                                {{ $producto->material ?? 'No especificado' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $producto->categoria }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($producto->cantidad_stock <= 0)
                                                <span class="text-red-600 font-bold">Agotado</span>
                                            @else
                                                {{ $producto->cantidad_stock }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                            ${{ number_format($producto->precio, 2) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('productos.edit', $producto) }}" class="text-indigo-600 hover:text-indigo-900 font-bold transition">
                                                    Editar
                                                </a>

                                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este mueble del inventario? \n\n¡Esta acción borrará la foto y los datos para siempre!');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold transition">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Aún no hay muebles registrados en el inventario.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-6">
                            {{ $productos->withQueryString()->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>