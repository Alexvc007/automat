@extends('layouts.app')
@section('title', 'Nuevo cliente')
@section('header', 'Registrar cliente')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-xl">
    <p class="text-sm text-gray-500 mb-4">El cliente podrá iniciar sesión con el correo y contraseña que definas aquí, para ver el estado de su vehículo y reservar citas.</p>
    <form method="POST" action="{{ route('clientes.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico (para iniciar sesión)</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
            <input type="password" name="contrasena" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">CI / NIT</label>
            <input type="text" name="ci_nit" value="{{ old('ci_nit') }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección (opcional)</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar cliente</button>
            <a href="{{ route('clientes.index') }}" class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
        </div>
    </form>
</div>
@endsection
