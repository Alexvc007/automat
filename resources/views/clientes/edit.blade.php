@extends('layouts.app')
@section('title', 'Editar cliente')
@section('header', 'Editar cliente')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('clientes.update', $cliente) }}" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
            <input type="text" name="nombre" value="{{ old('nombre', $cliente->usuario->nombre) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" name="correo" value="{{ old('correo', $cliente->usuario->correo) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña (opcional)</label>
            <input type="password" name="contrasena" placeholder="Dejar en blanco para no cambiar" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">CI / NIT</label>
            <input type="text" name="ci_nit" value="{{ old('ci_nit', $cliente->ci_nit) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección (opcional)</label>
            <input type="text" name="direccion" value="{{ old('direccion', $cliente->direccion) }}" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar cambios</button>
            <a href="{{ route('clientes.show', $cliente) }}" class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
        </div>
    </form>
</div>
@endsection
