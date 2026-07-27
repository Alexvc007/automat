@extends('layouts.app')
@section('title', 'Bitácora')
@section('header', 'Bitácora de auditoría')

@section('content')
<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr><th class="text-left px-5 py-3">Fecha</th><th class="text-left px-5 py-3">Usuario</th><th class="text-left px-5 py-3">Acción</th><th class="text-left px-5 py-3">Detalle</th></tr>
        </thead>
        <tbody class="divide-y">
            @forelse($registros as $log)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-5 py-3">{{ $log->usuario?->nombre ?? 'Sistema' }}</td>
                <td class="px-5 py-3"><x-badge>{{ $log->accion }}</x-badge></td>
                <td class="px-5 py-3 text-gray-600">{{ $log->descripcion }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">Aún no hay registros en la bitácora.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<x-pagination :paginator="$registros" />
@endsection
