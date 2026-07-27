@extends('layouts.app')
@section('title', 'Nuevo trabajador')
@section('header', 'Registrar trabajador')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-2xl">
    <form method="POST" action="{{ route('trabajadores.store') }}" class="space-y-4">
        @csrf
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CI</label>
                <input type="text" name="ci" value="{{ old('ci') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" name="correo" value="{{ old('correo') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="contrasena" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de contratación</label>
                <input type="date" name="fecha_contratacion" value="{{ old('fecha_contratacion') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
                <select name="especialidad_id" required class="w-full border rounded-lg px-3 py-2">
                    <option value="">Selecciona una especialidad</option>
                    @foreach($especialidades as $esp)
                        <option value="{{ $esp->id }}" @selected(old('especialidad_id')==$esp->id)>{{ $esp->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar trabajador</button>
            <a href="{{ route('trabajadores.index') }}" class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
        </div>
    </form>
</div>
@endsection
