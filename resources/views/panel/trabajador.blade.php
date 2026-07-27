@extends('layouts.app')
@section('title', 'Panel')
@section('header', 'Mis órdenes asignadas')

@section('content')
<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-2">Orden</th>
                <th class="text-left px-5 py-2">Vehículo</th>
                <th class="text-left px-5 py-2">Cliente</th>
                <th class="text-left px-5 py-2">Entrega estimada</th>
                <th class="text-left px-5 py-2">Estado</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($misOrdenes as $orden)
            <tr class="hover:bg-gray-50 cursor-pointer" onclick="location.href='{{ route('ordenes_servicio.show', $orden) }}'">
                <td class="px-5 py-3 font-medium text-slate-800">{{ $orden->numero_orden }}</td>
                <td class="px-5 py-3">{{ $orden->vehiculo->placa }} · {{ $orden->vehiculo->marca }} {{ $orden->vehiculo->modelo }}</td>
                <td class="px-5 py-3">{{ $orden->vehiculo->cliente->usuario->nombre }}</td>
                <td class="px-5 py-3">{{ $orden->fecha_entrega_estimada?->format('d/m/Y') ?? '—' }}</td>
                <td class="px-5 py-3"><x-badge color="blue">{{ str_replace('_',' ', $orden->estado) }}</x-badge></td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">No tienes órdenes asignadas por el momento.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
