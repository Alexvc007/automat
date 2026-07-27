@extends('layouts.app')
@section('title', $orden->numero_orden)
@section('header', 'Orden ' . $orden->numero_orden)

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 space-y-6">

        <div class="bg-white rounded-xl border shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $orden->vehiculo->placa }} — {{ $orden->vehiculo->marca }} {{ $orden->vehiculo->modelo }}</h3>
                    <p class="text-sm text-gray-500">Cliente: {{ $orden->vehiculo->cliente->usuario->nombre }} · {{ $orden->vehiculo->cliente->telefono }}</p>
                </div>
                <x-badge color="blue">{{ str_replace('_',' ', $orden->estado) }}</x-badge>
            </div>
            @if($orden->descripcion)
            <p class="text-sm text-gray-600 mt-3 border-t pt-3">{{ $orden->descripcion }}</p>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4 text-sm">
                <div><p class="text-gray-500">Ingreso</p><p class="font-medium">{{ $orden->fecha_ingreso->format('d/m/Y') }}</p></div>
                <div><p class="text-gray-500">Entrega estimada</p><p class="font-medium">{{ $orden->fecha_entrega_estimada?->format('d/m/Y') ?? '—' }}</p></div>
                <div><p class="text-gray-500">Trabajador</p><p class="font-medium">{{ $orden->trabajador?->usuario->nombre ?? 'Sin asignar' }}</p></div>
            </div>
        </div>

        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <div class="px-5 py-3 border-b"><h3 class="font-semibold text-gray-800">Servicios realizados</h3></div>
            <table class="w-full text-sm">
                <tbody class="divide-y">
                    @forelse($orden->detalles as $d)
                    <tr><td class="px-5 py-2">{{ $d->descripcion }}</td><td class="px-5 py-2 text-gray-500">x{{ $d->cantidad }}</td><td class="px-5 py-2 text-right">Bs. {{ number_format($d->precio * $d->cantidad, 2) }}</td></tr>
                    @empty
                    <tr><td class="px-5 py-3 text-gray-400">Sin servicios registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <div class="px-5 py-3 border-b"><h3 class="font-semibold text-gray-800">Repuestos utilizados</h3></div>
            <table class="w-full text-sm">
                <tbody class="divide-y">
                    @forelse($orden->repuestos as $r)
                    <tr><td class="px-5 py-2">{{ $r->item->nombre }}</td><td class="px-5 py-2 text-gray-500">x{{ $r->cantidad }}</td><td class="px-5 py-2 text-right">Bs. {{ number_format($r->precio_unitario * $r->cantidad, 2) }}</td></tr>
                    @empty
                    <tr><td class="px-5 py-3 text-gray-400">Sin repuestos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <div class="px-5 py-3 border-b"><h3 class="font-semibold text-gray-800">Historial de pagos</h3></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr><th class="text-left px-5 py-2">Fecha</th><th class="text-left px-5 py-2">Método</th><th class="text-left px-5 py-2">Registrado por</th><th class="text-right px-5 py-2">Monto</th></tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($orden->pagos as $p)
                    <tr>
                        <td class="px-5 py-2">{{ $p->fecha_pago->format('d/m/Y') }}</td>
                        <td class="px-5 py-2 capitalize">{{ $p->metodo }}</td>
                        <td class="px-5 py-2">{{ $p->registradoPor?->nombre ?? '—' }}</td>
                        <td class="px-5 py-2 text-right">Bs. {{ number_format($p->monto, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-3 text-gray-400">Aún no se registran pagos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl border shadow-sm p-5">
            <h3 class="font-semibold text-gray-800 mb-3">Resumen de pago</h3>
            <div class="space-y-1 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Total</span><span class="font-medium">Bs. {{ number_format($orden->monto_total, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Pagado</span><span class="font-medium text-green-600">Bs. {{ number_format($orden->monto_pagado, 2) }}</span></div>
                <div class="flex justify-between border-t pt-1"><span class="text-gray-500">Saldo</span><span class="font-semibold text-red-600">Bs. {{ number_format($orden->saldo, 2) }}</span></div>
            </div>
            <x-badge color="{{ $orden->estado_pago == 'pagado' ? 'green' : ($orden->estado_pago == 'parcial' ? 'yellow' : 'red') }}" class="mt-3 inline-block">
                {{ $orden->estado_pago }}
            </x-badge>

            @if($orden->saldo > 0)
            <form method="POST" action="{{ route('pagos.store', $orden) }}" class="mt-4 space-y-2 border-t pt-4">
                @csrf
                <label class="block text-xs font-medium text-gray-600">Registrar nuevo pago</label>
                <input type="number" step="0.01" name="monto" max="{{ $orden->saldo }}" placeholder="Monto (Bs.)" required class="w-full border rounded-lg px-3 py-2 text-sm">
                <input type="date" name="fecha_pago" value="{{ date('Y-m-d') }}" required class="w-full border rounded-lg px-3 py-2 text-sm">
                <select name="metodo" required class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="efectivo">Efectivo</option>
                    <option value="qr">QR</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="tarjeta">Tarjeta</option>
                </select>
                <button class="w-full bg-green-600 text-white py-2 rounded-lg text-sm hover:bg-green-700">Registrar pago</button>
            </form>
            @endif
        </div>

        <div class="bg-white rounded-xl border shadow-sm p-5">
            <h3 class="font-semibold text-gray-800 mb-3">Estado de la orden</h3>
            <form method="POST" action="{{ route('ordenes_servicio.estado', $orden) }}" class="space-y-2">
                @csrf @method('PATCH')
                <select name="estado" class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="recibido" @selected($orden->estado=='recibido')>Recibido</option>
                    <option value="en_proceso" @selected($orden->estado=='en_proceso')>En proceso</option>
                    <option value="terminado" @selected($orden->estado=='terminado')>Terminado</option>
                    <option value="entregado" @selected($orden->estado=='entregado')>Entregado</option>
                </select>
                <button class="w-full bg-slate-900 text-white py-2 rounded-lg text-sm hover:bg-slate-800">Actualizar estado</button>
            </form>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="bg-white rounded-xl border shadow-sm p-5">
            <h3 class="font-semibold text-gray-800 mb-3">Asignar trabajador</h3>
            <form method="POST" action="{{ route('ordenes_servicio.asignar', $orden) }}" class="space-y-2">
                @csrf @method('PATCH')
                <select name="trabajador_id" required class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="">Selecciona un trabajador</option>
                    @foreach($trabajadores as $t)
                        <option value="{{ $t->id }}" @selected($orden->trabajador_id==$t->id)>{{ $t->usuario->nombre }}</option>
                    @endforeach
                </select>
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">Asignar</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
