<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra la tabla con todo el inventario de muebles.
     */
    public function index(Request $request)
    {
        // 1. Recibimos la palabra que el usuario escribió en el buscador
        $buscar = $request->input('buscar');

        // 2. Buscamos en la base de datos (con o sin filtro) y PAGINAMOS de 5 en 5
        $productos = Producto::when($buscar, function ($query, $buscar) {
            return $query->where('nombre', 'LIKE', "%{$buscar}%")
                         ->orWhere('categoria', 'LIKE', "%{$buscar}%");
        })->paginate(5); // <-- Aquí le decimos que solo traiga 5 por página

        // 3. Mandamos los datos a la pantalla
        return view('productos.index', compact('productos', 'buscar'));
    }

    /**
     * Muestra el formulario vacío para agregar un nuevo mueble.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Recibe los datos del formulario, los valida y los guarda en la Base de Datos.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN (Cumpliendo la Regla 4 de tus requisitos)
        $request->validate([
            // Obligatorios
            'nombre'         => 'required|string|max:255',
            'precio'         => 'required|numeric|min:0.1',
            'cantidad_stock' => 'required|integer|min:0',
            'categoria'      => 'required|string|max:255',
            
            // Opcionales (Características de los muebles)
            'descripcion'    => 'nullable|string',
            'material'       => 'nullable|string|max:255',
            'dimensiones'    => 'nullable|string|max:255',
            'color'          => 'nullable|string|max:255',
        ], [
            // Mensajes en español si el usuario se equivoca
            'nombre.required' => 'El nombre del mueble es obligatorio.',
            'precio.required' => 'Debes asignar un precio válido.',
            'cantidad_stock.required' => 'Ingresa la cantidad en stock (puede ser 0).',
            'categoria.required' => 'Selecciona una categoría para el mueble.',
        ]);

        // 2. GUARDAR EN BASE DE DATOS
        Producto::create($request->all());

        // 3. REDIRIGIR A LA LISTA CON MENSAJE DE ÉXITO
        return redirect()->route('productos.index')
                         ->with('success', 'El mueble se ha registrado correctamente en el inventario.');
    }

    // Dejamos las demás funciones vacías por ahora (las usaremos más adelante para Editar y Eliminar)
    public function show(Producto $producto) {}

    public function edit(Producto $producto) {
        // Pasamos el mueble específico a la vista
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto) {
        // 1. Validamos (usamos la misma lógica que en store)
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'precio'         => 'required|numeric|min:0.1',
            'cantidad_stock' => 'required|integer|min:0',
            'categoria'      => 'required|string|max:255',
            'descripcion'    => 'nullable|string',
            'material'       => 'nullable|string|max:255',
            'dimensiones'    => 'nullable|string|max:255',
            'color'          => 'nullable|string|max:255',
        ]);

        // 2. Actualizamos el registro
        $producto->update($request->all());

        // 3. Redirigimos con mensaje de éxito
        return redirect()->route('productos.index')
                         ->with('success', 'Los datos del mueble se han actualizado.');
    }
    public function destroy(Producto $producto) {}
}