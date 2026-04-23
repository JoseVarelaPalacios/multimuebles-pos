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
        Schema::table('ventas', function (Blueprint $table) {
            $table->decimal('cargo_envio', 10, 2)->default(0)->after('estado');
            $table->string('nombre_entrega')->nullable()->after('cargo_envio');
            $table->string('calle_numero_entrega')->nullable()->after('nombre_entrega');
            $table->string('colonia_entrega')->nullable()->after('calle_numero_entrega');
            $table->string('estado_direccion_entrega')->nullable()->after('colonia_entrega');
            $table->string('telefono_entrega')->nullable()->after('estado_direccion_entrega');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn([
                'cargo_envio',
                'nombre_entrega',
                'calle_numero_entrega',
                'colonia_entrega',
                'estado_direccion_entrega',
                'telefono_entrega',
            ]);
        });
    }
};
