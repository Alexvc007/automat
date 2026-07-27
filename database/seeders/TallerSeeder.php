<?php

namespace Database\Seeders;

use App\Models\Taller;
use Illuminate\Database\Seeder;

class TallerSeeder extends Seeder
{
    /**
     * Talleres de ejemplo en Santa Cruz de la Sierra para probar el buscador con mapa.
     */
    public function run(): void
    {
        $talleres = [
            ['nombre' => 'AutoMaster', 'direccion' => 'Av. Banzer, 4to anillo', 'latitud' => -17.7599, 'longitud' => -63.1936, 'telefono' => '70011122'],
            ['nombre' => 'Taller Mecánico El Rápido', 'direccion' => 'Av. Cristo Redentor, 3er anillo', 'latitud' => -17.7726, 'longitud' => -63.1963, 'telefono' => '70022233'],
            ['nombre' => 'Servicio Automotriz Santa Cruz', 'direccion' => 'Av. Grigotá, 2do anillo', 'latitud' => -17.8021, 'longitud' => -63.1857, 'telefono' => '70033344'],
            ['nombre' => 'Taller Los Motores', 'direccion' => 'Av. Beni, 6to anillo', 'latitud' => -17.7442, 'longitud' => -63.1682, 'telefono' => '70044455'],
            ['nombre' => 'Mecánica Express SRL', 'direccion' => 'Av. Alemana, entre 3er y 4to anillo', 'latitud' => -17.7685, 'longitud' => -63.1795, 'telefono' => '70055566'],
        ];

        foreach ($talleres as $t) {
            Taller::create($t);
        }
    }
}
