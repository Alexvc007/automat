@extends('layouts.app')
@section('title', $cliente->usuario->nombre)
@section('header', 'Detalle del cliente')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl border shadow-sm p-5">
        <h3 class="font-semibold text-gray-800 mb-3">Información del cliente</h3>
        <dl class="text-sm space-y-2">
            <div class="flex justify-between"><dt class="text-gray-500">Nombre</dt><dd class="font-medium">{{ $cliente->usuario->nombre }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Correo (acceso)</dt><dd>{{ $cliente->usuario->correo }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">CI/NIT</dt><dd>{{ $cliente->ci_nit }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Teléfono</dt><dd>{{ $cliente->telefono }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Dirección</dt><dd>{{ $cliente->direccion ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Estado de la cuenta</dt><dd><x-badge color="{{ $cliente->usuario->estado == 'activo' ? 'green' : 'red' }}">{{ $cliente->usuario->estado }}</x-badge></dd></div>
        </dl>
        <div class="flex gap-2 mt-4">
            <a href="{{ route('clientes.edit', $cliente) }}" class="text-sm text-blue-600 hover:underline">Editar</a>
            <form method="POST" action="{{ route('clientes.destroy', $cliente) }}" onsubmit="return confirm('¿Eliminar cliente? Esto también elimina su cuenta de acceso.')">
                @csrf @method('DELETE')
                <button class="text-sm text-red-600 hover:underline">Eliminar</button>
            </form>
        </div>
    </div>

    <div class="md:col-span-2 bg-white rounded-xl border shadow-sm overflow-x-auto">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Vehículos</h3>
            <a href="{{ route('vehiculos.create', $cliente) }}" class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700">+ Agregar vehículo</a>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-2">Placa</th>
                    <th class="text-left px-5 py-2">Marca / Modelo</th>
                    <th class="text-left px-5 py-2">Año</th>
                    <th class="text-left px-5 py-2">Órdenes</th>
                    <th class="text-right px-5 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($cliente->vehiculos as $vehiculo)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $vehiculo->placa }}</td>
                    <td class="px-5 py-3">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</td>
                    <td class="px-5 py-3">{{ $vehiculo->anio ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $vehiculo->ordenesServicio->count() }}</td>
                    <td class="px-5 py-3 text-right space-x-2">
                        <a href="{{ route('ordenes_servicio.create', ['vehiculo_id' => $vehiculo->id]) }}" class="text-green-600 hover:underline">Nueva orden</a>
                        <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="text-blue-600 hover:underline">Editar</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">Este cliente aún no tiene vehículos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
