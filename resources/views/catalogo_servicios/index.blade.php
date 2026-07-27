@extends('layouts.app')
@section('title', 'Catálogo de servicios')
@section('header', 'Catálogo de servicios')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr><th class="text-left px-5 py-3">Servicio</th><th class="text-left px-5 py-3">Precio base</th><th class="text-left px-5 py-3">Duración (min)</th><th class="text-right px-5 py-3">Acciones</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($servicios as $s)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <form method="POST" action="{{ route('catalogo_servicios.update', $s) }}" class="flex flex-wrap gap-1 items-center">
                            @csrf @method('PUT')
                            <input type="text" name="nombre" value="{{ $s->nombre }}" class="border rounded px-2 py-1 text-sm w-40">
                            <input type="number" step="0.01" name="precio_base" value="{{ $s->precio_base }}" class="border rounded px-2 py-1 text-sm w-20">
                            <input type="number" name="minutos_estimados" value="{{ $s->minutos_estimados }}" class="border rounded px-2 py-1 text-sm w-16">
                            <input type="hidden" name="descripcion" value="{{ $s->descripcion }}">
                            <button class="text-blue-600 text-xs hover:underline">Guardar</button>
                        </form>
                    </td>
                    <td class="px-5 py-3">Bs. {{ number_format($s->precio_base, 2) }}</td>
                    <td class="px-5 py-3">{{ $s->minutos_estimados ? $s->minutos_estimados.' min' : '—' }}</td>
                    <td class="px-5 py-3 text-right">
                        <form method="POST" action="{{ route('catalogo_servicios.destroy', $s) }}" onsubmit="return confirm('¿Eliminar servicio del catálogo?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline text-xs">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">No hay servicios en el catálogo.</td></tr>
                @endforelse
            </tbody>
        </table>
        <x-pagination :paginator="$servicios" />
    </div>
    <div class="bg-white rounded-xl border shadow-sm p-5 h-fit">
        <h3 class="font-semibold text-gray-800 mb-3">Nuevo servicio</h3>
        <form method="POST" action="{{ route('catalogo_servicios.store') }}" class="space-y-3">
            @csrf
            <input type="text" name="nombre" placeholder="Nombre del servicio" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <textarea name="descripcion" placeholder="Descripción (opcional)" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
            <input type="number" step="0.01" name="precio_base" placeholder="Precio base (Bs.)" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <input type="number" name="minutos_estimados" placeholder="Duración estimada (min)" class="w-full border rounded-lg px-3 py-2 text-sm">
            <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">Agregar</button>
        </form>
    </div>
</div>
@endsection
