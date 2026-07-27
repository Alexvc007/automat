<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function index()
    {
        $especialidades = Especialidad::withCount('trabajadores')->orderBy('nombre')->paginate(10);
        return view('especialidades.index', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nombre' => ['required', 'string', 'max:255', 'unique:especialidades,nombre']]);
        Especialidad::create($data);
        return back()->with('success', 'Especialidad agregada.');
    }

    public function update(Request $request, Especialidad $especialidad)
    {
        $data = $request->validate(['nombre' => ['required', 'string', 'max:255', 'unique:especialidades,nombre,' . $especialidad->id]]);
        $especialidad->update($data);
        return back()->with('success', 'Especialidad actualizada.');
    }

    public function destroy(Especialidad $especialidad)
    {
        if ($especialidad->trabajadores()->exists()) {
            return back()->withErrors(['nombre' => 'No se puede eliminar: hay trabajadores con esta especialidad.']);
        }
        $especialidad->delete();
        return back()->with('success', 'Especialidad eliminada.');
    }
}
