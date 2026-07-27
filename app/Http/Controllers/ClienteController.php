<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use App\Support\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::with('usuario')->withCount('vehiculos')
            ->when($request->search, function ($q) use ($request) {
                $q->where('ci_nit', 'like', "%{$request->search}%")
                  ->orWhere('telefono', 'like', "%{$request->search}%")
                  ->orWhereHas('usuario', fn ($u) => $u->where('nombre', 'like', "%{$request->search}%"));
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'unique:usuarios,correo'],
            'contrasena' => ['required', 'min:6'],
            'ci_nit' => ['required', 'string', 'unique:clientes,ci_nit'],
            'telefono' => ['required', 'string'],
            'direccion' => ['nullable', 'string'],
        ]);

        $usuario = Usuario::create([
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'contrasena' => Hash::make($data['contrasena']),
            'rol' => 'cliente',
            'estado' => 'activo',
        ]);

        $cliente = Cliente::create([
            'usuario_id' => $usuario->id,
            'ci_nit' => $data['ci_nit'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'] ?? null,
        ]);

        Bitacora::registrar('crear', 'Cliente', $cliente->id, "Cliente {$usuario->nombre} registrado con acceso al sistema");

        return redirect()->route('clientes.show', $cliente)->with('success', 'Cliente registrado. Ya puede iniciar sesión con su correo. Ahora agrega su vehículo.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load(['usuario', 'vehiculos.ordenesServicio', 'citas']);
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $cliente->load('usuario');
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'unique:usuarios,correo,' . $cliente->usuario_id],
            'contrasena' => ['nullable', 'min:6'],
            'ci_nit' => ['required', 'string', 'unique:clientes,ci_nit,' . $cliente->id],
            'telefono' => ['required', 'string'],
            'direccion' => ['nullable', 'string'],
        ]);

        $cliente->usuario->update([
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'contrasena' => $data['contrasena'] ? Hash::make($data['contrasena']) : $cliente->usuario->contrasena,
        ]);

        $cliente->update([
            'ci_nit' => $data['ci_nit'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'] ?? null,
        ]);

        Bitacora::registrar('editar', 'Cliente', $cliente->id, "Cliente {$cliente->usuario->nombre} actualizado");

        return redirect()->route('clientes.show', $cliente)->with('success', 'Cliente actualizado.');
    }

    public function toggleEstado(Cliente $cliente)
    {
        $nuevoEstado = $cliente->usuario->estado === 'activo' ? 'inactivo' : 'activo';
        $cliente->usuario->update(['estado' => $nuevoEstado]);

        Bitacora::registrar('cambio_estado', 'Cliente', $cliente->id, "Cliente {$cliente->usuario->nombre} marcado como {$nuevoEstado}");

        return back()->with('success', "Cliente marcado como {$nuevoEstado}.");
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->vehiculos()->exists()) {
            return back()->withErrors(['nombre' => 'No se puede eliminar: el cliente tiene vehículos registrados.']);
        }
        $usuario = $cliente->usuario;
        $cliente->delete();
        $usuario?->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
    }
}
