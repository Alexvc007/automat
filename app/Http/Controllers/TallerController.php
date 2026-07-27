<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    public function index()
    {
        return view('talleres.index');
    }

    /**
     * ENDPOINT: GET /talleres/buscar?nombre=xxx
     * Devuelve en JSON los talleres registrados que coinciden con el nombre buscado,
     * para pintarlos como marcadores en el mapa de Google Maps.
     */
    public function buscar(Request $request)
    {
        $request->validate(['nombre' => ['nullable', 'string', 'max:255']]);

        $talleres = Taller::when($request->filled('nombre'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->input('nombre') . '%');
            })
            ->orderBy('nombre')
            ->limit(20)
            ->get(['id', 'nombre', 'direccion', 'ciudad', 'telefono', 'latitud', 'longitud']);

        return response()->json($talleres);
    }

    public function administrar(Request $request)
    {
        $talleres = Taller::when($request->search, fn ($q) => $q->where('nombre', 'like', "%{$request->search}%"))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('talleres.administrar', compact('talleres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'ciudad' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'latitud' => ['required', 'numeric', 'between:-90,90'],
            'longitud' => ['required', 'numeric', 'between:-180,180'],
        ]);
        $data['ciudad'] = $data['ciudad'] ?? 'Santa Cruz de la Sierra';

        Taller::create($data);

        return redirect()->route('talleres.administrar')->with('success', 'Taller registrado en el directorio.');
    }

    public function edit(Taller $taller)
    {
        return view('talleres.edit', compact('taller'));
    }

    public function update(Request $request, Taller $taller)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'ciudad' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'latitud' => ['required', 'numeric', 'between:-90,90'],
            'longitud' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $taller->update($data);

        return redirect()->route('talleres.administrar')->with('success', 'Taller actualizado.');
    }

    public function destroy(Taller $taller)
    {
        $taller->delete();
        return redirect()->route('talleres.administrar')->with('success', 'Taller eliminado del directorio.');
    }
}
