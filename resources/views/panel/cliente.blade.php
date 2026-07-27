@extends('layouts.app')
@section('title', 'Panel')
@section('header', 'Bienvenido')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
    <a href="{{ route('portal.vehiculo') }}" class="bg-white rounded-xl border shadow-sm p-6 hover:shadow-md transition block">
        <div class="text-3xl mb-3">🚗</div>
        <h3 class="font-semibold text-gray-800 text-lg mb-1">Estado de mi vehículo</h3>
        <p class="text-sm text-gray-500">Revisa en qué va la orden de servicio de tu auto, qué se hizo y cuánto debes.</p>
    </a>
    <a href="{{ route('portal.citas') }}" class="bg-white rounded-xl border shadow-sm p-6 hover:shadow-md transition block">
        <div class="text-3xl mb-3">📅</div>
        <h3 class="font-semibold text-gray-800 text-lg mb-1">Reservar cita</h3>
        <p class="text-sm text-gray-500">Agenda una nueva visita al taller y revisa tus citas anteriores.</p>
    </a>
</div>
@endsection
