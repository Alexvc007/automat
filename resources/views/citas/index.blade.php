@extends('layouts.app')
@section('title', 'Citas')
@section('header', 'Citas programadas')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr><th class="text-left px-5 py-3">Fecha / hora</th><th class="text-left px-5 py-3">Cliente</th><th class="text-left px-5 py-3">Motivo</th><th class="text-left px-5 py-3">Estado</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($citas as $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">{{ $c->fecha_hora->format('d/m/Y H:i') }}</td>
                    <td class="px-5 py-3">{{ $c->cliente->usuario->nombre }}</td>
                    <td class="px-5 py-3">{{ $c->motivo }}</td>
                    <td class="px-5 py-3">
                        <form method="POST" action="{{ route('citas.estado', $c) }}">
                            @csrf @method('PATCH')
                            <select name="estado" onchange="this.form.submit()" class="border rounded px-2 py-1 text-xs">
                                <option value="pendiente" @selected($c->estado=='pendiente')>Pendiente</option>
                                <option value="confirmada" @selected($c->estado=='confirmada')>Confirmada</option>
                                <option value="atendida" @selected($c->estado=='atendida')>Atendida</option>
                                <option value="cancelada" @selected($c->estado=='cancelada')>Cancelada</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">No hay citas programadas.</td></tr>
                @endforelse
            </tbody>
        </table>
        <x-pagination :paginator="$citas" />
    </div>
    <div class="bg-white rounded-xl border shadow-sm p-5 h-fit">
        <h3 class="font-semibold text-gray-800 mb-3">Nueva cita</h3>
        <form method="POST" action="{{ route('citas.store') }}" class="space-y-3">
            @csrf
            <select name="cliente_id" required class="w-full border rounded-lg px-3 py-2 text-sm">
                <option value="">Selecciona un cliente</option>
                @foreach(\App\Models\Cliente::with('usuario')->get()->sortBy(fn($c) => $c->usuario->nombre) as $cl)
                    <option value="{{ $cl->id }}">{{ $cl->usuario->nombre }}</option>
                @endforeach
            </select>
            <input type="datetime-local" name="fecha_hora" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <input type="text" name="motivo" placeholder="Motivo de la cita" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">Agendar</button>
        </form>
    </div>
</div>
@endsection
