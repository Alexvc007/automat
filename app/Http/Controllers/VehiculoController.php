<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Support\Bitacora;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function create(Cliente $cliente)
    {
        return view('vehiculos.create', compact('cliente'));
    }

    public function store(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'placa' => ['required', 'string', 'unique:vehiculos,placa'],
            'marca' => ['required', 'string'],
            'modelo' => ['required', 'string'],
            'anio' => ['nullable', 'string', 'max:4'],
            'color' => ['nullable', 'string'],
            'kilometraje' => ['nullable', 'integer'],
        ]);
        $data['cliente_id'] = $cliente->id;

        $vehiculo = Vehiculo::create($data);
        Bitacora::registrar('crear', 'Vehiculo', $vehiculo->id, "Vehículo placa {$vehiculo->placa} registrado");

        return redirect()->route('clientes.show', $cliente)->with('success', 'Vehículo registrado correctamente.');
    }

    public function edit(Vehiculo $vehiculo)
    {
        return view('vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $data = $request->validate([
            'placa' => ['required', 'string', 'unique:vehiculos,placa,' . $vehiculo->id],
            'marca' => ['required', 'string'],
            'modelo' => ['required', 'string'],
            'anio' => ['nullable', 'string', 'max:4'],
            'color' => ['nullable', 'string'],
            'kilometraje' => ['nullable', 'integer'],
        ]);

        $vehiculo->update($data);
        Bitacora::registrar('editar', 'Vehiculo', $vehiculo->id, "Vehículo placa {$vehiculo->placa} actualizado");

        return redirect()->route('clientes.show', $vehiculo->cliente)->with('success', 'Vehículo actualizado.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $cliente = $vehiculo->cliente;
        if ($vehiculo->ordenesServicio()->exists()) {
            return back()->withErrors(['placa' => 'No se puede eliminar: el vehículo tiene órdenes de servicio.']);
        }
        $vehiculo->delete();
        return redirect()->route('clientes.show', $cliente)->with('success', 'Vehículo eliminado.');
    }

    public function buscar(Request $request)
    {
        $vehiculos = Vehiculo::with('cliente')
            ->where('placa', 'like', "%{$request->q}%")
            ->limit(10)->get();

        return response()->json($vehiculos);
    }
}
