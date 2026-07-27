@extends('layouts.app')
@section('title', 'Reportes')
@section('header', 'Reportes y estadísticas')

@section('content')
<form method="GET" class="flex gap-2 mb-6">
    <input type="date" name="from" value="{{ $from }}" class="border rounded-lg px-3 py-2 text-sm">
    <input type="date" name="to" value="{{ $to }}" class="border rounded-lg px-3 py-2 text-sm">
    <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Aplicar rango</button>
</form>

<div class="grid md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-xl border shadow-sm p-5">
        <p class="text-xs text-gray-500">Ingresos en el rango seleccionado</p>
        <p class="text-3xl font-bold text-green-600">Bs. {{ number_format($ingresoTotal, 2) }}</p>
    </div>
    <div class="bg-white rounded-xl border shadow-sm p-5">
        <h3 class="font-semibold text-gray-800 mb-2 text-sm">Órdenes por estado</h3>
        <div class="flex gap-4 text-sm">
            @foreach($ordenesPorEstado as $o)
                <div><p class="text-gray-500 capitalize">{{ str_replace('_',' ',$o->estado) }}</p><p class="font-bold text-slate-900">{{ $o->total }}</p></div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
        <div class="px-5 py-3 border-b"><h3 class="font-semibold text-gray-800">Rendimiento por trabajador</h3></div>
        <table class="w-full text-sm">
            <tbody class="divide-y">
                @foreach($rendimientoTrabajadores as $t)
                <tr><td class="px-5 py-2">{{ $t->usuario->nombre }}</td><td class="px-5 py-2 text-right font-medium">{{ $t->ordenes_servicio_count }} órdenes</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
        <div class="px-5 py-3 border-b"><h3 class="font-semibold text-gray-800">Ítems con bajo stock</h3></div>
        <table class="w-full text-sm">
            <tbody class="divide-y">
                @forelse($itemsBajoStock as $item)
                <tr><td class="px-5 py-2">{{ $item->nombre }}</td><td class="px-5 py-2 text-right text-red-600 font-medium">{{ $item->stock }} {{ $item->unidad }}</td></tr>
                @empty
                <tr><td class="px-5 py-3 text-gray-400">Todo el stock está en niveles saludables.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
