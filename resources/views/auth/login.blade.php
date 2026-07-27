<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - AutoMaster</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-sm w-full bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-900">🔧 AutoMaster</h1>
            <p class="text-sm text-gray-500 mt-1">Sistema de gestión del taller</p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" name="correo" value="{{ old('correo') }}" required autofocus
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="contrasena" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="recordar"> Recordarme
            </label>
            <button type="submit" class="w-full bg-slate-900 text-white rounded-lg py-2.5 font-medium hover:bg-slate-800 transition">
                Iniciar sesión
            </button>
        </form>

        <div class="mt-6 text-xs text-gray-400 border-t pt-4">
            <p>Demo admin: admin@automaster.com / password123</p>
            <p>Demo trabajador: trabajador@automaster.com / password123</p>
        </div>
    </div>
</body>
</html>
