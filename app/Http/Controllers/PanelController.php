<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ItemInventario;
use App\Models\OrdenServicio;
use App\Models\Pago;
use App\Models\Trabajador;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\DB;

class PanelController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        if ($usuario->isAdmin()) {
            $kpis = [
                'ordenes_activas' => OrdenServicio::whereIn('estado', ['recibido', 'en_proceso'])->count(),
                'ordenes_terminadas_mes' => OrdenServicio::where('estado', 'entregado')
                    ->whereMonth('fecha_entrega', now()->month)->count(),
                'ingresos_mes' => Pago::whereMonth('fecha_pago', now()->month)
                    ->whereYear('fecha_pago', now()->year)->sum('monto'),
                'clientes_total' => Cliente::count(),
                'vehiculos_total' => Vehiculo::count(),
                'trabajadores_activos' => Trabajador::where('estado', 'activo')->count(),
                'items_bajo_stock' => ItemInventario::whereColumn('stock', '<=', 'stock_minimo')->count(),
                'pagos_pendientes' => OrdenServicio::where('estado_pago', '!=', 'pagado')->count(),
            ];

            $ordenesRecientes = OrdenServicio::with(['vehiculo.cliente.usuario', 'trabajador.usuario'])
                ->orderByDesc('created_at')->limit(8)->get();

            $topServicios = DB::table('detalles_orden_servicio')
                ->select('descripcion', DB::raw('COUNT(*) as veces'))
                ->groupBy('descripcion')
                ->orderByDesc('veces')
                ->limit(5)
                ->get();

            return view('panel.admin', compact('kpis', 'ordenesRecientes', 'topServicios'));
        }

        if ($usuario->isCliente()) {
            return view('panel.cliente');
        }

        $trabajador = $usuario->trabajador;
        $misOrdenes = $trabajador
            ? OrdenServicio::with(['vehiculo.cliente.usuario'])
                ->where('trabajador_id', $trabajador->id)
                ->whereIn('estado', ['recibido', 'en_proceso'])
                ->orderBy('fecha_entrega_estimada')
                ->get()
            : collect();

        return view('panel.trabajador', compact('misOrdenes'));
    }
}
