<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TRANS BONY - Espace Manager</title>

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
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    .floating { animation: floating 4s ease-in-out infinite; }
    .floating-fast { animation: floating 2.5s ease-in-out infinite; }
    .floating-slow { animation: floating 6s ease-in-out infinite; }
    .nav-fluid-hover { transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    * { font-family: 'Inter', sans-serif; }

    .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

    .nav-item {
        transition: all 0.2s ease;
        position: relative;
        border-radius: 0.75rem;
    }
    .nav-item:hover {
        transform: translateX(4px);
        background: rgba(255, 255, 255, 0.12);
    }
    .nav-item.active {
        background: rgba(139, 92, 246, 0.25);
        border-left: 3px solid #8b5cf6;
    }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.4); }

    .dark ::-webkit-scrollbar-track { background: #1f2937; }
    .dark ::-webkit-scrollbar-thumb { background: #374151; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulse-soft {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .animate-fadeInUp  { animation: fadeInUp 0.5s ease-out forwards; }
    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-pulse-soft { animation: pulse-soft 2s ease-in-out infinite; }

    * {
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    input:focus, select:focus, textarea:focus {
        transform: scale(1.01);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }

    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15);
    }
</style>
</head>

<body x-data="managerApp()" :class="{'dark': isDarkMode}" class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white">

<div class="flex min-h-screen">

    <!-- ═══════════ SIDEBAR ═══════════ -->
    <div
        class="fixed inset-y-0 left-0 z-30 w-72 bg-gradient-to-br from-indigo-900 via-purple-900 to-indigo-950 dark:from-gray-900 dark:to-black shadow-2xl transform transition-all duration-300 ease-in-out lg:relative lg:translate-x-0 overflow-y-auto flex flex-col"
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

        <div class="p-6 flex-1">
            <!-- Logo -->
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-pie text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">TRANS BONY</h2>
                        <p class="text-xs text-purple-300 font-medium">Espace Manager</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white/60 hover:text-white transition p-1" @mouseenter="$el.classList.add('floating-fast', 'scale-105')" @mouseleave="$el.classList.remove('floating-fast', 'scale-105')">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- User card -->
            <div class="mb-8 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center shadow-md flex-shrink-0">
                        <i class="fas fa-user-tie text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-purple-500/30 text-purple-300 text-xs font-medium mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse-soft"></span>
                            Manager
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="space-y-1">
                <p class="text-xs uppercase tracking-widest text-purple-400/70 mb-4 font-semibold px-1">
                    Vue d'ensemble
                </p>

                <!-- Dashboard -->
                <a href="{{ route('manager.dashboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-tachometer-alt text-sm text-purple-300"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Tableau de bord</span>
                </a>

                <!-- Séparateur -->
                <div class="pt-4 pb-2">
                    <p class="text-xs uppercase tracking-widest text-purple-400/60 font-semibold px-1">Consultation Modules</p>
                </div>

                <a href="{{ route('manager.voyages.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-route text-sm text-orange-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Voyages</span>
                </a>
                
                <a href="{{ route('manager.vehicules.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-bus text-sm text-blue-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Véhicules</span>
                </a>

                <a href="{{ route('manager.chauffeurs.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-id-card text-sm text-yellow-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Chauffeurs</span>
                </a>

                <a href="{{ route('manager.maintenances.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-tools text-sm text-amber-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Maintenances</span>
                </a>

                <a href="{{ route('manager.recettes.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-coins text-sm text-green-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Finances & Recettes</span>
                </a>

                <a href="{{ route('manager.documents.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-file-alt text-sm text-red-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Documents</span>
                </a>

                <a href="{{ route('manager.rapports.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-chart-line text-sm text-emerald-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Rapports</span>
                </a>

                <a href="{{ route('manager.audits.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-history text-sm text-cyan-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Audits</span>
                </a>

                <a href="{{ route('manager.users.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? 'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast' : ''">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-purple-500/30 transition-all">
                        <i class="fas fa-users text-sm text-indigo-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Utilisateurs</span>
                </a>

            </div>
        </div>

        <!-- Pied de sidebar -->
        <div class="p-6 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-red-300 hover:text-red-200 hover:bg-red-500/20 transition-all group">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                    <span class="text-sm font-medium">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Overlay mobile -->
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 z-20 lg:hidden backdrop-blur-sm">
    </div>

    <!-- ═══════════ CONTENU PRINCIPAL ═══════════ -->
    <div class="flex-1 flex flex-col min-h-screen overflow-hidden">

        <!-- TOPBAR -->
        <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-10 border-b border-gray-100 dark:border-gray-700">
            <div class="px-4 sm:px-6 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 dark:text-gray-400 hover:text-purple-600 transition p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl" @mouseenter="$el.classList.add('floating-fast', 'scale-105')" @mouseleave="$el.classList.remove('floating-fast', 'scale-105')">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-indigo-500 to-purple-600 bg-clip-text text-transparent" x-text="pageTitle">Tableau de bord</h1>
                        <p class="text-xs text-gray-400 hidden sm:block">{{ now()->isoFormat('dddd D MMMM YYYY') }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2 sm:space-x-3">
                    <!-- Dark mode -->
                    <button @click="toggleTheme" class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition" @mouseenter="$el.classList.add('floating-fast', 'scale-105')" @mouseleave="$el.classList.remove('floating-fast', 'scale-105')">
                        <i x-show="!isDarkMode" class="fas fa-moon text-gray-500 dark:text-gray-400 text-lg"></i>
                        <i x-show="isDarkMode" class="fas fa-sun text-yellow-400 text-lg"></i>
                    </button>

                    <!-- Profil -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition" @mouseenter="$el.classList.add('floating-fast', 'scale-105')" @mouseleave="$el.classList.remove('floating-fast', 'scale-105')">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                                <i class="fas fa-user-tie text-white text-xs"></i>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Manager</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400 hidden md:block"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 z-50 overflow-hidden">
                            <div class="p-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition">
                                    <i class="fas fa-user-circle text-purple-500 w-4"></i> Mon profil
                                </a>
                                <hr class="my-1 border-gray-100 dark:border-gray-700">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition">
                                        <i class="fas fa-sign-out-alt w-4"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ALERTS -->
        <div class="px-4 sm:px-6 pt-4">
            @if(session('success'))
                <div class="mb-4 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" style="display:block">
                    <i class="fas fa-check-circle text-emerald-500 flex-shrink-0"></i>
                    <span class="flex-1 font-medium text-sm">{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 text-lg font-bold">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" style="display:block">
                    <i class="fas fa-exclamation-circle text-red-500 flex-shrink-0"></i>
                    <span class="flex-1 font-medium text-sm">{{ session('error') }}</span>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 text-lg font-bold">&times;</button>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" style="display:block">
                    <i class="fas fa-exclamation-circle text-red-500 flex-shrink-0 mt-0.5"></i>
                    <ul class="flex-1 list-disc list-inside text-sm font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 text-lg font-bold">&times;</button>
                </div>
            @endif
        </div>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="px-6 py-3 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
            <p class="text-xs text-gray-400 text-center">TRANS BONY &copy; {{ date('Y') }} — Espace Manager</p>
        </footer>
    </div>
</div>

<script>
function managerApp() {
    return {
        sidebarOpen: false,
        isDarkMode: false,
        pageTitle: 'Tableau de bord',

        init() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                this.isDarkMode = true;
                document.documentElement.classList.add('dark');
            }

            // Active nav
            const path = window.location.pathname;
            document.querySelectorAll('.nav-item').forEach(item => {
                const href = item.getAttribute('href');
                if (href && ((href === '/manager/dashboard' && path === href) || (href !== '/manager/dashboard' && path.startsWith(href)))) {
                    item.classList.add('active');
                    const span = item.querySelector('span.flex-1');
                    if (span) {
                        this.pageTitle = span.innerText;
                        document.title = 'TRANS BONY - ' + this.pageTitle;
                    }
                }
            });

            // Close sidebar on mobile nav click
            document.querySelectorAll('.nav-item').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) this.sidebarOpen = false;
                });
            });
        },

        toggleTheme() {
            this.isDarkMode = !this.isDarkMode;
            if (this.isDarkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    };
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card-hover').forEach((card, i) => {
        card.style.animationDelay = `${i * 0.08}s`;
        card.classList.add('animate-fadeInUp');
    });
});
</script>
</body>
</html>
