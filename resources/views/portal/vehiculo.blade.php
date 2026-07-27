@extends('layouts.app')
@section('title', 'Estado de mi vehículo')
@section('header', 'Estado de mi vehículo')

@section('content')
@if(!$cliente || $cliente->vehiculos->isEmpty())
    <div class="bg-white rounded-xl border shadow-sm p-8 text-center text-gray-500">
        Aún no tienes vehículos registrados. Si acabas de traer tu auto al taller, pídele al administrador que lo registre a tu nombre.
    </div>
@else
    <div class="space-y-6">
        @foreach($cliente->vehiculos as $vehiculo)
        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <div class="px-5 py-4 border-b flex items-center justify-between flex-wrap gap-2">
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $vehiculo->marca }} {{ $vehiculo->modelo }} — {{ $vehiculo->placa }}</h3>
                    <p class="text-xs text-gray-500">{{ $vehiculo->color ?? '—' }} · {{ $vehiculo->anio ?? 'Año no registrado' }}</p>
                </div>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-2">Orden</th>
                        <th class="text-left px-5 py-2">Ingreso</th>
                        <th class="text-left px-5 py-2">Entrega estimada</th>
                        <th class="text-left px-5 py-2">Trabajador</th>
                        <th class="text-left px-5 py-2">Estado</th>
                        <th class="text-left px-5 py-2">Pago</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($vehiculo->ordenesServicio as $orden)
                    <tr>
                        <td class="px-5 py-3 font-medium">{{ $orden->numero_orden }}</td>
                        <td class="px-5 py-3">{{ $orden->fecha_ingreso->format('d/m/Y') }}</td>
                        <td class="px-5 py-3">{{ $orden->fecha_entrega_estimada?->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-5 py-3">{{ $orden->trabajador?->usuario->nombre ?? 'Sin asignar' }}</td>
                        <td class="px-5 py-3"><x-badge color="blue">{{ str_replace('_',' ', $orden->estado) }}</x-badge></td>
                        <td class="px-5 py-3">
                            <x-badge color="{{ $orden->estado_pago == 'pagado' ? 'green' : ($orden->estado_pago == 'parcial' ? 'yellow' : 'red') }}">
                                {{ $orden->estado_pago }} @if($orden->estado_pago != 'pagado') · saldo Bs. {{ number_format($orden->saldo, 2) }} @endif
                            </x-badge>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-4 text-center text-gray-400">Este vehículo aún no tiene órdenes de servicio.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
@endif
@endsection
