<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class PortalClienteController extends Controller
{
    /**
     * Módulo 1 del cliente: ver el estado de su(s) vehículo(s) y las órdenes de
     * servicio asociadas. Es de solo lectura, el cliente no edita nada aquí.
     */
    public function estadoVehiculo()
    {
        $cliente = auth()->user()->cliente;
        $cliente?->load(['vehiculos.ordenesServicio.trabajador.usuario']);

        return view('portal.vehiculo', compact('cliente'));
    }

    /**
     * Módulo 2 del cliente: ver sus citas y reservar una nueva.
     */
    public function citas()
    {
        $cliente = auth()->user()->cliente;
        $citas = $cliente ? $cliente->citas()->orderByDesc('fecha_hora')->get() : collect();
        $vehiculos = $cliente ? $cliente->vehiculos : collect();

        return view('portal.citas', compact('citas', 'vehiculos'));
    }

    public function guardarCita(Request $request)
    {
        $cliente = auth()->user()->cliente;

        if (!$cliente) {
            return back()->withErrors(['motivo' => 'Tu cuenta no tiene un perfil de cliente asociado.']);
        }

        $data = $request->validate([
            'vehiculo_id' => ['nullable', 'exists:vehiculos,id'],
            'fecha_hora' => ['required', 'date', 'after:now'],
            'motivo' => ['required', 'string', 'max:255'],
        ]);

        // Aseguramos que el vehículo elegido sea realmente del cliente autenticado.
        if ($data['vehiculo_id'] && !$cliente->vehiculos->contains('id', $data['vehiculo_id'])) {
            return back()->withErrors(['vehiculo_id' => 'Ese vehículo no pertenece a tu cuenta.']);
        }

        Cita::create([
            'cliente_id' => $cliente->id,
            'vehiculo_id' => $data['vehiculo_id'] ?? null,
            'fecha_hora' => $data['fecha_hora'],
            'motivo' => $data['motivo'],
            'estado' => 'pendiente',
        ]);

        return back()->with('success', 'Tu cita fue registrada. El taller la confirmará pronto.');
    }
}
