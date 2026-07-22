<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrdenServicio extends Model
{
    protected $table = 'detalles_orden_servicio';
    protected $fillable = ['orden_servicio_id', 'catalogo_servicio_id', 'descripcion', 'cantidad', 'precio'];

    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_servicio_id');
    }

    public function servicioCatalogo()
    {
        return $this->belongsTo(CatalogoServicio::class, 'catalogo_servicio_id');
    }
}
