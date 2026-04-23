<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon; // Para manejar fechas

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Calcular el total vendido HOY
        $ventasHoy = Venta::whereDate('created_at', Carbon::today())->sum('total');
        $cantidadVentasHoy = Venta::whereDate('created_at', Carbon::today())->count();

        // 2. Buscar muebles con poco stock (5 o menos unidades)
        $mueblesPocoStock = Producto::where('cantidad_stock', '<=', 5)
                                    ->orderBy('cantidad_stock', 'asc')
                                    ->get();

        // 3. Pedidos mas proximos a entregar
        $proximasEntregas = Venta::whereNotNull('fecha_entrega')
            ->whereDate('fecha_entrega', '>=', Carbon::today())
            ->where('estado', '!=', 'cancelada')
            ->orderBy('fecha_entrega', 'asc')
            ->limit(5)
            ->get();

        // 4. Mandar los datos a la vista
        return view('dashboard', compact('ventasHoy', 'cantidadVentasHoy', 'mueblesPocoStock', 'proximasEntregas'));
    }
}
