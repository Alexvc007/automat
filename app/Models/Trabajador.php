<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';
    protected $fillable = ['usuario_id', 'especialidad_id', 'ci', 'telefono', 'fecha_contratacion', 'estado'];

    protected function casts(): array
    {
        return ['fecha_contratacion' => 'date'];
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function ordenesServicio()
    {
        return $this->hasMany(OrdenServicio::class, 'trabajador_id');
    }
}
