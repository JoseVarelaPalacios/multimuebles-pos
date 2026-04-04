<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    // NUEVA FUNCIÓN: Para crear empleados desde el panel
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:4', // Contraseña mínima de 4 letras/números
            'rol' => 'required|in:admin,cajero,vendedor' 
        ]);

        User::create([
            'nombre' => $request->nombre,
            'username' => $request->username,
            'password' => bcrypt($request->password), // Encriptamos la contraseña por seguridad
            'rol' => $request->rol,
        ]);

        return back()->with('success', '¡Nuevo empleado registrado correctamente!');
    }

    public function update(Request $request, User $usuario)
    {
        // Agregamos 'vendedor' a la validación por si tu base de datos lo prefiere
        $request->validate([
            'rol' => 'required|in:admin,cajero,vendedor'
        ]);

        if ($usuario->id === 1 && $request->rol !== 'admin') {
            return back()->with('error', 'No puedes quitarle el rol de Administrador al creador del sistema.');
        }

        $usuario->rol = $request->rol;
        $usuario->save();

        return back()->with('success', 'Rol actualizado correctamente.');
    }
}