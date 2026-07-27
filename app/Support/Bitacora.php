<?php

namespace App\Support;

use App\Models\Bitacora as BitacoraModel;

class Bitacora
{
    public static function registrar(string $accion, string $modelo, ?int $modeloId, ?string $descripcion = null): void
    {
        BitacoraModel::create([
            'usuario_id' => auth()->id(),
            'accion' => $accion,
            'modelo' => $modelo,
            'modelo_id' => $modeloId,
            'descripcion' => $descripcion,
        ]);
    }
}
