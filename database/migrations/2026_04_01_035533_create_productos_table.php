<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); 
            $table->text('descripcion')->nullable(); 
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad_stock')->default(0); 
            $table->string('categoria');  // Ej: Sala, Comedor, Recámara [cite: 94]
            
            // Características del dominio mueblero 
            $table->string('material')->nullable(); 
            $table->string('dimensiones')->nullable(); 
            $table->string('color')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
