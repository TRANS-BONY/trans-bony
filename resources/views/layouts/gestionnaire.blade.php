<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TRANS BONY - Gestionnaire</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {}
        }
    }
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    * { font-family: 'Inter', sans-serif; }

    .nav-item {
        transition: all 0.2s ease;
        border-radius: 0.75rem;
    }
    .nav-item:hover {
        transform: translateX(4px);
        background: rgba(20, 184, 166, 0.15);
    }
    .nav-item.active {
        background: rgba(20, 184, 166, 0.25);
        border-left: 4px solid #14b8a6;
    }
</style>
</head>

<body x-data="{ sidebarOpen: false, isDarkMode: false }" :class="{'dark': isDarkMode}" class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white">

<div class="flex min-h-screen">

    <!-- ═══════════ SIDEBAR ═══════════ -->
    <div
        class="fixed inset-y-0 left-0 z-30 w-72 bg-gradient-to-br from-teal-900 to-emerald-950 shadow-2xl transform transition-transform duration-300 lg:relative lg:translate-x-0"
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

        <div class="p-6">
            <div class="flex items-center space-x-3 mb-10">
                <div class="w-10 h-10 rounded-xl bg-teal-400 flex items-center justify-center shadow-lg">
                    <i class="fas fa-tasks text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">TRANS BONY</h2>
                    <p class="text-xs text-teal-300">Espace Gestionnaire</p>
                </div>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('gestionnaire.dashboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="text-sm font-medium">Tableau de bord</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[10px] uppercase tracking-widest text-teal-400/60 font-bold">Gestion Active</p>
                </div>

                <a href="{{ route('gestionnaire.vehicules.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group">
                    <i class="fas fa-bus w-5 text-blue-400"></i>
                    <span class="text-sm font-medium">Véhicules</span>
                </a>

                <a href="{{ route('gestionnaire.chauffeurs.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group">
                    <i class="fas fa-id-card w-5 text-yellow-400"></i>
                    <span class="text-sm font-medium">Chauffeurs</span>
                </a>

                <a href="{{ route('gestionnaire.documents.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group">
                    <i class="fas fa-file-alt w-5 text-emerald-400"></i>
                    <span class="text-sm font-medium">Documents</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[10px] uppercase tracking-widest text-teal-400/60 font-bold">Consultation</p>
                </div>

                <a href="{{ route('gestionnaire.maintenances.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group">
                    <i class="fas fa-tools w-5 text-orange-400"></i>
                    <span class="text-sm font-medium">Maintenances</span>
                </a>
            </nav>
        </div>

        <div class="absolute bottom-0 w-full p-6 border-t border-teal-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 text-teal-300 hover:text-white transition w-full text-left">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="text-sm font-medium">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>

    <!-- ═══════════ MAIN CONTENT ═══════════ -->
    <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
        <header class="bg-white dark:bg-gray-800 shadow-sm px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-gray-500">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">@yield('title', 'Gestionnaire')</h1>
            </div>

            <div class="flex items-center gap-4">
                <button @click="isDarkMode = !isDarkMode" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500">
                    <i :class="isDarkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-teal-500 flex items-center justify-center text-white text-xs font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 hidden md:block">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    // Highlight active link
    document.addEventListener('DOMContentLoaded', () => {
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-item').forEach(link => {
            if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href'))) {
                link.classList.add('active');
            }
        });
    });
</script>
</body>
</html>
