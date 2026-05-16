<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TRANS BONY - Espace Comptable</title>

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

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style> @keyframes floating { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } } .floating { animation: floating 4s ease-in-out infinite; } .floating-fast { animation: floating 2.5s ease-in-out infinite; } .floating-slow { animation: floating 6s ease-in-out infinite; } .floating-hover { transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); } .floating-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    /* Transitions personnalisées */
    .sidebar-transition {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .nav-item {
        transition: all 0.2s ease;
        position: relative;
    }

    .nav-item:hover {
        transform: translateX(5px);
        background: rgba(255, 255, 255, 0.1);
    }

    .nav-item.active {
        background: rgba(59, 130, 246, 0.2);
        border-left: 3px solid #3b82f6;
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }

    .notification-badge { animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }

    /* Scrollbar personnalisée */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #2563eb; }

    .dark ::-webkit-scrollbar-track { background: #1f2937; }
    .dark ::-webkit-scrollbar-thumb { background: #3b82f6; }

    /* Input styles */
    input, select, textarea { transition: all 0.2s ease; }
    input:focus, select:focus, textarea:focus { transform: scale(1.02); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.5s ease-out forwards; }
</style>
</head>

<body x-data="app()" :class="{'dark': isDarkMode}" class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <div
            class="fixed inset-y-0 left-0 z-30 w-72 bg-gradient-to-br from-blue-900 to-indigo-900 dark:from-gray-800 dark:to-gray-900 shadow-2xl transform transition-all duration-300 ease-in-out lg:relative lg:translate-x-0 overflow-y-auto"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-bus text-2xl text-blue-400 animate-pulse"></i>
                        <div>
                            <h2 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">TRANS BONY</h2>
                            <p class="text-xs text-blue-300 dark:text-gray-400 mt-1">Espace Comptable</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-300 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-white/40 mb-4 font-bold px-1">Menu Principal</p>

                    <a href="{{ route('comptable.dashboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group" :class="currentPageTitle === 'Tableau de bord' ? 'active' : ''">
                        <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20 group-hover:bg-blue-500/20 transition-all duration-300">
                            <i class="fas fa-th-large text-sm"></i>
                        </div>
                        <span class="flex-1 text-sm font-semibold tracking-wide">Tableau de bord</span>
                    </a>

                    <div class="pt-6 pb-2">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-white/40 font-bold px-1">Finance & Analyse</p>
                    </div>

                    <a href="{{ route('comptable.recettes.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group" :class="currentPageTitle === 'Recettes' ? 'active' : ''">
                        <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 group-hover:bg-emerald-500/20 transition-all duration-300 shadow-sm">
                            <i class="fas fa-wallet text-sm"></i>
                        </div>
                        <span class="flex-1 text-sm font-medium">Recettes & Finances</span>
                    </a>

                    <a href="{{ route('comptable.rapports.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group" :class="currentPageTitle === 'Rapports' ? 'active' : ''">
                        <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 group-hover:bg-indigo-500/20 transition-all duration-300 shadow-sm">
                            <i class="fas fa-chart-pie text-sm"></i>
                        </div>
                        <span class="flex-1 text-sm font-medium">Rapports d'Activité</span>
                    </a>

                    <!-- Déconnexion -->
                    <div class="pt-8 mt-4 border-t border-white/10">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-compta">
                            @csrf
                            <button type="submit" class="w-full nav-item flex items-center space-x-3 px-4 py-3 text-red-400 hover:text-red-300 group transition cursor-pointer">
                                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 group-hover:bg-red-500/30 transition-all border border-red-500/20">
                                    <i class="fas fa-power-off text-sm"></i>
                                </div>
                                <span class="flex-1 text-sm font-medium text-left">Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay pour mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-20 lg:hidden" x-transition></div>

        <!-- CONTENT PRINCIPAL -->
        <div class="flex-1 flex flex-col min-w-0 bg-gray-100 dark:bg-gray-900">
            <!-- NAVBAR -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-100 dark:border-gray-700 z-10 shrink-0">
                <div class="px-4 sm:px-6 py-3 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-blue-600 transition p-2">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white" x-text="currentPageTitle">Tableau de bord</h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 hidden sm:block">Espace Comptable • {{ auth()->user()->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button @click="toggleTheme" class="p-2 rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 hover:bg-gray-100 transition shadow-sm border border-gray-100 dark:border-gray-600">
                            <i x-show="!isDarkMode" class="fas fa-moon"></i>
                            <i x-show="isDarkMode" class="fas fa-sun text-yellow-400"></i>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div class="relative" x-data="{ open: false, notifications: [], count: 0 }" x-init="
                            const fetchNotifications = () => {
                                fetch('/notifications')
                                    .then(res => res.json())
                                    .then(data => {
                                        notifications = data.items;
                                        count = data.count;
                                    });
                            };
                            fetchNotifications();
                            setInterval(fetchNotifications, 30000);
                        ">
                            <button @click="open = !open" class="p-2 rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 hover:bg-gray-100 transition shadow-sm border border-gray-100 dark:border-gray-600 relative">
                                <i class="fas fa-bell"></i>
                                <template x-if="count > 0">
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white dark:border-gray-800" x-text="count"></span>
                                </template>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50">
                                <div class="p-4 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Notifications</h3>
                                    <template x-if="count > 0">
                                        <button @click="
                                            fetch('{{ url('/notifications/mark-as-read') }}', {
                                                method: 'POST',
                                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                            }).then(() => {
                                                notifications = [];
                                                count = 0;
                                            })
                                        " class="text-[10px] font-bold text-blue-600 dark:text-blue-400 hover:underline">Tout marquer comme lu</button>
                                    </template>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <template x-if="notifications.length === 0">
                                        <div class="p-8 text-center">
                                            <div class="w-12 h-12 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300 dark:text-gray-600">
                                                <i class="fas fa-bell-slash"></i>
                                            </div>
                                            <p class="text-xs text-gray-400 font-medium">Aucune nouvelle notification</p>
                                        </div>
                                    </template>
                                    <template x-for="n in notifications" :key="n.id">
                                        <a :href="'{{ url('/notifications') }}/' + n.id + '/read'" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-900/30 transition-colors border-b border-gray-50 dark:border-gray-700 last:border-0">
                                            <div class="flex gap-3">
                                                <div :class="{
                                                    'w-8 h-8 rounded-lg flex items-center justify-center shrink-0': true,
                                                    'bg-blue-100 text-blue-600': n.type === 'info',
                                                    'bg-amber-100 text-amber-600': n.type === 'warning',
                                                    'bg-red-100 text-red-600': n.type === 'error'
                                                }">
                                                    <i :class="n.icon || 'fas fa-info-circle'" class="text-xs"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-2" x-text="n.message"></p>
                                                    <p class="text-[10px] text-gray-400 mt-1 font-medium" x-text="n.time"></p>
                                                </div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-3 p-1 pr-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600 hover:bg-gray-100 transition shadow-sm">
                                <div class="w-8 h-8 rounded-lg overflow-hidden border-2 border-white dark:border-gray-600 shadow-sm">
                                    <img src="{{ auth()->user()->profile_photo_url }}" alt="" class="w-full h-full object-cover">
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-xs font-bold text-gray-900 dark:text-white leading-tight">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400">Comptable</p>
                                </div>
                                <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50">
                                <div class="p-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 rounded-xl transition">
                                        <i class="fas fa-user-circle opacity-50"></i> Mon profil
                                    </a>
                                    <hr class="my-1 border-gray-100 dark:border-gray-700">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition">
                                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- MAIN CONTENT -->
            <main class="flex-1 overflow-hidden">
                <div class="h-full p-4 sm:p-6 overflow-y-auto custom-scrollbar-main">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-between shadow-sm" x-data="{ show: true }" x-show="show">
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">&times;</button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <style>
        .custom-scrollbar-main::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar-main::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar-main::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.05); border-radius: 10px; }
        .dark .custom-scrollbar-main::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); }
    </style>

    <script>
        function app() {
            return {
                sidebarOpen: false,
                isDarkMode: false,
                currentPageTitle: 'Tableau de bord',

                init() {
                    const currentPath = window.location.pathname;
                    const navItems = document.querySelectorAll('.nav-item');
                    
                    navItems.forEach(item => {
                        const itemHref = item.getAttribute('href');
                        if (itemHref && (currentPath === itemHref || (itemHref !== '/' && currentPath.startsWith(itemHref)))) {
                            const titleSpan = item.querySelector('span.flex-1');
                            if (titleSpan) {
                                this.currentPageTitle = titleSpan.innerText;
                                document.title = 'TRANS BONY - ' + this.currentPageTitle;
                            }
                        }
                    });

                    const savedTheme = localStorage.getItem('theme');
                    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        this.isDarkMode = true;
                        document.documentElement.classList.add('dark');
                    }
                },

                toggleTheme() {
                    this.isDarkMode = !this.isDarkMode;
                    document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', this.isDarkMode ? 'dark' : 'light');
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
