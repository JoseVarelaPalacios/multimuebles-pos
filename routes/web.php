<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// === UN SOLO GRUPO DE SEGURIDAD PARA TODO EL SISTEMA ===
Route::middleware('auth')->group(function () {

    Route::get('/ventas/exportar', [App\Http\Controllers\VentaController::class, 'exportarExcel'])->name('ventas.exportar');
    
    // 1. Módulo de Inventario
    Route::resource('productos', ProductoController::class)->middleware('can:es-admin');
    
    // 2. Módulo de Ventas (Cumpliendo Regla 6: No borrar/editar)
    Route::resource('ventas', VentaController::class)->except(['edit', 'update', 'destroy']);

    // 3. Módulo de Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // 4. Módulo de Usuarios (SOLO ADMIN)
    Route::middleware('can:es-admin')->group(function () {
        Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [App\Http\Controllers\UserController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{usuario}', [App\Http\Controllers\UserController::class, 'update'])->name('usuarios.update');
    });

    

});


require __DIR__.'/auth.php';

