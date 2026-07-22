<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';
    protected $fillable = ['usuario_id', 'accion', 'modelo', 'modelo_id', 'descripcion'];
    public $timestamps = true;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
