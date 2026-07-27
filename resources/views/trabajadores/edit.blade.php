@extends('layouts.app')
@section('title', 'Editar trabajador')
@section('header', 'Editar trabajador')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-2xl">
    <form method="POST" action="{{ route('trabajadores.update', $trabajador) }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                <input type="text" name="nombre" value="{{ old('nombre', $trabajador->usuario->nombre) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CI</label>
                <input type="text" name="ci" value="{{ old('ci', $trabajador->ci) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" name="correo" value="{{ old('correo', $trabajador->usuario->correo) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña (opcional)</label>
                <input type="password" name="contrasena" placeholder="Dejar en blanco para no cambiar" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $trabajador->telefono) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de contratación</label>
                <input type="date" name="fecha_contratacion" value="{{ old('fecha_contratacion', $trabajador->fecha_contratacion->format('Y-m-d')) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
                <select name="especialidad_id" required class="w-full border rounded-lg px-3 py-2">
                    @foreach($especialidades as $esp)
                        <option value="{{ $esp->id }}" @selected(old('especialidad_id', $trabajador->especialidad_id)==$esp->id)>{{ $esp->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar cambios</button>
            <a href="{{ route('trabajadores.index') }}" class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
        </div>
    </form>
</div>
@endsection
