<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
    protected $fillable = ['cliente_id', 'placa', 'marca', 'modelo', 'anio', 'color', 'kilometraje'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ordenesServicio()
    {
        return $this->hasMany(OrdenServicio::class)->orderByDesc('fecha_ingreso');
    }
}
