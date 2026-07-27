@extends('layouts.app')
@section('title', 'Órdenes de servicio')
@section('header', 'Órdenes de servicio')

@section('content')
<div class="flex items-center justify-between mb-4 flex-wrap gap-2">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por Nº orden o placa..." class="border rounded-lg px-3 py-2 text-sm w-60">
        <select name="estado" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">Todos los estados</option>
            <option value="recibido" @selected(request('estado')=='recibido')>Recibido</option>
            <option value="en_proceso" @selected(request('estado')=='en_proceso')>En proceso</option>
            <option value="terminado" @selected(request('estado')=='terminado')>Terminado</option>
            <option value="entregado" @selected(request('estado')=='entregado')>Entregado</option>
        </select>
        <select name="estado_pago" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">Todos los pagos</option>
            <option value="pendiente" @selected(request('estado_pago')=='pendiente')>Pendiente</option>
            <option value="parcial" @selected(request('estado_pago')=='parcial')>Parcial</option>
            <option value="pagado" @selected(request('estado_pago')=='pagado')>Pagado</option>
        </select>
        <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Filtrar</button>
    </form>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('ordenes_servicio.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Nueva orden</a>
    @endif
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Orden</th>
                <th class="text-left px-5 py-3">Vehículo</th>
                <th class="text-left px-5 py-3">Cliente</th>
                <th class="text-left px-5 py-3">Trabajador</th>
                <th class="text-left px-5 py-3">Total</th>
                <th class="text-left px-5 py-3">Pago</th>
                <th class="text-left px-5 py-3">Estado</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($ordenes as $orden)
            <tr class="hover:bg-gray-50 cursor-pointer" onclick="location.href='{{ route('ordenes_servicio.show', $orden) }}'">
                <td class="px-5 py-3 font-medium text-slate-800">{{ $orden->numero_orden }}</td>
                <td class="px-5 py-3">{{ $orden->vehiculo->placa }}</td>
                <td class="px-5 py-3">{{ $orden->vehiculo->cliente->usuario->nombre }}</td>
                <td class="px-5 py-3">{{ $orden->trabajador?->usuario->nombre ?? 'Sin asignar' }}</td>
                <td class="px-5 py-3">Bs. {{ number_format($orden->monto_total, 2) }}</td>
                <td class="px-5 py-3">
                    <x-badge color="{{ $orden->estado_pago == 'pagado' ? 'green' : ($orden->estado_pago == 'parcial' ? 'yellow' : 'red') }}">
                        {{ $orden->estado_pago }}
                    </x-badge>
                </td>
                <td class="px-5 py-3"><x-badge color="blue">{{ str_replace('_',' ', $orden->estado) }}</x-badge></td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-5 py-6 text-center text-gray-400">No hay órdenes de servicio.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<x-pagination :paginator="$ordenes" />
@endsection
