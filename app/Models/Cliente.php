<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nombre', 'ci_nit', 'telefono', 'correo', 'direccion'];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
