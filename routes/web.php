<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\CatalogoServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PortalClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('panel') : redirect('/login');
});

// Autenticación
Route::get('/login', [AutenticacionController::class, 'mostrarLogin'])->name('login')->middleware('guest');
Route::post('/login', [AutenticacionController::class, 'login'])->middleware(['guest', 'throttle:6,1']);
Route::post('/logout', [AutenticacionController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/panel', [PanelController::class, 'index'])->name('panel');

    // Módulos compartidos SOLO entre admin y trabajador (el cliente no entra aquí)
    Route::middleware('rol:admin,trabajador')->group(function () {
        Route::get('/vehiculos/buscar', [VehiculoController::class, 'buscar'])->name('vehiculos.buscar');

        Route::get('/ordenes-servicio', [OrdenServicioController::class, 'index'])->name('ordenes_servicio.index');
        Route::get('/ordenes-servicio/{ordenServicio}', [OrdenServicioController::class, 'show'])->name('ordenes_servicio.show');
        Route::patch('/ordenes-servicio/{ordenServicio}/estado', [OrdenServicioController::class, 'actualizarEstado'])->name('ordenes_servicio.estado');

        Route::get('/talleres', [TallerController::class, 'index'])->name('talleres.index');
        Route::get('/talleres/buscar', [TallerController::class, 'buscar'])->name('talleres.buscar');
    });

    // --- SOLO CLIENTE: sus dos únicos módulos ---
    Route::middleware('rol:cliente')->group(function () {
        Route::get('/portal/vehiculo', [PortalClienteController::class, 'estadoVehiculo'])->name('portal.vehiculo');
        Route::get('/portal/citas', [PortalClienteController::class, 'citas'])->name('portal.citas');
        Route::post('/portal/citas', [PortalClienteController::class, 'guardarCita'])->name('portal.citas.store');
    });

    // --- SOLO ADMINISTRADOR ---
    Route::middleware('rol:admin')->group(function () {

        // Administración del directorio de talleres
        Route::get('/talleres-administrar', [TallerController::class, 'administrar'])->name('talleres.administrar');
        Route::post('/talleres', [TallerController::class, 'store'])->name('talleres.store');
        Route::get('/talleres/{taller}/editar', [TallerController::class, 'edit'])->name('talleres.edit');
        Route::put('/talleres/{taller}', [TallerController::class, 'update'])->name('talleres.update');
        Route::delete('/talleres/{taller}', [TallerController::class, 'destroy'])->name('talleres.destroy');

        // Trabajadores
        Route::get('/trabajadores', [TrabajadorController::class, 'index'])->name('trabajadores.index');
        Route::get('/trabajadores/crear', [TrabajadorController::class, 'create'])->name('trabajadores.create');
        Route::post('/trabajadores', [TrabajadorController::class, 'store'])->name('trabajadores.store');
        Route::get('/trabajadores/{trabajador}/editar', [TrabajadorController::class, 'edit'])->name('trabajadores.edit');
        Route::put('/trabajadores/{trabajador}', [TrabajadorController::class, 'update'])->name('trabajadores.update');
        Route::patch('/trabajadores/{trabajador}/estado', [TrabajadorController::class, 'toggleEstado'])->name('trabajadores.toggle');

        // Especialidades
        Route::get('/especialidades', [EspecialidadController::class, 'index'])->name('especialidades.index');
        Route::post('/especialidades', [EspecialidadController::class, 'store'])->name('especialidades.store');
        Route::put('/especialidades/{especialidad}', [EspecialidadController::class, 'update'])->name('especialidades.update');
        Route::delete('/especialidades/{especialidad}', [EspecialidadController::class, 'destroy'])->name('especialidades.destroy');

        // Clientes
        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
        Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::patch('/clientes/{cliente}/estado', [ClienteController::class, 'toggleEstado'])->name('clientes.toggle');
        Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

        // Vehículos (anidados a cliente)
        Route::get('/clientes/{cliente}/vehiculos/crear', [VehiculoController::class, 'create'])->name('vehiculos.create');
        Route::post('/clientes/{cliente}/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
        Route::get('/vehiculos/{vehiculo}/editar', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
        Route::put('/vehiculos/{vehiculo}', [VehiculoController::class, 'update'])->name('vehiculos.update');
        Route::delete('/vehiculos/{vehiculo}', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');

        // Nueva orden de servicio y asignación de trabajador
        Route::get('/ordenes-servicio-crear', [OrdenServicioController::class, 'create'])->name('ordenes_servicio.create');
        Route::post('/ordenes-servicio', [OrdenServicioController::class, 'store'])->name('ordenes_servicio.store');
        Route::patch('/ordenes-servicio/{ordenServicio}/asignar', [OrdenServicioController::class, 'asignarTrabajador'])->name('ordenes_servicio.asignar');

        // Inventario
        Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
        Route::get('/inventario/crear', [InventarioController::class, 'create'])->name('inventario.create');
        Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');
        Route::get('/inventario/{itemInventario}/editar', [InventarioController::class, 'edit'])->name('inventario.edit');
        Route::put('/inventario/{itemInventario}', [InventarioController::class, 'update'])->name('inventario.update');
        Route::delete('/inventario/{itemInventario}', [InventarioController::class, 'destroy'])->name('inventario.destroy');

        // Proveedores
        Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
        Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');
        Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update');
        Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');

        // Catálogo de servicios
        Route::get('/catalogo-servicios', [CatalogoServicioController::class, 'index'])->name('catalogo_servicios.index');
        Route::post('/catalogo-servicios', [CatalogoServicioController::class, 'store'])->name('catalogo_servicios.store');
        Route::put('/catalogo-servicios/{catalogoServicio}', [CatalogoServicioController::class, 'update'])->name('catalogo_servicios.update');
        Route::delete('/catalogo-servicios/{catalogoServicio}', [CatalogoServicioController::class, 'destroy'])->name('catalogo_servicios.destroy');

        // Citas
        Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
        Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
        Route::patch('/citas/{cita}/estado', [CitaController::class, 'actualizarEstado'])->name('citas.estado');

        // Pagos (listado general) y reportes
        Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    });

    // Registrar pago en una orden: accesible para admin y para el trabajador asignado
    Route::post('/ordenes-servicio/{ordenServicio}/pagos', [PagoController::class, 'store'])
        ->name('pagos.store')
        ->middleware('rol:admin,trabajador');
});
