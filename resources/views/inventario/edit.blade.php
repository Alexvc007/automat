@extends('layouts.app')
@section('title', 'Editar ítem')
@section('header', 'Editar ítem de inventario')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('inventario.update', $item) }}" class="space-y-4">
        @csrf @method('PUT')
        @include('inventario._form', ['item' => $item])
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar cambios</button>
            <a href="{{ route('inventario.index') }}" class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
        </div>
    </form>
</div>
@endsection
