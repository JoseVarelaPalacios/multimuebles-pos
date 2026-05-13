<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <--- IMPORTANTE: Agrega esto para borrar fotos viejas

class ProductoController extends Controller
{
    /**
     * Muestra la tabla con todo el inventario de muebles.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $productos = Producto::when($buscar, function ($query, $buscar) {
            return $query->where('nombre', 'LIKE', "%{$buscar}%")
                         ->orWhere('categoria', 'LIKE', "%{$buscar}%");
        })->paginate(5);

        return view('productos.index', compact('productos', 'buscar'));
    }

    public function create()
    {
        return view('productos.create');
    }

    /**
     * Guarda un nuevo mueble.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'precio'         => 'required|numeric|min:0.1',
            'cantidad_stock' => 'required|integer|min:0',
            'categoria'      => 'required|string|max:255',
            'imagen'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $datos = $request->all();

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($datos);

        return redirect()->route('productos.index')
                        ->with('success', 'El mueble se ha registrado correctamente con su imagen.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualiza un mueble existente incluyendo la gestión de la imagen.
     */
    public function update(Request $request, Producto $producto)
    {
        // 1. VALIDACIÓN (Incluimos la imagen)
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'precio'         => 'required|numeric|min:0.1',
            'cantidad_stock' => 'required|integer|min:0',
            'categoria'      => 'required|string|max:255',
            'descripcion'    => 'nullable|string',
            'material'       => 'nullable|string|max:255',
            'dimensiones'    => 'nullable|string|max:255',
            'color'          => 'nullable|string|max:255',
            'imagen'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.max'   => 'La imagen no debe pesar más de 2MB.',
        ]);

        $datos = $request->all();

        // 2. LÓGICA DE LA IMAGEN
        if ($request->hasFile('imagen')) {
            
            // A. BORRAR IMAGEN ANTERIOR (Opcional pero recomendado para ahorrar espacio)
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            // B. GUARDAR LA NUEVA
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');

        } else {
            // Si el usuario no subió una imagen nueva, quitamos "imagen" del arreglo
            // para que no intente sobreescribir la ruta vieja con un valor nulo.
            unset($datos['imagen']);
        }

        // 3. ACTUALIZAR EN LA BASE DE DATOS
        $producto->update($datos);

        return redirect()->route('productos.index')
                         ->with('success', 'Los datos del mueble y su imagen se han actualizado correctamente.');
    }

    public function show(Producto $producto) {}

    public function destroy(Producto $producto) 
    {
        // Bonus: Si borras un producto, ¡borra también su foto del disco!
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Mueble eliminado del inventario.');
    }
}