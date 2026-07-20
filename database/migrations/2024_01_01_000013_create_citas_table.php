<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('vehiculo_id')->nullable()->constrained('vehiculos')->nullOnDelete();
            $table->dateTime('fecha_hora');
            $table->string('motivo');
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'atendida'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
