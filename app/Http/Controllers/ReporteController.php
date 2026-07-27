<?php

namespace App\Http\Controllers;

use App\Models\ItemInventario;
use App\Models\Pago;
use App\Models\OrdenServicio;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $ingresosPorDia = Pago::whereBetween('fecha_pago', [$from, $to])
            ->select(DB::raw('DATE(fecha_pago) as fecha'), DB::raw('SUM(monto) as total'))
            ->groupBy('fecha')->orderBy('fecha')->get();

        $ingresoTotal = Pago::whereBetween('fecha_pago', [$from, $to])->sum('monto');

        $ordenesPorEstado = OrdenServicio::select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')->get();

        $rendimientoTrabajadores = Trabajador::withCount(['ordenesServicio' => function ($q) use ($from, $to) {
                $q->whereBetween('fecha_ingreso', [$from, $to]);
            }])
            ->with('usuario')
            ->orderByDesc('ordenes_servicio_count')
            ->get();

        $itemsBajoStock = ItemInventario::whereColumn('stock', '<=', 'stock_minimo')->orderBy('stock')->get();

        return view('panel.reportes', compact(
            'from', 'to', 'ingresosPorDia', 'ingresoTotal', 'ordenesPorEstado',
            'rendimientoTrabajadores', 'itemsBajoStock'
        ));
    }
}
