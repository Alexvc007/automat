@extends('layouts.app')
@section('title', 'Panel')
@section('header', 'Panel general')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl p-5 shadow-sm border">
        <p class="text-xs text-gray-500">Órdenes activas</p>
        <p class="text-2xl font-bold text-slate-900">{{ $kpis['ordenes_activas'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border">
        <p class="text-xs text-gray-500">Entregadas este mes</p>
        <p class="text-2xl font-bold text-slate-900">{{ $kpis['ordenes_terminadas_mes'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border">
        <p class="text-xs text-gray-500">Ingresos del mes</p>
        <p class="text-2xl font-bold text-green-600">Bs. {{ number_format($kpis['ingresos_mes'], 2) }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border">
        <p class="text-xs text-gray-500">Pagos pendientes</p>
        <p class="text-2xl font-bold text-amber-600">{{ $kpis['pagos_pendientes'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border">
        <p class="text-xs text-gray-500">Clientes</p>
        <p class="text-2xl font-bold text-slate-900">{{ $kpis['clientes_total'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border">
        <p class="text-xs text-gray-500">Vehículos</p>
        <p class="text-2xl font-bold text-slate-900">{{ $kpis['vehiculos_total'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border">
        <p class="text-xs text-gray-500">Trabajadores activos</p>
        <p class="text-2xl font-bold text-slate-900">{{ $kpis['trabajadores_activos'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border">
        <p class="text-xs text-gray-500">Ítems bajo stock</p>
        <p class="text-2xl font-bold text-red-600">{{ $kpis['items_bajo_stock'] }}</p>
    </div>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-xl border shadow-sm overflow-x-auto">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Órdenes recientes</h3>
            <a href="{{ route('ordenes_servicio.create') }}" class="text-sm bg-slate-900 text-white px-3 py-1.5 rounded-lg hover:bg-slate-800">+ Nueva orden</a>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-2">Orden</th>
                    <th class="text-left px-5 py-2">Vehículo</th>
                    <th class="text-left px-5 py-2">Trabajador</th>
                    <th class="text-left px-5 py-2">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($ordenesRecientes as $orden)
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="location.href='{{ route('ordenes_servicio.show', $orden) }}'">
                    <td class="px-5 py-3 font-medium text-slate-800">{{ $orden->numero_orden }}</td>
                    <td class="px-5 py-3">{{ $orden->vehiculo->placa }} · {{ $orden->vehiculo->cliente->usuario->nombre }}</td>
                    <td class="px-5 py-3">{{ $orden->trabajador?->usuario->nombre ?? 'Sin asignar' }}</td>
                    <td class="px-5 py-3"><x-badge color="blue">{{ str_replace('_',' ', $orden->estado) }}</x-badge></td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">Aún no hay órdenes registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-5">
        <h3 class="font-semibold text-gray-800 mb-3">Servicios más solicitados</h3>
        <ul class="space-y-2 text-sm">
            @forelse($topServicios as $s)
            <li class="flex justify-between border-b pb-2">
                <span class="text-gray-700">{{ $s->descripcion }}</span>
                <span class="font-medium text-slate-900">{{ $s->veces }}</span>
            </li>
            @empty
            <li class="text-gray-400">Sin datos aún.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
