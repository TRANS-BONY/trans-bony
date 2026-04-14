@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-3xl shadow-2xl p-8 text-white">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-bold mb-2 flex items-center gap-4">
                    <i class="fas fa-users text-2xl bg-white/20 p-3 rounded-2xl"></i>
                    Gestion des Utilisateurs
                </h1>
                <p class="text-xl opacity-90">{{ $users->total() }} utilisateur{{ $users->total() > 1 ? 's' : '' }} au total</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
               class="bg-white hover:bg-gray-100 text-indigo-600 font-bold px-8 py-4 rounded-2xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 whitespace-nowrap">
                <i class="fas fa-plus text-xl"></i>
                Ajouter un utilisateur
            </a>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-8">
            <!-- Search/Filter -->
            <div class="flex flex-col md:flex-row gap-4 mb-8 p-6 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/50 dark:to-gray-800/50 rounded-2xl">
                <div class="relative flex-1 max-w-md">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Rechercher par nom ou email..."
                           class="w-full pl-12 pr-4 py-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm">
                </div>
                <select class="px-6 py-4 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm">
                    <option>Tous statuts</option>
                    <option>Actifs</option>
                    <option>Inactifs</option>
                </select>
            </div>

            <!-- Users Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($users as $user)
                    <div x-data="{ open: false }"
                         class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 cursor-pointer border border-gray-100 dark:border-gray-700 overflow-hidden hover:border-indigo-200 dark:hover:border-indigo-700">
                        <!-- Card Header -->
                        <div @click="open = !open" class="p-8 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-colors">
                            <div class="flex items-start gap-4">
                                <div class="relative flex-shrink-0">
                                    <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=3b82f6&background=f8fafc&size=80&bold=true' }}"
                                         alt="{{ $user->name }}"
                                         class="w-20 h-20 rounded-2xl ring-4 {{ $user->is_active ? 'ring-green-200 dark:ring-green-900/50' : 'ring-red-200 dark:ring-red-900/50' }} shadow-lg object-cover transition ring-4">
                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-md">
                                        <i class="fas fa-circle text-xs {{ $user->is_active ? 'text-green-500' : 'text-red-500' }}"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition mb-1 truncate">{{ $user->name }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-1 truncate">{{ $user->email }}</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r
                                        {{ $user->is_active ? 'from-green-400 to-green-500 text-white shadow-md shadow-green-200' : 'from-red-400 to-red-500 text-white shadow-md shadow-red-200' }}">
                                        <i class="fas fa-circle mr-1"></i>
                                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </div>
                                <div class="flex-shrink-0 ml-auto">
                                    <i class="fas fa-chevron-down text-2xl text-gray-400 group-hover:text-indigo-500 transition transform rotate-0 group-hover:rotate-180" x-show="!open"></i>
                                    <i class="fas fa-chevron-up text-2xl text-gray-400 group-hover:text-indigo-500 transition transform rotate-180 group-hover:rotate-0" x-show="open"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card Details -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 max-h-0"
                             x-transition:enter-end="opacity-100 max-h-96"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 max-h-96"
                             x-transition:leave-end="opacity-0 max-h-0"
                             class="bg-gradient-to-b from-indigo-50 to-blue-50 dark:from-indigo-900/30 dark:to-blue-900/20 p-8 border-t border-indigo-100 dark:border-indigo-800/50 overflow-hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="fas fa-user-tag text-indigo-500"></i>Rôle principal
                                    </p>
                                    <span class="bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 px-4 py-2 rounded-xl font-semibold text-sm">
                                        {{ $user->roles->first()?->name ?? 'Non assigné' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="fas fa-calendar text-gray-500"></i>Inscrit depuis
                                    </p>
                                    <p class="text-lg font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-6 border-t border-indigo-200 dark:border-indigo-700">
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                   class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-eye"></i>
                                    Voir détails
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-edit"></i>
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="flex-1" onsubmit="return confirm('Supprimer {{ $user->name }} ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <i class="fas fa-users-slash text-8xl text-gray-300 dark:text-gray-600 mb-8 opacity-50"></i>
                        <h3 class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-2">Aucun utilisateur trouvé</h3>
                        <p class="text-gray-500 dark:text-gray-500 mb-8">Commencez par ajouter le premier utilisateur.</p>
                        <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl transition-all">
                            + Ajouter le premier
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-8 pb-8">
                {{ $users->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection

