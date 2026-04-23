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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                            {{ $venta->cliente_id ? $venta->cliente->nombre : 'Venta al Publico General' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="rounded-md border border-indigo-100 bg-indigo-50 px-4 py-3">
                        <p class="text-sm text-indigo-700">Tipo de entrega</p>
                        <p class="text-lg font-semibold text-indigo-900">
                            {{ $venta->tipo_entrega === 'flete' ? 'Flete / envio a domicilio' : 'Entrega' }}
                        </p>
                    </div>

                    <div class="rounded-md border border-indigo-100 bg-indigo-50 px-4 py-3">
                        <p class="text-sm text-indigo-700">Fecha de entrega o envio</p>
                        <p class="text-lg font-semibold text-indigo-900">
                            {{ $venta->fecha_entrega?->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="rounded-md border border-indigo-100 bg-indigo-50 px-4 py-3">
                        <p class="text-sm text-indigo-700">Estado</p>
                        <p class="text-lg font-semibold text-indigo-900">
                            {{ ucfirst($venta->estado ?? 'pendiente') }}
                        </p>
                    </div>
                </div>

                @if($venta->tipo_entrega === 'flete')
                    <div class="mb-8 rounded-md border border-amber-200 bg-amber-50 px-4 py-4">
                        <h3 class="text-base font-bold text-amber-900 mb-3">Datos de Entrega a Domicilio</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-amber-700">Nombre</p>
                                <p class="font-medium text-gray-900">{{ $venta->nombre_entrega }}</p>
                            </div>
                            <div>
                                <p class="text-amber-700">Numero de contacto</p>
                                <p class="font-medium text-gray-900">{{ $venta->telefono_entrega }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-amber-700">Direccion</p>
                                <p class="font-medium text-gray-900">{{ $venta->calle_numero_entrega }}</p>
                            </div>
                            <div>
                                <p class="text-amber-700">Colonia</p>
                                <p class="font-medium text-gray-900">{{ $venta->colonia_entrega }}</p>
                            </div>
                            <div>
                                <p class="text-amber-700">Estado</p>
                                <p class="font-medium text-gray-900">{{ $venta->estado_direccion_entrega }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2 uppercase tracking-wide">Articulos Vendidos</h3>
                <table class="w-full mb-8 text-left">
                    <thead>
                        <tr class="text-sm text-gray-500 border-b">
                            <th class="pb-2">Descripcion del Mueble</th>
                            <th class="pb-2 text-center">Cant.</th>
                            <th class="pb-2 text-right">Precio Unit.</th>
                            <th class="pb-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @php($subtotalProductos = 0)
                        @foreach($venta->productos as $producto)
                            @php($subtotal = $producto->pivot->cantidad * $producto->pivot->precio_unitario)
                            @php($subtotalProductos += $subtotal)
                            <tr class="border-b border-dashed border-gray-200">
                                <td class="py-3 text-gray-900 font-medium">{{ $producto->nombre }}</td>
                                <td class="py-3 text-center text-gray-700">{{ $producto->pivot->cantidad }}</td>
                                <td class="py-3 text-right text-gray-700">${{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                <td class="py-3 text-right text-gray-900 font-bold">
                                    ${{ number_format($subtotal, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end">
                    <div class="w-full md:w-1/2 bg-gray-50 p-4 rounded-md border border-gray-200 shadow-inner space-y-3">
                        <div class="flex justify-between items-center text-sm text-gray-700">
                            <span class="font-semibold">Subtotal productos:</span>
                            <span>${{ number_format($subtotalProductos, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm text-gray-700">
                            <span class="font-semibold">Cargo por envio:</span>
                            <span>${{ number_format($venta->cargo_envio ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-lg border-t pt-3">
                            <span class="font-bold text-gray-700">TOTAL:</span>
                            <span class="font-black text-2xl text-green-600">${{ number_format($venta->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 text-center text-sm text-gray-500 italic">
                    <p>Gracias por su preferencia en Multimuebles.</p>
                    <p>Este documento es un comprobante interno y no tiene validez fiscal.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-bold text-sm text-white uppercase tracking-widest hover:bg-gray-700 shadow-md transition ease-in-out duration-150">
                    Imprimir Comprobante
                </button>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

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
