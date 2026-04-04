<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Permitir guardar todos los campos que enviemos desde el formulario
    protected $guarded = ['id'];
}