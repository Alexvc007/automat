<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_servicio', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden')->unique();
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->cascadeOnDelete();
            $table->foreignId('trabajador_id')->nullable()->constrained('trabajadores')->nullOnDelete();
            $table->foreignId('creado_por')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->date('fecha_ingreso');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->enum('estado', ['recibido', 'en_proceso', 'terminado', 'entregado'])->default('recibido');
            $table->text('descripcion')->nullable();
            $table->decimal('monto_total', 10, 2)->default(0);
            $table->decimal('monto_pagado', 10, 2)->default(0);
            $table->enum('estado_pago', ['pendiente', 'parcial', 'pagado'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_servicio');
    }
};
