<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AutoMaster')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <!-- Fondo oscuro que aparece detras del menu cuando esta abierto en movil -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden"></div>

    <aside id="sidebar" class="w-64 bg-slate-900 text-slate-100 flex-shrink-0 flex flex-col fixed md:static inset-y-0 left-0 z-40 -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out">
        <div class="px-6 py-5 border-b border-slate-700 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-white">🔧 AutoMaster</h1>
                <p class="text-xs text-slate-400">Taller automotriz</p>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden text-slate-300 hover:text-white text-2xl leading-none px-1">&times;</button>
        </div>
        <nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto">
            <a href="{{ route('panel') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('panel') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Panel</a>

            @if(auth()->user()->isCliente())
                <p class="px-3 pt-4 pb-1 text-xs uppercase text-slate-500">Mi cuenta</p>
                <a href="{{ route('portal.vehiculo') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('portal.vehiculo') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Estado de mi vehículo</a>
                <a href="{{ route('portal.citas') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('portal.citas*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Reservar cita</a>
            @else
                <p class="px-3 pt-4 pb-1 text-xs uppercase text-slate-500">Operación</p>
                <a href="{{ route('ordenes_servicio.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('ordenes_servicio.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Órdenes de servicio</a>
                <a href="{{ route('talleres.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('talleres.index') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Buscar talleres (mapa)</a>

                @if(auth()->user()->isAdmin())
                <a href="{{ route('citas.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('citas.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Citas</a>

                <p class="px-3 pt-4 pb-1 text-xs uppercase text-slate-500">Clientes</p>
                <a href="{{ route('clientes.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('clientes.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Clientes y vehículos</a>

                <p class="px-3 pt-4 pb-1 text-xs uppercase text-slate-500">Personal</p>
                <a href="{{ route('trabajadores.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('trabajadores.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Trabajadores</a>
                <a href="{{ route('especialidades.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('especialidades.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Especialidades</a>

                <p class="px-3 pt-4 pb-1 text-xs uppercase text-slate-500">Taller</p>
                <a href="{{ route('inventario.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('inventario.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Inventario</a>
                <a href="{{ route('proveedores.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('proveedores.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Proveedores</a>
                <a href="{{ route('catalogo_servicios.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('catalogo_servicios.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Catálogo de servicios</a>
                <a href="{{ route('talleres.administrar') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('talleres.administrar') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Directorio de talleres</a>

                <p class="px-3 pt-4 pb-1 text-xs uppercase text-slate-500">Finanzas</p>
                <a href="{{ route('pagos.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('pagos.index') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Pagos</a>
                <a href="{{ route('reportes.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('reportes.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Reportes</a>
                <a href="{{ route('bitacora.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('bitacora.*') ? 'bg-slate-700 text-white' : 'text-slate-300' }}">Bitácora</a>
                @endif
            @endif
        </nav>
        <div class="px-4 py-4 border-t border-slate-700 text-sm">
            <p class="text-white font-medium">{{ auth()->user()->nombre }}</p>
            <p class="text-slate-400 text-xs capitalize mb-2">{{ auth()->user()->rol }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-400 hover:text-red-300 text-sm">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b px-4 md:px-8 py-4 flex items-center gap-3">
            <button onclick="toggleSidebar()" class="md:hidden text-slate-700 text-2xl leading-none px-1" aria-label="Abrir menú">☰</button>
            <h2 class="text-lg font-semibold text-gray-800">@yield('header', 'Panel')</h2>
        </header>

        <main class="flex-1 p-4 md:p-8 overflow-x-hidden">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('sidebarOverlay').classList.toggle('hidden');
}
</script>
</body>
</html>
