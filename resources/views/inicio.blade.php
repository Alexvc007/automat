<!-- resources/views/inicio.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoMaster - Taller Mecánico Especializado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Animaciones profesionales */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-15px) rotate(2deg);
            }
        }

        @keyframes floatSlow {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);
            }
            50% {
                box-shadow: 0 0 40px rgba(245, 158, 11, 0.4);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(60px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rotateSlow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes wave {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(10deg);
            }
            75% {
                transform: rotate(-10deg);
            }
        }

        /* Clases de animación */
        .animate-fadeInUp {
            animation: fadeInUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-fadeInDown {
            animation: fadeInDown 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-fadeInLeft {
            animation: fadeInLeft 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-fadeInRight {
            animation: fadeInRight 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        .animate-floatSlow {
            animation: floatSlow 5s ease-in-out infinite;
        }
        .animate-pulseGlow {
            animation: pulseGlow 3s ease-in-out infinite;
        }
        .animate-scaleIn {
            animation: scaleIn 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-slideUp {
            animation: slideUp 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-bounceIn {
            animation: bounceIn 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-wave {
            animation: wave 2s ease-in-out infinite;
        }

        /* Estilos profesionales */
        .gradient-bg {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0f172a, #1e293b);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
        }

        .shimmer-text {
            background: linear-gradient(90deg, #f59e0b, #f97316, #fbbf24, #f59e0b);
            background-size: 300% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 4s linear infinite;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .btn-gradient:hover::before {
            left: 100%;
        }

        .btn-gradient:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3);
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .service-card {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(245, 158, 11, 0.08);
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .service-card:hover {
            border-color: rgba(245, 158, 11, 0.3);
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }

        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .service-icon {
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #f59e0b, #f97316);
            transition: width 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .stat-number {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .testimonial-card {
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            border-color: rgba(245, 158, 11, 0.3);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 146, 60, 0.05));
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(135deg, #f59e0b, #f97316, #f59e0b);
            border-radius: inherit;
            z-index: -1;
            opacity: 0.3;
        }

        .image-hover-zoom {
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .image-hover-zoom img {
            transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .image-hover-zoom:hover img {
            transform: scale(1.05);
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }
        .delay-6 { animation-delay: 0.6s; }
        .delay-7 { animation-delay: 0.7s; }
        .delay-8 { animation-delay: 0.8s; }
        .delay-9 { animation-delay: 0.9s; }
        .delay-10 { animation-delay: 1s; }

        .glass-effect {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Scroll suave */
        html {
            scroll-behavior: smooth;
        }

        /* Estilo para imágenes */
        .img-shadow {
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
        }

        .floating-badge {
            animation: floatSlow 6s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/90 backdrop-blur-xl border-b border-slate-800/50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center gap-4 animate-fadeInLeft">
                    <div class="relative">
                        <img src="{{ asset('images/logo-automaster.png') }}" 
                             alt="AutoMaster Logo" 
                             class="h-14 w-auto object-contain">
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-amber-500 rounded-full animate-pulse"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold shimmer-text tracking-tight">AutoMaster</h1>
                        <p class="text-xs text-slate-400 font-medium tracking-wider">TALLER MECÁNICO ESPECIALIZADO</p>
                    </div>
                </div>

                <!-- Right side buttons -->
                <div class="flex items-center gap-3 animate-fadeInRight">
                    <a href="{{ url('/') }}" class="nav-link text-slate-300 hover:text-white px-4 py-2 text-sm font-medium transition-colors">
                        <i class="fas fa-home mr-2"></i> Inicio
                    </a>
                    <a href="{{ route('login') }}" class="btn-gradient text-white px-7 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 shadow-lg shadow-amber-500/20">
                        <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg min-h-screen flex items-center pt-20 relative overflow-hidden">
        <!-- Imagen de fondo -->
        <div class="absolute inset-0 opacity-5">
            <img src="{{ asset('images/fondo-taller.png') }}" alt="Fondo taller" class="w-full h-full object-cover">
        </div>

        <!-- Decoraciones flotantes -->
        <div class="absolute top-20 left-10 text-7xl opacity-5 animate-float">⚡</div>
        <div class="absolute bottom-20 right-10 text-7xl opacity-5 animate-float" style="animation-delay: 2s;">🔧</div>
        <div class="absolute top-1/2 left-1/4 text-5xl opacity-5 animate-float" style="animation-delay: 4s;">⚙️</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div class="animate-fadeInUp delay-1">
                        <span class="inline-flex items-center gap-2 bg-amber-500/10 text-amber-400 px-5 py-2 rounded-full text-sm font-semibold border border-amber-500/20 backdrop-blur-sm">
                            <i class="fas fa-wrench"></i> Taller Mecánico de Confianza
                        </span>
                    </div>

                    <h1 class="text-5xl lg:text-6xl xl:text-7xl font-extrabold text-white leading-tight animate-fadeInUp delay-2">
                        Reparación y<br>
                        <span class="shimmer-text">Mantenimiento</span><br>
                        de Excelencia
                    </h1>

                    <p class="text-lg text-slate-300 leading-relaxed max-w-lg animate-fadeInUp delay-3">
                        En AutoMaster ofrecemos servicios mecánicos de alta calidad con tecnología de punta 
                        y personal altamente capacitado para mantener tu vehículo en óptimas condiciones.
                    </p>

                    <div class="flex flex-wrap gap-4 animate-fadeInUp delay-4">
                        <a href="{{ route('login') }}" class="btn-gradient text-white px-9 py-4 rounded-full font-semibold text-base transition-all duration-300 shadow-xl shadow-amber-500/25 flex items-center gap-3">
                            <i class="fas fa-calendar-check"></i> Agendar Cita
                        </a>
                        <a href="#servicios" class="bg-white/5 backdrop-blur-sm text-white px-9 py-4 rounded-full font-semibold text-base border border-white/10 hover:bg-white/10 transition-all duration-300 flex items-center gap-3">
                            <i class="fas fa-play-circle"></i> Ver Servicios
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8 border-t border-white/5 animate-fadeInUp delay-5">
                        <div class="group cursor-pointer">
                            <div class="stat-number">15+</div>
                            <p class="text-slate-400 text-sm font-medium group-hover:text-amber-400 transition-colors">Años de Experiencia</p>
                        </div>
                        <div class="group cursor-pointer">
                            <div class="stat-number">5K+</div>
                            <p class="text-slate-400 text-sm font-medium group-hover:text-amber-400 transition-colors">Vehículos Reparados</p>
                        </div>
                        <div class="group cursor-pointer">
                            <div class="stat-number">4.9★</div>
                            <p class="text-slate-400 text-sm font-medium group-hover:text-amber-400 transition-colors">Calificación Promedio</p>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="relative animate-float">
                    <div class="gradient-border rounded-3xl p-6 bg-slate-800/50 backdrop-blur-sm">
                        <!-- Imagen principal del taller -->
                        <div class="image-hover-zoom rounded-2xl overflow-hidden">
                            <img src="{{ asset('images/taller-principal.png') }}" 
                                 alt="Taller AutoMaster" 
                                 class="w-full rounded-2xl img-shadow">
                        </div>

                        <!-- Grid de servicios -->
                        <div class="grid grid-cols-2 gap-3 mt-6">
                            <div class="group bg-slate-800/60 rounded-xl p-4 text-center hover:bg-slate-700/60 transition-all duration-300 cursor-pointer card-hover">
                                <img src="{{ asset('images/icon-mecanica.png') }}" 
                                     alt="Mecánica" 
                                     class="h-12 w-12 mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                <p class="text-white font-semibold text-sm">Mecánica General</p>
                                <p class="text-slate-400 text-xs">Motor y transmisión</p>
                            </div>
                            <div class="group bg-slate-800/60 rounded-xl p-4 text-center hover:bg-slate-700/60 transition-all duration-300 cursor-pointer card-hover">
                                <img src="{{ asset('images/icon-llanta.png') }}" 
                                     alt="Llantas" 
                                     class="h-12 w-12 mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                <p class="text-white font-semibold text-sm">Alineación y Balanceo</p>
                                <p class="text-slate-400 text-xs">Neumáticos y suspensión</p>
                            </div>
                            <div class="group bg-slate-800/60 rounded-xl p-4 text-center hover:bg-slate-700/60 transition-all duration-300 cursor-pointer card-hover">
                                <img src="{{ asset('images/icon-electricidad.png') }}" 
                                     alt="Electricidad" 
                                     class="h-12 w-12 mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                <p class="text-white font-semibold text-sm">Electricidad Automotriz</p>
                                <p class="text-slate-400 text-xs">Sistema eléctrico</p>
                            </div>
                            <div class="group bg-slate-800/60 rounded-xl p-4 text-center hover:bg-slate-700/60 transition-all duration-300 cursor-pointer card-hover">
                                <img src="{{ asset('images/icon-aceite.png') }}" 
                                     alt="Aceite" 
                                     class="h-12 w-12 mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                <p class="text-white font-semibold text-sm">Cambio de Aceite</p>
                                <p class="text-slate-400 text-xs">Lubricación y filtros</p>
                            </div>
                        </div>
                    </div>

                    <!-- Badge flotante -->
                    <div class="absolute -top-4 -right-4 bg-amber-500 text-slate-900 px-4 py-2 rounded-full text-sm font-bold shadow-2xl floating-badge">
                        <i class="fas fa-star mr-1"></i> +500 Clientes
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios Destacados -->
    <section id="servicios" class="py-24 bg-slate-800/50 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/50 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 bg-amber-500/10 text-amber-400 px-5 py-2 rounded-full text-sm font-semibold border border-amber-500/20 mb-4">
                    <i class="fas fa-tools"></i> Nuestros Servicios
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white">Soluciones Mecánicas <span class="shimmer-text">Completas</span></h2>
                <p class="text-slate-400 mt-4 max-w-2xl mx-auto text-lg">Ofrecemos una amplia gama de servicios para mantener tu vehículo en perfectas condiciones</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Servicio 1 -->
                <div class="service-card rounded-2xl p-8 animate-slideUp delay-1 group">
                    <div class="bg-amber-500/10 rounded-2xl w-20 h-20 flex items-center justify-center mb-5 group-hover:bg-amber-500/20 transition-all duration-300">
                        <img src="{{ asset('images/diagnostico.png') }}" 
                             alt="Diagnóstico" 
                             class="h-14 w-14 object-contain service-icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Diagnóstico Computarizado</h3>
                    <p class="text-slate-400 leading-relaxed">Identificamos fallas con tecnología de punta para reparaciones precisas y rápidas</p>
                    <div class="mt-5 flex items-center text-amber-400 text-sm font-medium">
                        <i class="fas fa-clock mr-2"></i> 30-60 minutos
                    </div>
                </div>

                <!-- Servicio 2 -->
                <div class="service-card rounded-2xl p-8 animate-slideUp delay-2 group">
                    <div class="bg-amber-500/10 rounded-2xl w-20 h-20 flex items-center justify-center mb-5 group-hover:bg-amber-500/20 transition-all duration-300">
                        <img src="{{ asset('images/motor.png') }}" 
                             alt="Motor" 
                             class="h-14 w-14 object-contain service-icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Reparación de Motor</h3>
                    <p class="text-slate-400 leading-relaxed">Reparación y reconstrucción de motores con piezas originales y garantía</p>
                    <div class="mt-5 flex items-center text-amber-400 text-sm font-medium">
                        <i class="fas fa-clock mr-2"></i> 2-5 días
                    </div>
                </div>

                <!-- Servicio 3 -->
                <div class="service-card rounded-2xl p-8 animate-slideUp delay-3 group">
                    <div class="bg-amber-500/10 rounded-2xl w-20 h-20 flex items-center justify-center mb-5 group-hover:bg-amber-500/20 transition-all duration-300">
                        <img src="{{ asset('images/suspension.png') }}" 
                             alt="Suspensión" 
                             class="h-14 w-14 object-contain service-icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Suspensión y Dirección</h3>
                    <p class="text-slate-400 leading-relaxed">Mantenimiento y reparación de sistemas de suspensión, amortiguadores y dirección</p>
                    <div class="mt-5 flex items-center text-amber-400 text-sm font-medium">
                        <i class="fas fa-clock mr-2"></i> 2-4 horas
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="py-24 bg-slate-900 relative">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-amber-500/20 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 bg-amber-500/10 text-amber-400 px-5 py-2 rounded-full text-sm font-semibold border border-amber-500/20 mb-4">
                    <i class="fas fa-quote-right"></i> Testimonios
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white">Lo que dicen <span class="shimmer-text">nuestros clientes</span></h2>
                <p class="text-slate-400 mt-4 max-w-2xl mx-auto text-lg">La opinión de quienes confían en nosotros es nuestra mejor carta de presentación</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonio 1 -->
                <div class="testimonial-card bg-slate-800/30 rounded-2xl p-8 border border-slate-700/30 animate-slideUp delay-1">
                    <div class="flex text-amber-400 mb-4 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-slate-300 leading-relaxed">"Excelente servicio, diagnosticaron y repararon mi auto en tiempo récord. Personal muy profesional y atento."</p>
                    <div class="mt-6 flex items-center gap-4">
                        <img src="{{ asset('images/clientes/cliente1.png') }}" 
                             alt="Juan Carlos" 
                             class="w-14 h-14 rounded-full object-cover border-2 border-amber-500/30">
                        <div>
                            <p class="text-white font-semibold">Juan Carlos</p>
                            <p class="text-slate-400 text-sm">Cliente satisfecho</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonio 2 -->
                <div class="testimonial-card bg-slate-800/30 rounded-2xl p-8 border border-slate-700/30 animate-slideUp delay-2">
                    <div class="flex text-amber-400 mb-4 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-slate-300 leading-relaxed">"El mejor taller al que he llevado mi vehículo. Transparentes en precios y trabajo de calidad impecable."</p>
                    <div class="mt-6 flex items-center gap-4">
                        <img src="{{ asset('images/clientes/cliente2.png') }}" 
                             alt="María Rodríguez" 
                             class="w-14 h-14 rounded-full object-cover border-2 border-amber-500/30">
                        <div>
                            <p class="text-white font-semibold">María Rodríguez</p>
                            <p class="text-slate-400 text-sm">Cliente frecuente</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonio 3 -->
                <div class="testimonial-card bg-slate-800/30 rounded-2xl p-8 border border-slate-700/30 animate-slideUp delay-3">
                    <div class="flex text-amber-400 mb-4 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-slate-300 leading-relaxed">"Muy contento con el servicio de cambio de aceite y revisión general. Lo recomiendo ampliamente a todos."</p>
                    <div class="mt-6 flex items-center gap-4">
                        <img src="{{ asset('images/clientes/cliente3.png') }}" 
                             alt="Pedro López" 
                             class="w-14 h-14 rounded-full object-cover border-2 border-amber-500/30">
                        <div>
                            <p class="text-white font-semibold">Pedro López</p>
                            <p class="text-slate-400 text-sm">Cliente recomendado</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-0 w-96 h-96 bg-amber-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-orange-500 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-4xl mx-auto text-center px-4 relative">
            <div class="animate-bounceIn">
                <div class="text-7xl mb-6 animate-float">🔧</div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6">¿Necesitas reparar tu vehículo?</h2>
                <p class="text-xl text-slate-300 mb-10 max-w-2xl mx-auto">Agenda tu cita hoy y recibe atención personalizada de nuestros expertos mecánicos</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}" class="btn-gradient text-white px-12 py-4 rounded-full font-bold text-lg inline-flex items-center justify-center gap-3 transition-all duration-300 shadow-2xl shadow-amber-500/30">
                        <i class="fas fa-calendar-plus"></i> Agendar Cita
                    </a>
                    <a href="#" class="bg-white/5 backdrop-blur-sm text-white px-12 py-4 rounded-full font-bold text-lg border border-white/10 hover:bg-white/10 transition-all duration-300 inline-flex items-center justify-center gap-3">
                        <i class="fas fa-phone"></i> Llamar Ahora
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800/50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo-automaster.png') }}" alt="AutoMaster" class="h-10 w-auto">
                        <span class="text-xl font-extrabold shimmer-text">AutoMaster</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">Taller mecánico especializado con más de 15 años de experiencia en el mercado automotriz.</p>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="text-slate-400 hover:text-amber-400 transition-all duration-300 hover:scale-110"><i class="fab fa-facebook-f text-lg"></i></a>
                        <a href="#" class="text-slate-400 hover:text-amber-400 transition-all duration-300 hover:scale-110"><i class="fab fa-instagram text-lg"></i></a>
                        <a href="#" class="text-slate-400 hover:text-amber-400 transition-all duration-300 hover:scale-110"><i class="fab fa-whatsapp text-lg"></i></a>
                        <a href="#" class="text-slate-400 hover:text-amber-400 transition-all duration-300 hover:scale-110"><i class="fab fa-youtube text-lg"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Servicios</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-slate-400 hover:text-amber-400 transition-colors">Mecánica General</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-amber-400 transition-colors">Diagnóstico Computarizado</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-amber-400 transition-colors">Reparación de Motor</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-amber-400 transition-colors">Electricidad Automotriz</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-amber-400 transition-colors">Frenos y Seguridad</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Horario</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><span class="text-white font-medium">Lun - Vie:</span> 8:00 - 18:00</li>
                        <li><span class="text-white font-medium">Sábado:</span> 8:00 - 13:00</li>
                        <li><span class="text-white font-medium">Domingo:</span> Cerrado</li>
                        <li class="pt-2"><span class="text-amber-400 text-lg">📞</span> <span class="text-white">Emergencias 24/7</span></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Contacto</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3 text-slate-400">
                            <i class="fas fa-map-marker-alt text-amber-400 mt-1"></i>
                            <span>Av. Principal #123, Santa Cruz, Bolivia</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-400">
                            <i class="fas fa-phone text-amber-400"></i>
                            <span>+591 3 1234567</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-400">
                            <i class="fas fa-envelope text-amber-400"></i>
                            <span>info@automaster.com</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-400">
                            <i class="fab fa-whatsapp text-amber-400"></i>
                            <span>+591 71234567</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800/50 mt-12 pt-8 text-center text-sm text-slate-500">
                <p>&copy; 2026 <span class="text-amber-400 font-semibold">AutoMaster</span> - Taller Mecánico. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>