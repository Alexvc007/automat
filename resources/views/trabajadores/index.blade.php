@extends('layouts.app')
@section('title', 'Trabajadores')
@section('header', 'Trabajadores')

@section('content')
<div class="flex items-center justify-between mb-4 flex-wrap gap-2">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o CI..." class="border rounded-lg px-3 py-2 text-sm w-64">
        <select name="estado" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">Todos los estados</option>
            <option value="activo" @selected(request('estado')=='activo')>Activo</option>
            <option value="inactivo" @selected(request('estado')=='inactivo')>Inactivo</option>
        </select>
        <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Filtrar</button>
    </form>
    <a href="{{ route('trabajadores.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Nuevo trabajador</a>
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Nombre</th>
                <th class="text-left px-5 py-3">CI</th>
                <th class="text-left px-5 py-3">Especialidad</th>
                <th class="text-left px-5 py-3">Teléfono</th>
                <th class="text-left px-5 py-3">Estado</th>
                <th class="text-right px-5 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($trabajadores as $trabajador)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-medium text-slate-800">{{ $trabajador->usuario->nombre }}</td>
                <td class="px-5 py-3">{{ $trabajador->ci }}</td>
                <td class="px-5 py-3">{{ $trabajador->especialidad->nombre }}</td>
                <td class="px-5 py-3">{{ $trabajador->telefono ?? '—' }}</td>
                <td class="px-5 py-3">
                    <x-badge color="{{ $trabajador->estado == 'activo' ? 'green' : 'red' }}">{{ $trabajador->estado }}</x-badge>
                </td>
                <td class="px-5 py-3 text-right space-x-2">
                    <a href="{{ route('trabajadores.edit', $trabajador) }}" class="text-blue-600 hover:underline">Editar</a>
                    <form method="POST" action="{{ route('trabajadores.toggle', $trabajador) }}" class="inline" onsubmit="return confirm('¿Confirmar cambio de estado?')">
                        @csrf @method('PATCH')
                        <button class="text-{{ $trabajador->estado == 'activo' ? 'red' : 'green' }}-600 hover:underline">
                            {{ $trabajador->estado == 'activo' ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-6 text-center text-gray-400">No hay trabajadores registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<x-pagination :paginator="$trabajadores" />
@endsection
