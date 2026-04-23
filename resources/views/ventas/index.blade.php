<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historial de Ventas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Ultimos Tickets Generados</h3>
                        <a href="{{ route('ventas.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            + Nueva Venta
                        </a>
                    </div>

                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('ventas.exportar') }}" class="bg-green-600 hover:bg-green-700 text-black font-bold py-2 px-4 rounded-md shadow-sm transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Descargar en Excel
                        </a>
                    </div>

                    <form action="{{ route('ventas.index') }}" method="GET" class="mb-6">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="flex-1">
                                <label for="codigo" class="block text-sm font-medium text-gray-700">Buscar por codigo de venta</label>
                                <input
                                    id="codigo"
                                    name="codigo"
                                    type="text"
                                    value="{{ $codigo ?? '' }}"
                                    placeholder="Ej. VNT-00012 o 12"
                                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                >
                            </div>
                            <div class="flex items-end gap-3">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 transition">
                                    Buscar
                                </button>
                                @if(!empty($codigo))
                                    <a href="{{ route('ventas.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-md hover:bg-gray-200 transition">
                                        Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha venta</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha entrega</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Articulos</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($ventas as $venta)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            #VNT-{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $venta->created_at->format('d/m/Y h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $venta->tipo_entrega === 'flete' ? 'Flete / envio a domicilio' : 'Entrega' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $venta->fecha_entrega?->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <form action="{{ route('ventas.actualizar-estado', $venta) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="estado" class="border-gray-300 rounded-md shadow-sm text-sm">
                                                    <option value="pendiente" @selected(($venta->estado ?? 'pendiente') === 'pendiente')>Pendiente</option>
                                                    <option value="completada" @selected(($venta->estado ?? 'pendiente') === 'completada')>Completada</option>
                                                    <option value="cancelada" @selected(($venta->estado ?? 'pendiente') === 'cancelada')>Cancelada</option>
                                                </select>
                                                <button type="submit" class="px-3 py-2 text-xs font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition">
                                                    Guardar
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $venta->productos->sum('pivot.cantidad') }} pzas.
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold text-green-600">
                                            <div>${{ number_format($venta->total, 2) }}</div>
                                            @if(($venta->cargo_envio ?? 0) > 0)
                                                <div class="text-xs font-medium text-amber-700">Incluye ${{ number_format($venta->cargo_envio, 2) }} de envio</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('ventas.show', $venta) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Ver Ticket</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Aun no hay ventas registradas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
