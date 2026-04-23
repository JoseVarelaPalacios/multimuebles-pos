<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Control - Multimuebles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">¡Hola, {{ Auth::user()->nombre ?? 'Administrador' }}! 👋</h3>
                <p class="text-gray-600">Aquí tienes el resumen de tu negocio el día de hoy.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500 p-6 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Ventas de Hoy</p>
                        <p class="text-3xl font-black text-gray-900">${{ number_format($ventasHoy, 2) }}</p>
                        <p class="text-sm text-green-600 font-bold mt-1">{{ $cantidadVentasHoy }} tickets generados</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500 p-6 flex items-center hover:bg-gray-50 transition cursor-pointer" onclick="window.location.href='{{ route('ventas.create') }}'">
                    <div class="p-3 rounded-full bg-indigo-100 mr-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Punto de Venta</p>
                        <p class="text-2xl font-black text-indigo-600">Abrir POS</p>
                        <p class="text-sm text-indigo-600 font-bold mt-1">Registrar una nueva venta</p>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-amber-100 bg-amber-50 flex items-center">
                        <svg class="w-6 h-6 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"></path></svg>
                        <h3 class="text-lg font-bold text-amber-800">Pedidos Proximos a Entregar</h3>
                    </div>
                    <div class="p-6">
                        @if($proximasEntregas->isEmpty())
                            <p class="text-sm text-green-600 font-medium">No hay pedidos proximos pendientes de entrega.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($proximasEntregas as $venta)
                                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">Ticket #VNT-{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</p>
                                                <p class="text-sm text-gray-500">{{ $venta->tipo_entrega === 'flete' ? 'Flete / envio a domicilio' : 'Entrega' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Entrega</p>
                                                <p class="text-sm font-semibold text-amber-700">{{ $venta->fecha_entrega?->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-red-50 flex items-center">
                    <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <h3 class="text-lg font-bold text-red-800">Alertas de Inventario (Poco Stock)</h3>
                </div>
                <div class="p-6">
                    @if($mueblesPocoStock->isEmpty())
                        <p class="text-green-600 font-medium text-center">¡Todo excelente! No hay muebles con bajo stock en este momento.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mueble</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Actual</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($mueblesPocoStock as $mueble)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $mueble->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mueble->categoria }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($mueble->cantidad_stock == 0)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Agotado</span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Quedan {{ $mueble->cantidad_stock }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
