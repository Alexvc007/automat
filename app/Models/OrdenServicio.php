<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    protected $table = 'ordenes_servicio';

    protected $fillable = [
        'numero_orden', 'vehiculo_id', 'trabajador_id', 'creado_por', 'fecha_ingreso',
        'fecha_entrega_estimada', 'fecha_entrega', 'estado', 'descripcion',
        'monto_total', 'monto_pagado', 'estado_pago',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
            'fecha_entrega_estimada' => 'date',
            'fecha_entrega' => 'date',
        ];
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleOrdenServicio::class, 'orden_servicio_id');
    }

    public function repuestos()
    {
        return $this->hasMany(RepuestoOrden::class, 'orden_servicio_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'orden_servicio_id');
    }

    public function getSaldoAttribute()
    {
        return $this->monto_total - $this->monto_pagado;
    }

    /**
     * Recalcula el total en base a servicios + repuestos, y actualiza el estado de pago.
     */
    public function recalcularTotales(): void
    {
        $totalServicios = $this->detalles()->sum(\DB::raw('cantidad * precio'));
        $totalRepuestos = $this->repuestos()->sum(\DB::raw('cantidad * precio_unitario'));
        $this->monto_total = $totalServicios + $totalRepuestos;

        if ($this->monto_pagado <= 0) {
            $this->estado_pago = 'pendiente';
        } elseif ($this->monto_pagado < $this->monto_total) {
            $this->estado_pago = 'parcial';
        } else {
            $this->estado_pago = 'pagado';
        }

        $this->save();
    }
}
