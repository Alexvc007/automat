<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        // Puedes pasar datos a la vista si lo necesitas
        // $data = [
        //     'titulo' => 'AutoMaster',
        //     'descripcion' => 'Sistema de Gestión de Taller'
        // ];
        
        return view('inicio');
    }
}