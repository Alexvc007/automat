<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;

class BitacoraController extends Controller
{
    public function index()
    {
        $registros = Bitacora::with('usuario')->orderByDesc('created_at')->paginate(20);
        return view('panel.bitacora', compact('registros'));
    }
}
