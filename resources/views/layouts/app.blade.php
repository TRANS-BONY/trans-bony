<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TRANS BONY - Dashboard Professionnel</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
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
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
        }
    }

    .notification-badge {
        animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Scrollbar personnalisée */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #2563eb;
    }

    /* Dark mode scrollbar */
    .dark ::-webkit-scrollbar-track {
        background: #1f2937;
    }

    .dark ::-webkit-scrollbar-thumb {
        background: #3b82f6;
    }

    /* Input styles */
    input, select, textarea {
        transition: all 0.2s ease;
    }

    input:focus, select:focus, textarea:focus {
        transform: scale(1.02);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Animation pour les cartes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    /* Transition pour le mode sombre */
    * {
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
</style>
</head>

<body x-data="app()" :class="{'dark': isDarkMode}" class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <!-- Structure simple : flex sur desktop, overlay sur mobile -->
    <div class="flex">
        <!-- SIDEBAR - Toujours visible sur desktop, overlay sur mobile -->
        <div
            class="fixed inset-y-0 left-0 z-30 w-72 bg-gradient-to-br from-blue-900 to-indigo-900 dark:from-gray-800 dark:to-gray-900 shadow-2xl transform transition-all duration-300 ease-in-out lg:relative lg:translate-x-0 overflow-y-auto"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-truck-fast text-2xl text-blue-400 animate-pulse"></i>
                        <div>
                            <h2 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">TRANS BONY</h2>
                            <p class="text-xs text-blue-300 dark:text-gray-400 mt-1">Gestion de flotte</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-300 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-wider text-blue-300 dark:text-gray-400 mb-4 font-semibold">
                        <i class="fas fa-compass mr-2"></i> Navigation Principale
                    </p>

<a href="/dashboard" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                        <i class="fas fa-chart-line w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                        <span class="flex-1">Tableau de bord</span>
                    </a>



@can('gerer vehicules')
                    <a href="/admin/vehicules" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                        <i class="fas fa-truck w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                        <span class="flex-1">Véhicules</span>
                        @if(($sidebar_vehicules ?? 0) > 0)
                            <span title="{{ $sidebar_vehicules_dispo ?? 0 }} dispo · {{ $sidebar_vehicules_miss ?? 0 }} en mission · {{ $sidebar_vehicules_maint ?? 0 }} en maintenance"
                                  class="text-xs bg-blue-600/50 px-2 py-1 rounded-full font-semibold">
                                {{ $sidebar_vehicules ?? 0 }}
                            </span>
                        @endif
                    </a>
                    @endcan

@can('gerer chauffeurs')
                    <a href="/admin/chauffeurs" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                        <i class="fas fa-user-circle w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                        <span class="flex-1">Chauffeurs</span>
                        @if(($sidebar_chauffeurs ?? 0) > 0)
                            <span class="text-xs bg-green-600/50 px-2 py-1 rounded-full font-semibold">
                                {{ $sidebar_chauffeurs ?? 0 }}
                            </span>
                        @endif
                    </a>
                    @endcan

@can('gerer voyages')
                    <a href="/admin/voyages" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                        <i class="fas fa-route w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                        <span class="flex-1">Voyages</span>
                        @if(($sidebar_voyages_today ?? 0) > 0)
                            <span title="{{ $sidebar_voyages_today ?? 0 }} voyage(s) aujourd'hui"
                                  class="text-xs bg-amber-500/50 px-2 py-1 rounded-full font-semibold">
                                {{ $sidebar_voyages_today ?? 0 }}
                            </span>
                        @elseif(($sidebar_voyages ?? 0) > 0)
                            <span class="text-xs bg-amber-600/30 px-2 py-1 rounded-full font-semibold">
                                {{ $sidebar_voyages ?? 0 }}
                            </span>
                        @endif
                    </a>
                    @endcan

@can('gerer maintenance')
                    <a href="/admin/maintenances" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                        <i class="fas fa-tools w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                        <span class="flex-1">Maintenance</span>
                        @if(($sidebar_maintenances_encours ?? 0) > 0)
                            <span title="{{ $sidebar_maintenances_encours ?? 0 }} en cours · {{ $sidebar_maintenances_planif ?? 0 }} planifiée(s)"
                                  class="text-xs bg-orange-500/60 px-2 py-1 rounded-full font-semibold animate-pulse">
                                {{ $sidebar_maintenances_encours ?? 0 }}
                            </span>
                        @elseif(($sidebar_maintenances ?? 0) > 0)
                            <span class="text-xs bg-yellow-600/40 px-2 py-1 rounded-full font-semibold">
                                {{ $sidebar_maintenances ?? 0 }}
                            </span>
                        @endif
                    </a>
                    @endcan

@can('gerer documents')
                    <a href="/admin/documents" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                        <i class="fas fa-file-alt w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                        <span class="flex-1">Documents</span>
                        @if(($sidebar_docs_expire ?? 0) > 0)
                            {{-- Alerte rouge : documents déjà expirés --}}
                            <span title="{{ $sidebar_docs_expire ?? 0 }} expiré(s) · {{ $sidebar_docs_bientot ?? 0 }} bientôt expiré(s)"
                                  class="text-xs bg-red-600/70 px-2 py-1 rounded-full font-semibold animate-pulse">
                                ⚠ {{ $sidebar_docs_alerte ?? 0 }}
                            </span>
                        @elseif(($sidebar_docs_bientot ?? 0) > 0)
                            {{-- Alerte orange : bientôt expirés --}}
                            <span title="{{ $sidebar_docs_bientot ?? 0 }} document(s) expirent dans 30 jours"
                                  class="text-xs bg-orange-500/60 px-2 py-1 rounded-full font-semibold">
                                {{ $sidebar_docs_bientot ?? 0 }}
                            </span>
                        @elseif(($sidebar_documents ?? 0) > 0)
                            <span class="text-xs bg-purple-600/40 px-2 py-1 rounded-full font-semibold">
                                {{ $sidebar_documents ?? 0 }}
                            </span>
                        @endif
                    </a>
                    @endcan

@can('gerer finances')
                    <a href="/admin/recettes" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                        <i class="fas fa-coins w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                        <span class="flex-1">Recettes</span>
                        @if(($sidebar_recettes ?? 0) > 0)
                            <span title="{{ number_format($sidebar_recettes_mois ?? 0, 0, ',', ' ') }} FCFA ce mois"
                                  class="text-xs bg-emerald-600/50 px-2 py-1 rounded-full font-semibold">
                                {{ $sidebar_recettes ?? 0 }}
                            </span>
                        @endif
                    </a>
                    @endcan

@can('voir rapports')
                    <a href="/admin/rapports" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                        <i class="fas fa-chart-bar w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                        <span class="flex-1">Rapports</span>
                    </a>
                    @endcan

@role('admin')
                    <div class="pt-4 mt-4 border-t border-white/20 dark:border-gray-700">
                        <p class="text-xs uppercase tracking-wider text-blue-300 dark:text-gray-400 mb-4 font-semibold">
                            <i class="fas fa-shield-alt mr-2"></i> Administration
                        </p>
                        <a href="/admin/users" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-white dark:text-gray-200">
                            <i class="fas fa-users w-5 text-blue-300 dark:text-blue-400 group-hover:text-white transition"></i>
                            <span class="flex-1">Utilisateurs</span>
                            @if(($sidebar_users ?? 0) > 0)
                                <span class="text-xs bg-indigo-600/50 px-2 py-1 rounded-full font-semibold">
                                    {{ $sidebar_users ?? 0 }}
                                </span>
                            @endif
                        </a>
                    </div>
                    @endrole
                </div>

                <!-- Info utilisateur dans sidebar (visible sur mobile) -->
                <div class="lg:hidden mt-8 pt-6 border-t border-white/20 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white dark:text-gray-200">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-blue-300 dark:text-gray-400">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay pour mobile -->
        <div
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 z-20 lg:hidden">
        </div>

        <!-- CONTENT PRINCIPAL -->
        <div class="flex-1 min-h-screen">
            <!-- NAVBAR -->
            <div class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-10 transition-colors duration-300">
                <div class="px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent" x-text="currentPageTitle">Tableau de bord</h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 hidden sm:block">Bienvenue, {{ auth()->user()->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- NOTIFICATIONS -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <i class="fas fa-bell text-lg sm:text-xl text-gray-600 dark:text-gray-300"></i>
                                <span x-show="notificationCount > 0" x-text="notificationCount" class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold"></span>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 z-50">
                                <div class="p-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                    <span class="text-xs text-blue-600 dark:text-blue-400 cursor-pointer hover:text-blue-800 dark:hover:text-blue-300" @click="markAllAsRead">Tout marquer comme lu</span>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <div class="p-3 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition border-b border-gray-100 dark:border-gray-700">
                                            <div class="flex items-start space-x-2">
                                                <i :class="notif.icon" class="mt-1 text-blue-500 dark:text-blue-400"></i>
                                                <div class="flex-1">
                                                    <p class="text-sm text-gray-900 dark:text-white" x-text="notif.message"></p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="notif.time"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="notifications.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-bell-slash text-3xl mb-2"></i>
                                        <p class="text-sm">Aucune notification</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DARK MODE TOGGLE -->
                        <button @click="toggleTheme" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition relative">
                            <i x-show="!isDarkMode" class="fas fa-moon text-lg sm:text-xl text-gray-600 dark:text-gray-300"></i>
                            <i x-show="isDarkMode" class="fas fa-sun text-lg sm:text-xl text-yellow-400"></i>
                        </button>

                        <!-- USER MENU -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 sm:space-x-3 hover:opacity-80 transition p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user text-white text-sm sm:text-base"></i>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs hidden md:block text-gray-500 dark:text-gray-400"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 z-50">
                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <i class="fas fa-user-circle mr-2 w-4"></i> Mon profil
                                    </a>
                                    <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <i class="fas fa-cog mr-2 w-4"></i> Paramètres
                                    </a>
                                    <hr class="my-1 border-gray-200 dark:border-gray-700">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                            <i class="fas fa-sign-out-alt mr-2 w-4"></i> Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="p-4 sm:p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded transition duration-500 ease-in-out" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">{{ session('success') }}</span>
                            <button @click="show = false" class="text-green-700 hover:text-green-900 text-xl font-bold">&times;</button>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded transition duration-500 ease-in-out" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">{{ session('error') }}</span>
                            <button @click="show = false" class="text-red-700 hover:text-red-900 text-xl font-bold">&times;</button>
                        </div>
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded transition duration-500 ease-in-out" x-data="{ show: true }" x-show="show">
                        <div class="flex items-start justify-between">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button @click="show = false" class="text-red-700 hover:text-red-900 ml-4 text-xl font-bold">&times;</button>
                        </div>
                    </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>

    <script>
        function app() {
            return {
                sidebarOpen: false,
                isDarkMode: false,
                notificationCount: 0,
                notifications: [],
                currentPageTitle: 'Tableau de bord',

                init() {
                    // Update active menu and title based on URL
                    const currentPath = window.location.pathname;
                    const navItems = document.querySelectorAll('.nav-item');
                    
                    navItems.forEach(item => {
                        const itemHref = item.getAttribute('href');
                        if ((itemHref === '/dashboard' && currentPath === '/dashboard') || 
                            (itemHref !== '/dashboard' && currentPath.startsWith(itemHref))) {
                            item.classList.add('active');
                            const titleSpan = item.querySelector('span.flex-1');
                            if (titleSpan) {
                                this.currentPageTitle = titleSpan.innerText;
                                document.title = 'TRANS BONY - ' + this.currentPageTitle;
                            }
                        }
                    });

                    // Initialiser le mode sombre depuis localStorage
                    const savedTheme = localStorage.getItem('theme');
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                        this.isDarkMode = true;
                        document.documentElement.classList.add('dark');
                    } else {
                        this.isDarkMode = false;
                        document.documentElement.classList.remove('dark');
                    }

                    this.loadNotifications();
                    this.startNotificationPolling();

                    // Fermer le sidebar sur mobile après clic sur un lien
                    document.querySelectorAll('.nav-item').forEach(link => {
                        link.addEventListener('click', () => {
                            if (window.innerWidth < 1024) {
                                this.sidebarOpen = false;
                            }
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
                },

                loadNotifications() {
                    fetch('/notifications')
                        .then(res => res.json())
                        .then(data => {
                            this.notificationCount = data.count;
                            this.notifications = data.items || [];
                        })
                        .catch(() => {
                            // Données de démonstration
                            this.notificationCount = 3;
                            this.notifications = [
                                { id: 1, message: '🚛 Nouveau voyage programmé pour demain', time: 'Il y a 5 min', icon: 'fas fa-truck' },
                                { id: 2, message: '🔧 Maintenance prévue pour le véhicule #1234', time: 'Il y a 1 heure', icon: 'fas fa-tools' },
                                { id: 3, message: '📄 Document d\'assurance expirant dans 3 jours', time: 'Il y a 2 heures', icon: 'fas fa-file-alt' }
                            ];
                        });
                },

                startNotificationPolling() {
                    setInterval(() => {
                        this.loadNotifications();
                    }, 30000);
                },

                markAllAsRead() {
                    this.notificationCount = 0;
                    this.notifications = [];
                }
            }
        }

        // Animation des cartes
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate-fadeInUp');
            });
        });
    </script>
</body>
</html>
