<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::withCount('itemsInventario')->orderBy('nombre')->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string'],
            'correo' => ['nullable', 'email'],
            'direccion' => ['nullable', 'string'],
        ]);
        Proveedor::create($data);
        return back()->with('success', 'Proveedor agregado.');
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string'],
            'correo' => ['nullable', 'email'],
            'direccion' => ['nullable', 'string'],
        ]);
        $proveedor->update($data);
        return back()->with('success', 'Proveedor actualizado.');
    }

    public function destroy(Proveedor $proveedor)
    {
        if ($proveedor->itemsInventario()->exists()) {
            return back()->withErrors(['nombre' => 'No se puede eliminar: tiene ítems de inventario asociados.']);
        }
        $proveedor->delete();
        return back()->with('success', 'Proveedor eliminado.');
    }
}
