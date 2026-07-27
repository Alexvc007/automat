@extends('layouts.app')
@section('title', 'Inventario')
@section('header', 'Inventario del taller')

@section('content')
<div class="flex items-center justify-between mb-4 flex-wrap gap-2">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar ítem..." class="border rounded-lg px-3 py-2 text-sm w-56">
        <select name="categoria" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">Todas las categorías</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat }}" @selected(request('categoria')==$cat)>{{ $cat }}</option>
            @endforeach
        </select>
        <label class="flex items-center gap-1 text-sm border rounded-lg px-3 py-2">
            <input type="checkbox" name="stock_bajo" value="1" @checked(request('stock_bajo'))> Bajo stock
        </label>
        <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Filtrar</button>
    </form>
    <a href="{{ route('inventario.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Nuevo ítem</a>
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Nombre</th>
                <th class="text-left px-5 py-3">Categoría</th>
                <th class="text-left px-5 py-3">Stock</th>
                <th class="text-left px-5 py-3">Precio unitario</th>
                <th class="text-left px-5 py-3">Proveedor</th>
                <th class="text-right px-5 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($items as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-medium">{{ $item->nombre }}</td>
                <td class="px-5 py-3">{{ $item->categoria }}</td>
                <td class="px-5 py-3">
                    {{ $item->stock }} {{ $item->unidad }}
                    @if($item->stock_bajo)<x-badge color="red">bajo</x-badge>@endif
                </td>
                <td class="px-5 py-3">Bs. {{ number_format($item->precio_unitario, 2) }}</td>
                <td class="px-5 py-3">{{ $item->proveedor?->nombre ?? '—' }}</td>
                <td class="px-5 py-3 text-right space-x-2">
                    <a href="{{ route('inventario.edit', $item) }}" class="text-blue-600 hover:underline">Editar</a>
                    <form method="POST" action="{{ route('inventario.destroy', $item) }}" class="inline" onsubmit="return confirm('¿Eliminar ítem?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-6 text-center text-gray-400">No hay ítems en el inventario.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<x-pagination :paginator="$items" />
@endsection
