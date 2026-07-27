@extends('layouts.app')
@section('title', 'Editar vehículo')
@section('header', 'Editar vehículo')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('vehiculos.update', $vehiculo) }}" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Placa</label>
            <input type="text" name="placa" value="{{ old('placa', $vehiculo->placa) }}" required class="w-full border rounded-lg px-3 py-2 uppercase">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                <input type="text" name="marca" value="{{ old('marca', $vehiculo->marca) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                <input type="text" name="modelo" value="{{ old('modelo', $vehiculo->modelo) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <input type="text" name="anio" value="{{ old('anio', $vehiculo->anio) }}" maxlength="4" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                <input type="text" name="color" value="{{ old('color', $vehiculo->color) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kilometraje</label>
                <input type="number" name="kilometraje" value="{{ old('kilometraje', $vehiculo->kilometraje) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar cambios</button>
            <form method="POST" action="{{ route('vehiculos.destroy', $vehiculo) }}" onsubmit="return confirm('¿Eliminar vehículo?')">
                @csrf @method('DELETE')
                <button class="px-5 py-2 rounded-lg border text-red-600 hover:bg-red-50">Eliminar</button>
            </form>
        </div>
    </form>
</div>
@endsection
