<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nombre' => 'José Varela',
            'username' => 'admin',
            'password' => bcrypt('12345678'), // Laravel encriptará la contraseña
            'rol' => 'Administrador',
        ]);
    }
}
