@extends('layouts.app')
@section('title', 'Especialidades')
@section('header', 'Especialidades de trabajadores')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-3">Especialidad</th>
                    <th class="text-left px-5 py-3">Trabajadores</th>
                    <th class="text-right px-5 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($especialidades as $esp)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <form method="POST" action="{{ route('especialidades.update', $esp) }}" class="flex gap-2">
                            @csrf @method('PUT')
                            <input type="text" name="nombre" value="{{ $esp->nombre }}" class="border rounded px-2 py-1 text-sm">
                            <button class="text-blue-600 text-xs hover:underline">Guardar</button>
                        </form>
                    </td>
                    <td class="px-5 py-3">{{ $esp->trabajadores_count }}</td>
                    <td class="px-5 py-3 text-right">
                        <form method="POST" action="{{ route('especialidades.destroy', $esp) }}" onsubmit="return confirm('¿Eliminar esta especialidad?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline text-xs">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-5 py-6 text-center text-gray-400">No hay especialidades.</td></tr>
                @endforelse
            </tbody>
        </table>
        <x-pagination :paginator="$especialidades" />
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-5 h-fit">
        <h3 class="font-semibold text-gray-800 mb-3">Nueva especialidad</h3>
        <form method="POST" action="{{ route('especialidades.store') }}" class="space-y-3">
            @csrf
            <input type="text" name="nombre" placeholder="Ej: Mecánica diésel" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">Agregar</button>
        </form>
    </div>
</div>
@endsection
