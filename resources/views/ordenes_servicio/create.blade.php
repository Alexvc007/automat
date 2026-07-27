@extends('layouts.app')
@section('title', 'Nueva orden de servicio')
@section('header', 'Nueva orden de servicio')

@section('content')
<form method="POST" action="{{ route('ordenes_servicio.store') }}" class="space-y-6" id="ordenForm">
    @csrf

    <div class="bg-white rounded-xl border shadow-sm p-6 grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Vehículo (buscar por placa)</label>
            <select name="vehiculo_id" required class="w-full border rounded-lg px-3 py-2">
                <option value="">Selecciona un vehículo</option>
                @foreach($vehiculos as $v)
                    <option value="{{ $v->id }}" @selected($vehiculoSeleccionadoId == $v->id)>{{ $v->placa }} — {{ $v->marca }} {{ $v->modelo }} ({{ $v->cliente->usuario->nombre }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Trabajador asignado (opcional)</label>
            <select name="trabajador_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">Sin asignar por ahora</option>
                @foreach($trabajadores as $t)
                    <option value="{{ $t->id }}">{{ $t->usuario->nombre }} — {{ $t->especialidad->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de ingreso</label>
            <input type="date" name="fecha_ingreso" value="{{ date('Y-m-d') }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha estimada de entrega</label>
            <input type="date" name="fecha_entrega_estimada" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción / observaciones</label>
            <textarea name="descripcion" rows="2" class="w-full border rounded-lg px-3 py-2" placeholder="Detalle del problema reportado por el cliente..."></textarea>
        </div>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-gray-800">Servicios a realizar</h3>
            <button type="button" onclick="agregarFilaServicio()" class="text-sm bg-slate-900 text-white px-3 py-1.5 rounded-lg">+ Agregar servicio</button>
        </div>
        <datalist id="listaCatalogo">
            @foreach($catalogo as $c)
                <option value="{{ $c->nombre }}" data-precio="{{ $c->precio_base }}"></option>
            @endforeach
        </datalist>
        <div id="contenedorServicios" class="space-y-2"></div>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-gray-800">Repuestos e insumos usados</h3>
            <button type="button" onclick="agregarFilaRepuesto()" class="text-sm bg-slate-900 text-white px-3 py-1.5 rounded-lg">+ Agregar repuesto</button>
        </div>
        <div id="contenedorRepuestos" class="space-y-2"></div>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-3">Estado de pago</h3>
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">¿El cliente pagó algo ahora?</label>
                <select id="opcionPago" onchange="alternarMontoPago()" class="w-full border rounded-lg px-3 py-2">
                    <option value="ninguno">No, pagará al final (pendiente)</option>
                    <option value="mitad">Pagó la mitad ahora</option>
                    <option value="total">Pagó el total ahora</option>
                    <option value="otro">Otro monto</option>
                </select>
            </div>
            <div id="envolturaMonto" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Monto pagado (Bs.)</label>
                <input type="number" step="0.01" name="pago_inicial" id="pago_inicial" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Método de pago</label>
                <select name="metodo_pago" class="w-full border rounded-lg px-3 py-2">
                    <option value="efectivo">Efectivo</option>
                    <option value="qr">QR</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="tarjeta">Tarjeta</option>
                </select>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-3">Total estimado: <span id="totalEstimado" class="font-semibold text-slate-900">Bs. 0.00</span></p>
    </div>

    <div class="flex gap-2">
        <button class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700">Crear orden de servicio</button>
        <a href="{{ route('ordenes_servicio.index') }}" class="px-6 py-2.5 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
    </div>
</form>

<script>
const itemsInventario = @json($inventario);
let indiceServicio = 0;
let indiceRepuesto = 0;

function agregarFilaServicio() {
    const i = indiceServicio++;
    const div = document.createElement('div');
    div.className = 'grid grid-cols-1 sm:grid-cols-12 gap-2 sm:items-center border sm:border-0 rounded-lg p-3 sm:p-0';
    div.innerHTML = `
        <input list="listaCatalogo" name="servicios[${i}][descripcion]" placeholder="Nombre del servicio" required
            class="sm:col-span-6 border rounded-lg px-3 py-2 text-sm" oninput="llenarPrecio(this)">
        <input type="number" name="servicios[${i}][cantidad]" value="1" min="1" required
            class="sm:col-span-2 border rounded-lg px-3 py-2 text-sm" onchange="actualizarTotal()">
        <input type="number" step="0.01" name="servicios[${i}][precio]" placeholder="Precio" required
            class="sm:col-span-3 border rounded-lg px-3 py-2 text-sm" onchange="actualizarTotal()">
        <button type="button" onclick="this.parentElement.remove(); actualizarTotal();" class="sm:col-span-1 text-red-500 text-sm text-right sm:text-center">✕ Quitar</button>
    `;
    document.getElementById('contenedorServicios').appendChild(div);
}

function llenarPrecio(input) {
    const lista = document.getElementById('listaCatalogo');
    const opcion = [...lista.options].find(o => o.value === input.value);
    if (opcion) {
        const fila = input.closest('.grid');
        fila.querySelector('input[name*="[precio]"]').value = opcion.dataset.precio;
        actualizarTotal();
    }
}

function agregarFilaRepuesto() {
    const i = indiceRepuesto++;
    const div = document.createElement('div');
    div.className = 'grid grid-cols-1 sm:grid-cols-12 gap-2 sm:items-center border sm:border-0 rounded-lg p-3 sm:p-0';
    let opciones = '<option value="">Selecciona un ítem</option>';
    itemsInventario.forEach(it => {
        opciones += `<option value="${it.id}" data-precio="${it.precio}" data-stock="${it.stock}">${it.nombre} (stock: ${it.stock})</option>`;
    });
    div.innerHTML = `
        <select name="repuestos[${i}][item_inventario_id]" required class="sm:col-span-7 border rounded-lg px-3 py-2 text-sm" onchange="repuestoSeleccionado(this)">${opciones}</select>
        <input type="number" name="repuestos[${i}][cantidad]" value="1" min="1" required
            class="sm:col-span-3 border rounded-lg px-3 py-2 text-sm" onchange="actualizarTotal()">
        <span class="sm:col-span-1 text-xs text-gray-500 precioRepuesto">—</span>
        <button type="button" onclick="this.parentElement.remove(); actualizarTotal();" class="sm:col-span-1 text-red-500 text-sm text-right sm:text-center">✕ Quitar</button>
    `;
    document.getElementById('contenedorRepuestos').appendChild(div);
}

function repuestoSeleccionado(select) {
    const opcion = select.selectedOptions[0];
    const fila = select.closest('.grid');
    fila.querySelector('.precioRepuesto').textContent = opcion.dataset.precio ? `Bs.${opcion.dataset.precio}` : '—';
    actualizarTotal();
}

function actualizarTotal() {
    let total = 0;
    document.querySelectorAll('#contenedorServicios .grid').forEach(fila => {
        const cant = parseFloat(fila.querySelector('input[name*="[cantidad]"]')?.value || 0);
        const precio = parseFloat(fila.querySelector('input[name*="[precio]"]')?.value || 0);
        total += cant * precio;
    });
    document.querySelectorAll('#contenedorRepuestos .grid').forEach(fila => {
        const select = fila.querySelector('select');
        const precio = parseFloat(select?.selectedOptions[0]?.dataset.precio || 0);
        const cant = parseFloat(fila.querySelector('input[name*="[cantidad]"]')?.value || 0);
        total += cant * precio;
    });
    document.getElementById('totalEstimado').textContent = 'Bs. ' + total.toFixed(2);
    window.totalActual = total;
    aplicarOpcionPago();
}

function alternarMontoPago() {
    const val = document.getElementById('opcionPago').value;
    document.getElementById('envolturaMonto').classList.toggle('hidden', val === 'ninguno');
    aplicarOpcionPago();
}

function aplicarOpcionPago() {
    const val = document.getElementById('opcionPago').value;
    const input = document.getElementById('pago_inicial');
    if (val === 'mitad') input.value = ((window.totalActual || 0) / 2).toFixed(2);
    if (val === 'total') input.value = (window.totalActual || 0).toFixed(2);
    if (val === 'ninguno') input.value = '';
}

agregarFilaServicio();
</script>
@endsection
