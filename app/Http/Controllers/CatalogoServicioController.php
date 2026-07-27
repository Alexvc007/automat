<?php

namespace App\Http\Controllers;

use App\Models\CatalogoServicio;
use Illuminate\Http\Request;

class CatalogoServicioController extends Controller
{
    public function index()
    {
        $servicios = CatalogoServicio::orderBy('nombre')->paginate(10);
        return view('catalogo_servicios.index', compact('servicios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'minutos_estimados' => ['nullable', 'integer', 'min:0'],
        ]);
        CatalogoServicio::create($data);
        return back()->with('success', 'Servicio agregado al catálogo.');
    }

    public function update(Request $request, CatalogoServicio $catalogoServicio)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'minutos_estimados' => ['nullable', 'integer', 'min:0'],
        ]);
        $catalogoServicio->update($data);
        return back()->with('success', 'Servicio actualizado.');
    }

    public function destroy(CatalogoServicio $catalogoServicio)
    {
        $catalogoServicio->delete();
        return back()->with('success', 'Servicio eliminado del catálogo.');
    }
}
