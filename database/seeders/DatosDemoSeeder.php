<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Especialidad;
use App\Models\Usuario;
use App\Models\Vehiculo;
use App\Models\Trabajador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatosDemoSeeder extends Seeder
{
    /**
     * Datos de ejemplo para poder probar el sistema de inmediato con los 3 roles.
     */
    public function run(): void
    {
        $especialidad = Especialidad::where('nombre', 'Mecánica general')->first();

        // Trabajador de ejemplo
        $usuarioTrabajador = Usuario::create([
            'nombre' => 'Carlos Fernández',
            'correo' => 'trabajador@automaster.com',
            'contrasena' => Hash::make('password123'),
            'rol' => 'trabajador',
            'estado' => 'activo',
        ]);

        Trabajador::create([
            'usuario_id' => $usuarioTrabajador->id,
            'especialidad_id' => $especialidad->id,
            'ci' => '8451236',
            'telefono' => '70012345',
            'fecha_contratacion' => now()->subMonths(6),
            'estado' => 'activo',
        ]);

        // Cliente de ejemplo (con su propia cuenta de acceso)
        $usuarioCliente = Usuario::create([
            'nombre' => 'Juan Pérez Rojas',
            'correo' => 'cliente@automaster.com',
            'contrasena' => Hash::make('password123'),
            'rol' => 'cliente',
            'estado' => 'activo',
        ]);

        $cliente = Cliente::create([
            'usuario_id' => $usuarioCliente->id,
            'ci_nit' => '4521368',
            'telefono' => '70112233',
            'direccion' => 'Av. Banzer, Santa Cruz de la Sierra',
        ]);

        Vehiculo::create([
            'cliente_id' => $cliente->id,
            'placa' => '1234-ABC',
            'marca' => 'Toyota',
            'modelo' => 'Hilux',
            'anio' => '2019',
            'color' => 'Blanco',
            'kilometraje' => 45000,
        ]);
    }
}
