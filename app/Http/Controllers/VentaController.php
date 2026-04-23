<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para transacciones seguras
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    private const CARGO_ENVIO_DOMICILIO = 200;

    /**
     * Muestra la lista de ventas realizadas.
     */
    public function index(Request $request)
    {
        $codigo = trim((string) $request->query('codigo', ''));

        $ventasQuery = Venta::with('productos')->latest();

        if ($codigo !== '') {
            $codigoNormalizado = ltrim(str_ireplace('VNT-', '', $codigo), '0');
            $codigoNormalizado = $codigoNormalizado === '' ? '0' : $codigoNormalizado;

            $ventasQuery->where('id', (int) $codigoNormalizado);
        }

        $ventas = $ventasQuery->get();

        return view('ventas.index', compact('ventas', 'codigo'));
    }

    /**
     * Muestra el Punto de Venta (POS) para crear una nueva venta.
     */
    public function create()
    {
        // Traemos los clientes y solo los muebles que tengan stock > 0
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::where('cantidad_stock', '>', 0)->get();
        $fechaMinEntrega = now()->addDays(21)->toDateString();
        $tiposEntrega = [
            'entrega' => 'Entrega',
            'flete' => 'Flete / envio a domicilio',
        ];
        $cargoEnvio = self::CARGO_ENVIO_DOMICILIO;

        return view('ventas.create', compact('clientes', 'productos', 'fechaMinEntrega', 'tiposEntrega', 'cargoEnvio'));
    }

    /**
     * Guarda la venta, el detalle y descuenta el inventario (Reglas 1 y 2).
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'tipo_entrega' => 'required|in:entrega,flete',
            'productos' => 'required|array', // Es un arreglo con los IDs de los muebles
            'productos.*' => 'required|exists:productos,id',
            'cantidades' => 'required|array', // Es un arreglo con las cantidades de cada uno
            'cantidades.*' => 'required|integer|min:1',
            'fecha_entrega' => 'required|date|after_or_equal:' . now()->addDays(21)->toDateString(),
            'nombre_entrega' => 'nullable|required_if:tipo_entrega,flete|string|max:255',
            'calle_numero_entrega' => 'nullable|required_if:tipo_entrega,flete|string|max:255',
            'colonia_entrega' => 'nullable|required_if:tipo_entrega,flete|string|max:255',
            'estado_direccion_entrega' => 'nullable|required_if:tipo_entrega,flete|string|max:255',
            'telefono_entrega' => 'nullable|required_if:tipo_entrega,flete|string|max:50',
        ]);

        // DB::transaction asegura que si algo falla a la mitad (ej. no hay stock),
        // se cancele todo y no se guarde una venta a medias.
        try {
            DB::beginTransaction();

            $totalVenta = 0;
            $productosParaPivote = [];

            // 1. Validar Stock y Calcular Total
            foreach ($request->productos as $index => $producto_id) {
                $producto = Producto::findOrFail($producto_id);
                $cantidadSolicitada = $request->cantidades[$index];


                // REGLA 1: Validación de Stock en Ventas
                if ($cantidadSolicitada > $producto->cantidad_stock) {
                    throw new \Exception("No hay suficiente stock para el mueble: " . $producto->nombre);
                }

                $totalVenta += ($producto->precio * $cantidadSolicitada);

                // Preparamos los datos para la tabla pivote (producto_venta)
                $productosParaPivote[$producto_id] = [
                    'cantidad' => $cantidadSolicitada,
                    'precio_unitario' => $producto->precio
                ];

                // REGLA 2: Actualización Automática de Inventario
                $producto->decrement('cantidad_stock', $cantidadSolicitada);
            }

            $cargoEnvio = $request->tipo_entrega === 'flete' ? self::CARGO_ENVIO_DOMICILIO : 0;
            $totalVenta += $cargoEnvio;

            // 2. Crear el Ticket General (La Venta)
            $venta = Venta::create([
                'user_id' => Auth::id(), // El cajero actual
                'cliente_id' => $request->cliente_id,
                'tipo_entrega' => $request->tipo_entrega,
                'fecha_entrega' => $request->fecha_entrega,
                'estado' => 'pendiente',
                'cargo_envio' => $cargoEnvio,
                'nombre_entrega' => $request->tipo_entrega === 'flete' ? $request->nombre_entrega : null,
                'calle_numero_entrega' => $request->tipo_entrega === 'flete' ? $request->calle_numero_entrega : null,
                'colonia_entrega' => $request->tipo_entrega === 'flete' ? $request->colonia_entrega : null,
                'estado_direccion_entrega' => $request->tipo_entrega === 'flete' ? $request->estado_direccion_entrega : null,
                'telefono_entrega' => $request->tipo_entrega === 'flete' ? $request->telefono_entrega : null,
                'total' => $totalVenta
            ]);

            // 3. Guardar el detalle exacto de qué muebles se llevó (La tabla pivote)
            $venta->productos()->attach($productosParaPivote);

            DB::commit(); // Todo salió bien, guardamos definitivamente

            return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito. Total: $' . number_format($totalVenta, 2));

        } catch (\Exception $e) {
            DB::rollBack(); // Hubo un error, cancelamos todo
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // El documento dice que no se pueden editar ni borrar ventas (Regla 6),
    // así que solo habilitaremos el show() para ver el ticket.
    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
    }

    public function actualizarEstado(Request $request, Venta $venta)
    {
        $request->validate([
            'estado' => 'required|in:completada,pendiente,cancelada',
        ]);

        $venta->update([
            'estado' => $request->estado,
        ]);

        return redirect()->route('ventas.index')->with('success', 'Estado de la venta actualizado correctamente.');
    }

    public function exportarExcel()
    {
        // 1. Traemos todas las ventas de la base de datos
        $ventas = \App\Models\Venta::all(); 

        // 2. Le damos un nombre profesional al archivo usando la fecha de hoy
        $nombreArchivo = 'reporte_multimuebles_' . date('Y-m-d') . '.csv';

        // 3. Preparamos las "Cabeceras" para que el navegador sepa que es una descarga
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$nombreArchivo",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // 4. Escribimos los datos en el archivo
        $callback = function() use($ventas) {
            $archivo = fopen('php://output', 'w');
            
            // Le decimos a Excel que use codificación UTF-8 (para que no rompa los acentos)
            fprintf($archivo, chr(0xEF).chr(0xBB).chr(0xBF));

            // Escribimos los títulos de las columnas 
            fputcsv($archivo, ['Folio de venta', 'Fecha de Venta', 'Tipo de Entrega', 'Fecha de Entrega', 'Cargo Envio', 'Estado', 'Total Cobrado']);

            // Recorremos cada venta y la escribimos como una fila de Excel
            foreach ($ventas as $venta) {
                fputcsv($archivo, [
                    str_pad($venta->id, 5, '0', STR_PAD_LEFT),
                    $venta->created_at->format('d/m/Y H:i A'), // Da formato bonito a la fecha
                    $venta->tipo_entrega === 'flete' ? 'Flete / envio a domicilio' : 'Entrega',
                    optional($venta->fecha_entrega)->format('d/m/Y'),
                    '$' . number_format($venta->cargo_envio ?? 0, 2),
                    ucfirst($venta->estado ?? 'pendiente'),
                    '$' . number_format($venta->total, 2) // Asumiendo que tu columna se llama "total"
                ]);
            }
            fclose($archivo);
        };

        // 5. 
        return response()->stream($callback, 200, $headers);
    }
}
