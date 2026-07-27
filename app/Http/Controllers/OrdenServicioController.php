<?php

namespace App\Http\Controllers;

use App\Models\CatalogoServicio;
use App\Models\ItemInventario;
use App\Models\OrdenServicio;
use App\Models\Trabajador;
use App\Models\Vehiculo;
use App\Support\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenServicioController extends Controller
{
    public function index(Request $request)
    {
        $query = OrdenServicio::with(['vehiculo.cliente.usuario', 'trabajador.usuario']);

        if (!auth()->user()->isAdmin()) {
            $query->where('trabajador_id', auth()->user()->trabajador?->id);
        }

        $ordenes = $query
            ->when($request->search, fn ($q) => $q->where('numero_orden', 'like', "%{$request->search}%")
                ->orWhereHas('vehiculo', fn ($v) => $v->where('placa', 'like', "%{$request->search}%")))
            ->when($request->estado, fn ($q) => $q->where('estado', $request->estado))
            ->when($request->estado_pago, fn ($q) => $q->where('estado_pago', $request->estado_pago))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('ordenes_servicio.index', compact('ordenes'));
    }

    public function create(Request $request)
    {
        $vehiculos = Vehiculo::with('cliente')->orderBy('placa')->get();
        $trabajadores = Trabajador::with('usuario', 'especialidad')->where('estado', 'activo')->get();
        $catalogo = CatalogoServicio::orderBy('nombre')->get();

        $inventario = ItemInventario::orderBy('nombre')->get()->map(fn ($i) => [
            'id' => $i->id,
            'nombre' => $i->nombre,
            'precio' => $i->precio_unitario,
            'stock' => $i->stock,
        ]);

        $vehiculoSeleccionadoId = $request->vehiculo_id;

        return view('ordenes_servicio.create', compact('vehiculos', 'trabajadores', 'catalogo', 'inventario', 'vehiculoSeleccionadoId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehiculo_id' => ['required', 'exists:vehiculos,id'],
            'trabajador_id' => ['nullable', 'exists:trabajadores,id'],
            'fecha_ingreso' => ['required', 'date'],
            'fecha_entrega_estimada' => ['nullable', 'date'],
            'descripcion' => ['nullable', 'string'],
            'servicios' => ['nullable', 'array'],
            'servicios.*.descripcion' => ['required_with:servicios', 'string'],
            'servicios.*.cantidad' => ['required_with:servicios', 'integer', 'min:1'],
            'servicios.*.precio' => ['required_with:servicios', 'numeric', 'min:0'],
            'repuestos' => ['nullable', 'array'],
            'repuestos.*.item_inventario_id' => ['required_with:repuestos', 'exists:items_inventario,id'],
            'repuestos.*.cantidad' => ['required_with:repuestos', 'integer', 'min:1'],
            'pago_inicial' => ['nullable', 'numeric', 'min:0'],
            'metodo_pago' => ['nullable', 'in:efectivo,qr,transferencia,tarjeta'],
        ]);

        $orden = DB::transaction(function () use ($data, $request) {
            $orden = OrdenServicio::create([
                'numero_orden' => 'OS-' . strtoupper(uniqid()),
                'vehiculo_id' => $data['vehiculo_id'],
                'trabajador_id' => $data['trabajador_id'] ?? null,
                'creado_por' => auth()->id(),
                'fecha_ingreso' => $data['fecha_ingreso'],
                'fecha_entrega_estimada' => $data['fecha_entrega_estimada'] ?? null,
                'estado' => 'recibido',
                'descripcion' => $data['descripcion'] ?? null,
                'estado_pago' => 'pendiente',
            ]);

            foreach ($data['servicios'] ?? [] as $servicio) {
                $orden->detalles()->create([
                    'descripcion' => $servicio['descripcion'],
                    'cantidad' => $servicio['cantidad'],
                    'precio' => $servicio['precio'],
                ]);
            }

            foreach ($data['repuestos'] ?? [] as $repuesto) {
                $item = ItemInventario::lockForUpdate()->findOrFail($repuesto['item_inventario_id']);
                if ($item->stock < $repuesto['cantidad']) {
                    throw new \Exception("Stock insuficiente para {$item->nombre} (disponible: {$item->stock}).");
                }
                $orden->repuestos()->create([
                    'item_inventario_id' => $item->id,
                    'cantidad' => $repuesto['cantidad'],
                    'precio_unitario' => $item->precio_unitario,
                ]);
                $item->decrement('stock', $repuesto['cantidad']);
            }

            $orden->recalcularTotales();

            if ($request->filled('pago_inicial') && $request->pago_inicial > 0) {
                $orden->pagos()->create([
                    'monto' => $request->pago_inicial,
                    'fecha_pago' => now(),
                    'metodo' => $request->metodo_pago ?? 'efectivo',
                    'registrado_por' => auth()->id(),
                ]);
                $orden->increment('monto_pagado', $request->pago_inicial);
                $orden->recalcularTotales();
            }

            return $orden;
        });

        Bitacora::registrar('crear', 'OrdenServicio', $orden->id, "Orden {$orden->numero_orden} creada");

        return redirect()->route('ordenes_servicio.show', $orden)->with('success', 'Orden de servicio creada correctamente.');
    }

    public function show(OrdenServicio $ordenServicio)
    {
        $this->autorizarAcceso($ordenServicio);
        $ordenServicio->load(['vehiculo.cliente.usuario', 'trabajador.usuario', 'detalles', 'repuestos.item', 'pagos.registradoPor']);
        $trabajadores = Trabajador::with('usuario')->where('estado', 'activo')->get();

        return view('ordenes_servicio.show', ['orden' => $ordenServicio, 'trabajadores' => $trabajadores]);
    }

    public function actualizarEstado(Request $request, OrdenServicio $ordenServicio)
    {
        $this->autorizarAcceso($ordenServicio);

        $data = $request->validate([
            'estado' => ['required', 'in:recibido,en_proceso,terminado,entregado'],
        ]);

        $ordenServicio->estado = $data['estado'];
        if ($data['estado'] === 'entregado') {
            $ordenServicio->fecha_entrega = now();
        }
        $ordenServicio->save();

        Bitacora::registrar('cambio_estado', 'OrdenServicio', $ordenServicio->id, "Orden {$ordenServicio->numero_orden} -> {$data['estado']}");

        return back()->with('success', 'Estado de la orden actualizado.');
    }

    public function asignarTrabajador(Request $request, OrdenServicio $ordenServicio)
    {
        $data = $request->validate(['trabajador_id' => ['required', 'exists:trabajadores,id']]);
        $ordenServicio->update(['trabajador_id' => $data['trabajador_id']]);

        return back()->with('success', 'Trabajador asignado.');
    }

    private function autorizarAcceso(OrdenServicio $orden): void
    {
        if (!auth()->user()->isAdmin() && $orden->trabajador_id !== auth()->user()->trabajador?->id) {
            abort(403, 'No tienes acceso a esta orden.');
        }
    }
}
