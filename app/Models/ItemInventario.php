<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemInventario extends Model
{
    protected $table = 'items_inventario';
    protected $fillable = ['nombre', 'categoria', 'unidad', 'stock', 'stock_minimo', 'precio_unitario', 'proveedor_id'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function repuestosOrden()
    {
        return $this->hasMany(RepuestoOrden::class, 'item_inventario_id');
    }

    public function getStockBajoAttribute(): bool
    {
        return $this->stock <= $this->stock_minimo;
    }
}
