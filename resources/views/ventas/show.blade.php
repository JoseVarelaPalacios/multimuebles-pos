<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de Venta
            </h2>
            <a href="{{ route('ventas.index') }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
                &larr; Volver al Historial
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div id="seccion-ticket" class="bg-white shadow-lg sm:rounded-lg p-8 border-t-8 border-indigo-600">
                
                <div class="flex justify-between items-start border-b pb-6 mb-6">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-800 tracking-wider mb-1">
                            Multi<span class="text-indigo-600">muebles</span>
                        </h1>
                        <p class="text-sm text-gray-500">Comprobante de Pago</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Folio de Venta:</p>
                        <p class="text-2xl font-bold text-gray-900">#VNT-{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-sm text-gray-500 mt-2">Fecha y Hora:</p>
                        <p class="text-sm font-medium text-gray-900">{{ $venta->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div>
                        <p class="text-sm text-gray-500">Atendido por:</p>
                        <p class="text-base font-medium text-gray-900">{{ Auth::user()->nombre ?? 'Administrador' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Cliente:</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $venta->cliente_id ? $venta->cliente->nombre : 'Venta al Público General' }}
                        </p>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2 uppercase tracking-wide">Artículos Vendidos</h3>
                <table class="w-full mb-8 text-left">
                    <thead>
                        <tr class="text-sm text-gray-500 border-b">
                            <th class="pb-2">Descripción del Mueble</th>
                            <th class="pb-2 text-center">Cant.</th>
                            <th class="pb-2 text-right">Precio Unit.</th>
                            <th class="pb-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($venta->productos as $producto)
                            <tr class="border-b border-dashed border-gray-200">
                                <td class="py-3 text-gray-900 font-medium">{{ $producto->nombre }}</td>
                                <td class="py-3 text-center text-gray-700">{{ $producto->pivot->cantidad }}</td>
                                <td class="py-3 text-right text-gray-700">${{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                <td class="py-3 text-right text-gray-900 font-bold">
                                    ${{ number_format($producto->pivot->cantidad * $producto->pivot->precio_unitario, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end">
                    <div class="w-1/2 bg-gray-50 p-4 rounded-md border border-gray-200 shadow-inner">
                        <div class="flex justify-between items-center text-lg">
                            <span class="font-bold text-gray-700">TOTAL:</span>
                            <span class="font-black text-2xl text-green-600">${{ number_format($venta->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 text-center text-sm text-gray-500 italic">
                    <p>¡Gracias por su preferencia en Multimuebles!</p>
                    <p>Este documento es un comprobante interno y no tiene validez fiscal.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-bold text-sm text-white uppercase tracking-widest hover:bg-gray-700 shadow-md transition ease-in-out duration-150">
                    🖨️ Imprimir Comprobante
                </button>
            </div>

        </div>
    </div>

    <style>
        @media print {
            /* Ocultamos el menú lateral/superior y el fondo gris */
            body * {
                visibility: hidden;
            }
            /* Solo hacemos visible el contenedor del ticket */
            #seccion-ticket, #seccion-ticket * {
                visibility: visible;
            }
            #seccion-ticket {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</x-app-layout>