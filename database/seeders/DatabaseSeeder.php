<?php

namespace Database\Seeders;

use App\Models\CatalogoServicio;
use App\Models\Especialidad;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador por defecto
        Usuario::create([
            'nombre' => 'Administrador AutoMaster',
            'correo' => 'admin@automaster.com',
            'contrasena' => Hash::make('password123'),
            'rol' => 'admin',
            'estado' => 'activo',
        ]);

        // Especialidades base
        $especialidades = [
            'Mecánica general',
            'Electricista automotriz',
            'Pintura y latonería',
            'Diagnóstico computarizado',
            'Frenos y suspensión',
            'Aire acondicionado',
            'Transmisión y caja de cambios',
            'Llantas y alineación',
        ];
        foreach ($especialidades as $nombre) {
            Especialidad::create(['nombre' => $nombre]);
        }

        // Catálogo de servicios base
        $servicios = [
            ['nombre' => 'Cambio de aceite de motor', 'precio_base' => 120, 'minutos_estimados' => 30],
            ['nombre' => 'Alineación y balanceo', 'precio_base' => 150, 'minutos_estimados' => 45],
            ['nombre' => 'Cambio de pastillas de freno', 'precio_base' => 200, 'minutos_estimados' => 60],
            ['nombre' => 'Diagnóstico computarizado', 'precio_base' => 100, 'minutos_estimados' => 40],
            ['nombre' => 'Cambio de batería', 'precio_base' => 50, 'minutos_estimados' => 15],
            ['nombre' => 'Revisión de aire acondicionado', 'precio_base' => 130, 'minutos_estimados' => 50],
            ['nombre' => 'Cambio de correa de distribución', 'precio_base' => 350, 'minutos_estimados' => 120],
            ['nombre' => 'Afinamiento general del motor', 'precio_base' => 280, 'minutos_estimados' => 90],
        ];
        foreach ($servicios as $s) {
            CatalogoServicio::create($s);
        }

        // Ítems de inventario base
        \App\Models\ItemInventario::insert([
            ['nombre' => 'Aceite de motor 20W-50 (1L)', 'categoria' => 'Lubricantes', 'unidad' => 'litro', 'stock' => 40, 'stock_minimo' => 10, 'precio_unitario' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Batería 12V 60Ah', 'categoria' => 'Eléctrico', 'unidad' => 'unidad', 'stock' => 8, 'stock_minimo' => 3, 'precio_unitario' => 550, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pastillas de freno delanteras', 'categoria' => 'Frenos', 'unidad' => 'juego', 'stock' => 15, 'stock_minimo' => 5, 'precio_unitario' => 180, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Filtro de aceite', 'categoria' => 'Filtros', 'unidad' => 'unidad', 'stock' => 30, 'stock_minimo' => 8, 'precio_unitario' => 35, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Filtro de aire', 'categoria' => 'Filtros', 'unidad' => 'unidad', 'stock' => 25, 'stock_minimo' => 8, 'precio_unitario' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Refrigerante (1L)', 'categoria' => 'Líquidos', 'unidad' => 'litro', 'stock' => 20, 'stock_minimo' => 5, 'precio_unitario' => 30, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->call([DatosDemoSeeder::class, TallerSeeder::class]);
    }
}
