<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // === NUESTRO GUARDIA DE SEGURIDAD MEJORADO ===
        Gate::define('es-admin', function ($user) {
            // El usuario con el ID 1 (Tú) siempre es Admin, o cualquiera que tenga el rol 'admin'
            return $user->id === 1 || $user->rol === 'admin';
        });
    }
}
