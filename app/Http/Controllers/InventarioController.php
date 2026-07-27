<?php

namespace App\Http\Controllers;

use App\Models\ItemInventario;
use App\Models\Proveedor;
use App\Support\Bitacora;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $items = ItemInventario::with('proveedor')
            ->when($request->search, fn ($q) => $q->where('nombre', 'like', "%{$request->search}%"))
            ->when($request->categoria, fn ($q) => $q->where('categoria', $request->categoria))
            ->when($request->stock_bajo, fn ($q) => $q->whereColumn('stock', '<=', 'stock_minimo'))
            ->orderBy('nombre')
            ->paginate(12)
            ->withQueryString();

        $categorias = ItemInventario::select('categoria')->distinct()->pluck('categoria');

        return view('inventario.index', compact('items', 'categorias'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('inventario.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'string', 'max:255'],
            'unidad' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'precio_unitario' => ['required', 'numeric', 'min:0'],
            'proveedor_id' => ['nullable', 'exists:proveedores,id'],
        ]);

        $item = ItemInventario::create($data);
        Bitacora::registrar('crear', 'ItemInventario', $item->id, "Ítem {$item->nombre} agregado al inventario");

        return redirect()->route('inventario.index')->with('success', 'Ítem agregado al inventario.');
    }

    public function edit(ItemInventario $itemInventario)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('inventario.edit', ['item' => $itemInventario, 'proveedores' => $proveedores]);
    }

    public function update(Request $request, ItemInventario $itemInventario)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'string', 'max:255'],
            'unidad' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'precio_unitario' => ['required', 'numeric', 'min:0'],
            'proveedor_id' => ['nullable', 'exists:proveedores,id'],
        ]);

        $itemInventario->update($data);
        Bitacora::registrar('editar', 'ItemInventario', $itemInventario->id, "Ítem {$itemInventario->nombre} actualizado");

        return redirect()->route('inventario.index')->with('success', 'Ítem actualizado.');
    }

    public function destroy(ItemInventario $itemInventario)
    {
        if ($itemInventario->repuestosOrden()->exists()) {
            return back()->withErrors(['nombre' => 'No se puede eliminar: el ítem tiene historial de uso en órdenes.']);
        }
        $itemInventario->delete();
        return back()->with('success', 'Ítem eliminado del inventario.');
    }
}
