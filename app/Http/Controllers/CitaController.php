<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['cliente.usuario', 'vehiculo'])
            ->orderBy('fecha_hora')
            ->paginate(10);

        return view('citas.index', compact('citas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'vehiculo_id' => ['nullable', 'exists:vehiculos,id'],
            'fecha_hora' => ['required', 'date'],
            'motivo' => ['required', 'string', 'max:255'],
        ]);
        $data['estado'] = 'pendiente';
        Cita::create($data);

        return back()->with('success', 'Cita registrada.');
    }

    public function actualizarEstado(Request $request, Cita $cita)
    {
        $data = $request->validate(['estado' => ['required', 'in:pendiente,confirmada,cancelada,atendida']]);
        $cita->update($data);
        return back()->with('success', 'Estado de la cita actualizado.');
    }
}
