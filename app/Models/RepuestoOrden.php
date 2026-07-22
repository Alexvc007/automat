<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepuestoOrden extends Model
{
    protected $table = 'repuestos_orden';
    protected $fillable = ['orden_servicio_id', 'item_inventario_id', 'cantidad', 'precio_unitario'];

    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_servicio_id');
    }

    public function item()
    {
        return $this->belongsTo(ItemInventario::class, 'item_inventario_id');
    }
}
