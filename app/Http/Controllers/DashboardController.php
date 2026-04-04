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

        // 3. Mandar los datos a la vista
        return view('dashboard', compact('ventasHoy', 'cantidadVentasHoy', 'mueblesPocoStock'));
    }
}