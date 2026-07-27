@extends('layouts.app')
@section('title', 'Pagos')
@section('header', 'Historial de pagos')

@section('content')
<form method="GET" class="flex gap-2 mb-4">
    <input type="date" name="from" value="{{ request('from') }}" class="border rounded-lg px-3 py-2 text-sm">
    <input type="date" name="to" value="{{ request('to') }}" class="border rounded-lg px-3 py-2 text-sm">
    <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Filtrar</button>
</form>

<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr><th class="text-left px-5 py-3">Fecha</th><th class="text-left px-5 py-3">Orden</th><th class="text-left px-5 py-3">Cliente</th><th class="text-left px-5 py-3">Método</th><th class="text-right px-5 py-3">Monto</th></tr>
        </thead>
        <tbody class="divide-y">
            @forelse($pagos as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">{{ $p->fecha_pago->format('d/m/Y') }}</td>
                <td class="px-5 py-3"><a href="{{ route('ordenes_servicio.show', $p->ordenServicio) }}" class="text-blue-600 hover:underline">{{ $p->ordenServicio->numero_orden }}</a></td>
                <td class="px-5 py-3">{{ $p->ordenServicio->vehiculo->cliente->usuario->nombre }}</td>
                <td class="px-5 py-3 capitalize">{{ $p->metodo }}</td>
                <td class="px-5 py-3 text-right font-medium">Bs. {{ number_format($p->monto, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">No hay pagos registrados en este rango.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<x-pagination :paginator="$pagos" />
@endsection
