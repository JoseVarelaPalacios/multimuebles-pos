<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relación: Una venta tiene muchos productos (a través de la tabla pivote)
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_venta')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
