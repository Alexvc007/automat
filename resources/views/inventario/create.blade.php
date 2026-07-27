@extends('layouts.app')
@section('title', 'Nuevo ítem')
@section('header', 'Agregar ítem de inventario')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('inventario.store') }}" class="space-y-4">
        @csrf
        @include('inventario._form', ['item' => null])
        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Guardar ítem</button>
            <a href="{{ route('inventario.index') }}" class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
        </div>
    </form>
</div>
@endsection
