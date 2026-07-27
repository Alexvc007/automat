@extends('layouts.app')
@section('title', 'Reservar cita')
@section('header', 'Mis citas')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-xl border shadow-sm overflow-x-auto">
        <div class="px-5 py-3 border-b"><h3 class="font-semibold text-gray-800">Mis citas</h3></div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr><th class="text-left px-5 py-3">Fecha / hora</th><th class="text-left px-5 py-3">Vehículo</th><th class="text-left px-5 py-3">Motivo</th><th class="text-left px-5 py-3">Estado</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($citas as $c)
                <tr>
                    <td class="px-5 py-3">{{ $c->fecha_hora->format('d/m/Y H:i') }}</td>
                    <td class="px-5 py-3">{{ $c->vehiculo ? $c->vehiculo->placa . ' — ' . $c->vehiculo->marca : 'No especificado' }}</td>
                    <td class="px-5 py-3">{{ $c->motivo }}</td>
                    <td class="px-5 py-3">
                        <x-badge color="{{ $c->estado == 'confirmada' ? 'green' : ($c->estado == 'cancelada' ? 'red' : ($c->estado == 'atendida' ? 'blue' : 'yellow')) }}">
                            {{ $c->estado }}
                        </x-badge>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">Todavía no tienes citas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-5 h-fit">
        <h3 class="font-semibold text-gray-800 mb-3">Reservar nueva cita</h3>
        <form method="POST" action="{{ route('portal.citas.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Vehículo (opcional)</label>
                <select name="vehiculo_id" class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="">No especificar / aún no registrado</option>
                    @foreach($vehiculos as $v)
                        <option value="{{ $v->id }}">{{ $v->placa }} — {{ $v->marca }} {{ $v->modelo }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Fecha y hora</label>
                <input type="datetime-local" name="fecha_hora" required class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Motivo</label>
                <input type="text" name="motivo" placeholder="Ej: cambio de aceite, ruido en el motor..." required class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">Reservar cita</button>
        </form>
    </div>
</div>
@endsection
