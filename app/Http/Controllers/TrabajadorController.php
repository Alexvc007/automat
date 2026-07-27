<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Trabajador;
use App\Models\Usuario;
use App\Support\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TrabajadorController extends Controller
{
    public function index(Request $request)
    {
        $trabajadores = Trabajador::with(['usuario', 'especialidad'])
            ->when($request->search, fn ($q) => $q->whereHas('usuario', fn ($u) => $u->where('nombre', 'like', "%{$request->search}%"))
                ->orWhere('ci', 'like', "%{$request->search}%"))
            ->when($request->estado, fn ($q) => $q->where('estado', $request->estado))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('trabajadores.index', compact('trabajadores'));
    }

    public function create()
    {
        $especialidades = Especialidad::orderBy('nombre')->get();
        return view('trabajadores.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'unique:usuarios,correo'],
            'contrasena' => ['required', 'min:6'],
            'ci' => ['required', 'string', 'unique:trabajadores,ci'],
            'telefono' => ['nullable', 'string'],
            'especialidad_id' => ['required', 'exists:especialidades,id'],
            'fecha_contratacion' => ['required', 'date'],
        ]);

        $usuario = Usuario::create([
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'contrasena' => Hash::make($data['contrasena']),
            'rol' => 'trabajador',
            'estado' => 'activo',
        ]);

        $trabajador = Trabajador::create([
            'usuario_id' => $usuario->id,
            'especialidad_id' => $data['especialidad_id'],
            'ci' => $data['ci'],
            'telefono' => $data['telefono'] ?? null,
            'fecha_contratacion' => $data['fecha_contratacion'],
            'estado' => 'activo',
        ]);

        Bitacora::registrar('crear', 'Trabajador', $trabajador->id, "Trabajador {$usuario->nombre} registrado");

        return redirect()->route('trabajadores.index')->with('success', 'Trabajador registrado correctamente.');
    }

    public function edit(Trabajador $trabajador)
    {
        $trabajador->load('usuario', 'especialidad');
        $especialidades = Especialidad::orderBy('nombre')->get();
        return view('trabajadores.edit', compact('trabajador', 'especialidades'));
    }

    public function update(Request $request, Trabajador $trabajador)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'unique:usuarios,correo,' . $trabajador->usuario_id],
            'contrasena' => ['nullable', 'min:6'],
            'ci' => ['required', 'string', 'unique:trabajadores,ci,' . $trabajador->id],
            'telefono' => ['nullable', 'string'],
            'especialidad_id' => ['required', 'exists:especialidades,id'],
            'fecha_contratacion' => ['required', 'date'],
        ]);

        $trabajador->usuario->update([
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'contrasena' => $data['contrasena'] ? Hash::make($data['contrasena']) : $trabajador->usuario->contrasena,
        ]);

        $trabajador->update([
            'especialidad_id' => $data['especialidad_id'],
            'ci' => $data['ci'],
            'telefono' => $data['telefono'] ?? null,
            'fecha_contratacion' => $data['fecha_contratacion'],
        ]);

        Bitacora::registrar('editar', 'Trabajador', $trabajador->id, "Trabajador {$trabajador->usuario->nombre} actualizado");

        return redirect()->route('trabajadores.index')->with('success', 'Trabajador actualizado correctamente.');
    }

    public function toggleEstado(Trabajador $trabajador)
    {
        $nuevoEstado = $trabajador->estado === 'activo' ? 'inactivo' : 'activo';
        $trabajador->update(['estado' => $nuevoEstado]);
        $trabajador->usuario->update(['estado' => $nuevoEstado]);

        Bitacora::registrar('cambio_estado', 'Trabajador', $trabajador->id, "Trabajador {$trabajador->usuario->nombre} marcado como {$nuevoEstado}");

        return back()->with('success', "Trabajador marcado como {$nuevoEstado}.");
    }
}
