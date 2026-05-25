<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- 1. Importamos la herramienta

class Producto extends Model
{
    use HasFactory, SoftDeletes; // <-- 2. Activamos el superpoder aquí

    // Permitir guardar todos los campos que enviemos desde el formulario
    protected $guarded = ['id'];
}