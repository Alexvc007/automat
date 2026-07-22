<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = ['nombre', 'telefono', 'correo', 'direccion'];

    public function itemsInventario()
    {
        return $this->hasMany(ItemInventario::class, 'proveedor_id');
    }
}
