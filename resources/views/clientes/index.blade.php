@extends('layouts.app')
@section('title', 'Clientes')
@section('header', 'Clientes')

@section('content')
<div class="flex items-center justify-between mb-4 flex-wrap gap-2">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, CI/NIT o teléfono..." class="border rounded-lg px-3 py-2 text-sm w-72">
        <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Buscar</button>
    </form>
    <a href="{{ route('clientes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Nuevo cliente</a>
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Nombre</th>
                <th class="text-left px-5 py-3">Correo (acceso)</th>
                <th class="text-left px-5 py-3">CI/NIT</th>
                <th class="text-left px-5 py-3">Teléfono</th>
                <th class="text-left px-5 py-3">Vehículos</th>
                <th class="text-left px-5 py-3">Estado</th>
                <th class="text-right px-5 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($clientes as $cliente)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-medium text-slate-800 cursor-pointer" onclick="location.href='{{ route('clientes.show', $cliente) }}'">{{ $cliente->usuario->nombre }}</td>
                <td class="px-5 py-3">{{ $cliente->usuario->correo }}</td>
                <td class="px-5 py-3">{{ $cliente->ci_nit }}</td>
                <td class="px-5 py-3">{{ $cliente->telefono }}</td>
                <td class="px-5 py-3">{{ $cliente->vehiculos_count }}</td>
                <td class="px-5 py-3">
                    <x-badge color="{{ $cliente->usuario->estado == 'activo' ? 'green' : 'red' }}">{{ $cliente->usuario->estado }}</x-badge>
                </td>
                <td class="px-5 py-3 text-right space-x-2">
                    <a href="{{ route('clientes.edit', $cliente) }}" class="text-blue-600 hover:underline">Editar</a>
                    <form method="POST" action="{{ route('clientes.toggle', $cliente) }}" class="inline" onsubmit="return confirm('¿Confirmar cambio de estado?')">
                        @csrf @method('PATCH')
                        <button class="text-{{ $cliente->usuario->estado == 'activo' ? 'red' : 'green' }}-600 hover:underline">
                            {{ $cliente->usuario->estado == 'activo' ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-5 py-6 text-center text-gray-400">No hay clientes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<x-pagination :paginator="$clientes" />
@endsection
