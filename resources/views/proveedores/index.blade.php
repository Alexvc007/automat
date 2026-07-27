@extends('layouts.app')
@section('title', 'Proveedores')
@section('header', 'Proveedores')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr><th class="text-left px-5 py-3">Nombre</th><th class="text-left px-5 py-3">Teléfono</th><th class="text-left px-5 py-3">Correo</th><th class="text-left px-5 py-3">Ítems</th><th class="text-right px-5 py-3">Acciones</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($proveedores as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <form method="POST" action="{{ route('proveedores.update', $p) }}" class="flex flex-wrap gap-1 items-center">
                            @csrf @method('PUT')
                            <input type="text" name="nombre" value="{{ $p->nombre }}" class="border rounded px-2 py-1 text-sm w-32">
                            <input type="text" name="telefono" value="{{ $p->telefono }}" placeholder="Teléfono" class="border rounded px-2 py-1 text-sm w-24">
                            <input type="email" name="correo" value="{{ $p->correo }}" placeholder="Correo" class="border rounded px-2 py-1 text-sm w-32">
                            <input type="text" name="direccion" value="{{ $p->direccion }}" placeholder="Dirección" class="border rounded px-2 py-1 text-sm w-28">
                            <button class="text-blue-600 text-xs hover:underline">Guardar</button>
                        </form>
                    </td>
                    <td class="px-5 py-3">{{ $p->telefono ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $p->correo ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $p->items_inventario_count }}</td>
                    <td class="px-5 py-3 text-right">
                        <form method="POST" action="{{ route('proveedores.destroy', $p) }}" onsubmit="return confirm('¿Eliminar proveedor?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline text-xs">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">No hay proveedores.</td></tr>
                @endforelse
            </tbody>
        </table>
        <x-pagination :paginator="$proveedores" />
    </div>
    <div class="bg-white rounded-xl border shadow-sm p-5 h-fit">
        <h3 class="font-semibold text-gray-800 mb-3">Nuevo proveedor</h3>
        <form method="POST" action="{{ route('proveedores.store') }}" class="space-y-3">
            @csrf
            <input type="text" name="nombre" placeholder="Nombre" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <input type="text" name="telefono" placeholder="Teléfono" class="w-full border rounded-lg px-3 py-2 text-sm">
            <input type="email" name="correo" placeholder="Correo" class="w-full border rounded-lg px-3 py-2 text-sm">
            <input type="text" name="direccion" placeholder="Dirección" class="w-full border rounded-lg px-3 py-2 text-sm">
            <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">Agregar</button>
        </form>
    </div>
</div>
@endsection
