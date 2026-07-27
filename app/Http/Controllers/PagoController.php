<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use App\Models\Pago;
use App\Support\Bitacora;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function store(Request $request, OrdenServicio $ordenServicio)
    {
        $data = $request->validate([
            'monto' => ['required', 'numeric', 'min:0.01'],
            'fecha_pago' => ['required', 'date'],
            'metodo' => ['required', 'in:efectivo,qr,transferencia,tarjeta'],
        ]);

        if ($data['monto'] > $ordenServicio->saldo) {
            return back()->withErrors(['monto' => 'El monto supera el saldo pendiente (Bs. ' . number_format($ordenServicio->saldo, 2) . ').']);
        }

        $ordenServicio->pagos()->create([
            'monto' => $data['monto'],
            'fecha_pago' => $data['fecha_pago'],
            'metodo' => $data['metodo'],
            'registrado_por' => auth()->id(),
        ]);

        $ordenServicio->increment('monto_pagado', $data['monto']);
        $ordenServicio->recalcularTotales();

        Bitacora::registrar('pago', 'OrdenServicio', $ordenServicio->id, "Pago de Bs. {$data['monto']} registrado en orden {$ordenServicio->numero_orden}");

        return back()->with('success', 'Pago registrado correctamente.');
    }

    public function index(Request $request)
    {
        $pagos = Pago::with(['ordenServicio.vehiculo.cliente.usuario', 'registradoPor'])
            ->when($request->from, fn ($q) => $q->whereDate('fecha_pago', '>=', $request->from))
            ->when($request->to, fn ($q) => $q->whereDate('fecha_pago', '<=', $request->to))
            ->orderByDesc('fecha_pago')
            ->paginate(15)
            ->withQueryString();

        return view('pagos.index', compact('pagos'));
    }
}
