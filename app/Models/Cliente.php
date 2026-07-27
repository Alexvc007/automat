<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['usuario_id', 'ci_nit', 'telefono', 'direccion'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
