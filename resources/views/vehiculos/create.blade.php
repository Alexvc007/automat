@extends('layouts.app')
@section('title', 'Nuevo vehículo')
@section('header', 'Registrar vehículo')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-xl">
    <p class="text-sm text-gray-500 mb-4">Cliente: <span class="font-medium text-gray-800">{{ $cliente->usuario->nombre }}</span></p>
    <form method="POST" action="{{ route('vehiculos.store', $cliente) }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Placa</label>
            <input type="text" name="placa" value="{{ old('placa') }}" required class="w-full border rounded-lg px-3 py-2 uppercase">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                <input type="text" name="marca" value="{{ old('marca') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                <input type="text" name="modelo" value="{{ old('modelo') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <input type="text" name="anio" value="{{ old('anio') }}" maxlength="4" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                <input type="text" name="color" value="{{ old('color') }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kilometraje</label>
                <input type="number" name="kilometraje" value="{{ old('kilometraje') }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar vehículo</button>
            <a href="{{ route('clientes.show', $cliente) }}" class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
        </div>
    </form>
</div>
@endsection
