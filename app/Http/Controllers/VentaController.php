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
    /**
     * Muestra la lista de ventas realizadas.
     */
    public function index()
    {
        $ventas = Venta::with('productos')->latest()->get();
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Muestra el Punto de Venta (POS) para crear una nueva venta.
     */
    public function create()
    {
        // Traemos los clientes y solo los muebles que tengan stock > 0
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::where('cantidad_stock', '>', 0)->get();
        
        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Guarda la venta, el detalle y descuenta el inventario (Reglas 1 y 2).
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'productos' => 'required|array', // Es un arreglo con los IDs de los muebles
            'cantidades' => 'required|array', // Es un arreglo con las cantidades de cada uno
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

            // 2. Crear el Ticket General (La Venta)
            $venta = Venta::create([
                'user_id' => Auth::id(), // El cajero actual
                'cliente_id' => $request->cliente_id,
                'total' => $totalVenta
            ]);

            // 3. Guardar el detalle exacto de qué muebles se llevó (La tabla pivote)
            $venta->productos()->attach($productosParaPivote);

            DB::commit(); // Todo salió bien, guardamos definitivamente

            return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito. Total: $' . number_format($totalVenta, 2));

        } catch (\Exception $e) {
            DB::rollBack(); // Hubo un error, cancelamos todo
            return back()->with('error', $e->getMessage());
        }
    }

    // El documento dice que no se pueden editar ni borrar ventas (Regla 6),
    // así que solo habilitaremos el show() para ver el ticket.
    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
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
            fputcsv($archivo, ['Folio de venta', 'Fecha de Venta', 'Total Cobrado']);

            // Recorremos cada venta y la escribimos como una fila de Excel
            foreach ($ventas as $venta) {
                fputcsv($archivo, [
                    str_pad($venta->id, 5, '0', STR_PAD_LEFT),
                    $venta->created_at->format('d/m/Y H:i A'), // Da formato bonito a la fecha
                    '$' . number_format($venta->total, 2) // Asumiendo que tu columna se llama "total"
                ]);
            }
            fclose($archivo);
        };

        // 5. 
        return response()->stream($callback, 200, $headers);
    }
}