<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles_orden_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicio')->cascadeOnDelete();
            $table->foreignId('catalogo_servicio_id')->nullable()->constrained('catalogo_servicios')->nullOnDelete();
            $table->string('descripcion');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles_orden_servicio');
    }
};
