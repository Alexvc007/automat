@extends('layouts.app')
@section('title', 'Editar taller')
@section('header', 'Editar taller del directorio')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('talleres.update', $taller) }}" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del taller</label>
            <input type="text" name="nombre" value="{{ old('nombre', $taller->nombre) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $taller->direccion) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                <input type="text" name="ciudad" value="{{ old('ciudad', $taller->ciudad) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $taller->telefono) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Latitud</label>
                <input type="text" name="latitud" value="{{ old('latitud', $taller->latitud) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Longitud</label>
                <input type="text" name="longitud" value="{{ old('longitud', $taller->longitud) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar cambios</button>
            <a href="{{ route('talleres.administrar') }}" class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
        </div>
    </form>
</div>
@endsection
