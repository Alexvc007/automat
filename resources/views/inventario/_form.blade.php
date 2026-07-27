<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $item->nombre ?? '') }}" required class="w-full border rounded-lg px-3 py-2">
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
        <input type="text" name="categoria" value="{{ old('categoria', $item->categoria ?? '') }}" required placeholder="Ej: Lubricantes, Frenos, Eléctrico..." class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Unidad de medida</label>
        <input type="text" name="unidad" value="{{ old('unidad', $item->unidad ?? '') }}" required placeholder="Ej: litro, unidad, juego" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Stock actual</label>
        <input type="number" name="stock" value="{{ old('stock', $item->stock ?? 0) }}" required class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Stock mínimo (alerta)</label>
        <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $item->stock_minimo ?? 5) }}" required class="w-full border rounded-lg px-3 py-2">
    </div>
    <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Precio unitario (Bs.)</label>
        <input type="number" step="0.01" name="precio_unitario" value="{{ old('precio_unitario', $item->precio_unitario ?? 0) }}" required class="w-full border rounded-lg px-3 py-2">
    </div>
    <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor (opcional)</label>
        <select name="proveedor_id" class="w-full border rounded-lg px-3 py-2">
            <option value="">Sin proveedor</option>
            @foreach($proveedores as $p)
                <option value="{{ $p->id }}" @selected(old('proveedor_id', $item->proveedor_id ?? null)==$p->id)>{{ $p->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
