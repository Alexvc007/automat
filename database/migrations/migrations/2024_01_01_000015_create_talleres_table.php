<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla independiente: directorio de talleres de la ciudad para el buscador con mapa.
     */
    public function up(): void
    {
        Schema::create('talleres', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion');
            $table->string('ciudad')->default('Santa Cruz de la Sierra');
            $table->string('telefono')->nullable();
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talleres');
    }
};
