@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Gestion des Documents
                    </h1>
                    <p class="text-indigo-100 text-sm mt-1">Gérez les documents administratifs de votre flotte</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Formulaire d'ajout de document -->
        <div class="animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Ajouter un document</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Téléchargez un nouveau document administratif</p>
                        </div>
                    </div>
                </div>

<form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <!-- Véhicule -->
                    <div class="mb-5">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Véhicule <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="vehicule_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-gray-900 appearance-none cursor-pointer">
                                <option value="" disabled selected>-- Sélectionnez un véhicule --</option>
                                @foreach($vehicules as $v)
                                <option value="{{ $v->id }}">{{ $v->immatriculation }} - {{ $v->marque }} {{ $v->modele }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Type de document -->
                    <div class="mb-5">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Type de document <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-gray-900 appearance-none cursor-pointer">
                                <option value="assurance" selected>🛡️ Assurance</option>
                                <option value="carte grise">📄 Carte Grise</option>
                                <option value="visite technique">🔧 Visite Technique</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Date d'émission -->
                    <div class="mb-5">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date d'émission <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="date_emission"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-gray-900"
                               required>
                    </div>

                    <!-- Date d'expiration -->
                    <div class="mb-5">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date d'expiration <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="date_expiration"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-gray-900"
                               required>
                        <p class="text-xs text-gray-500 mt-1">La date doit être aujourd'hui ou ultérieure</p>
                    </div>

                    <!-- Fichier -->
                    <div class="mb-6">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Fichier <span class="text-red-500">*</span>
                        </label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-purple-400 transition-all duration-200">
                            <input type="file"
                                   name="fichier"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   required>
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-sm text-gray-500">Cliquez ou glissez un fichier (PDF, JPG, PNG)</p>
                                <p class="text-xs text-gray-400">Taille maximale : 5MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton d'envoi -->
                    <button type="submit"
                            class="w-full group relative overflow-hidden bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 rounded-lg py-3 transition-all duration-300 hover:scale-105 shadow-lg">
                        <div class="relative flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-white font-medium">Ajouter le document</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <!-- Liste des documents (Tableau Desktop / Cartes Mobile) -->
        <div class="animate-fade-in-up lg:col-span-1" style="animation-delay: 0.2s">
            
            {{-- Vue Mobile : Grille de Cartes --}}
            <div class="grid grid-cols-1 gap-4 lg:hidden">
                @forelse($documents as $doc)
                    @php
                        $expire = \Carbon\Carbon::parse($doc->date_expiration);
                        $statusConfig = [];
                        if ($expire->isPast()) {
                            $statusConfig = ['bg' => 'bg-red-500', 'text' => 'text-white', 'icon' => 'fas fa-exclamation-circle', 'label' => 'Expiré'];
                        } elseif ($expire->diffInDays(now()) <= 7) {
                            $statusConfig = ['bg' => 'bg-amber-500', 'text' => 'text-white', 'icon' => 'fas fa-clock', 'label' => 'Bientôt'];
                        } else {
                            $statusConfig = ['bg' => 'bg-emerald-500', 'text' => 'text-white', 'icon' => 'fas fa-check-circle', 'label' => 'Valide'];
                        }
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center">
                                        <i class="fas fa-file-alt text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $doc->vehicule?->immatriculation ?? 'N/A' }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ $doc->type }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between py-2 border-t border-gray-50 dark:border-gray-700/50">
                                <span class="text-xs text-gray-500">Expire le :</span>
                                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $expire->format('d/m/Y') }}</span>
                            </div>

                            <div class="flex gap-2 mt-3">
                                <a href="{{ route('admin.documents.download', $doc) }}" class="flex-1 text-center py-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-xs font-bold transition hover:bg-emerald-100">
                                    <i class="fas fa-download mr-1"></i> Télécharger
                                </a>
                                <a href="{{ route('admin.documents.edit', $doc) }}" class="p-2 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl transition hover:text-indigo-600">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-600">
                        <p class="text-gray-500">Aucun document</p>
                    </div>
                @endforelse
            </div>

            {{-- Vue Desktop : Tableau --}}
            <div class="hidden lg:block bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Documents enregistrés</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400">
                            <tr>
                                <th class="p-4 uppercase text-[10px] font-bold">Véhicule</th>
                                <th class="p-4 uppercase text-[10px] font-bold">Type</th>
                                <th class="p-4 uppercase text-[10px] font-bold">Expiration</th>
                                <th class="p-4 uppercase text-[10px] font-bold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($documents as $doc)
                                @php
                                    $expire = \Carbon\Carbon::parse($doc->date_expiration);
                                    $statusClass = $expire->isPast() ? 'text-red-500' : ($expire->diffInDays(now()) <= 7 ? 'text-amber-500' : 'text-emerald-500');
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $doc->vehicule?->immatriculation ?? 'N/A' }}</div>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded text-[10px] font-bold uppercase">{{ $doc->type }}</span>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-semibold {{ $statusClass }}">{{ $expire->format('d/m/Y') }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $expire->diffForHumans() }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center gap-1">
                                            <a href="{{ route('admin.documents.download', $doc) }}" class="p-2 text-gray-400 hover:text-emerald-600 transition" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ route('admin.documents.edit', $doc) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" onclick="return confirm('Supprimer ce document ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques des documents -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.3s">
        <div class="rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-purple-100 uppercase tracking-wider">Total</p>
                    <p class="text-2xl font-bold text-white">{{ $documents->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider">Valides</p>
                    <p class="text-2xl font-bold text-white">{{ $documents->filter(fn($doc) => \Carbon\Carbon::parse($doc->date_expiration)->isFuture() && \Carbon\Carbon::parse($doc->date_expiration)->diffInDays(now()) > 7)->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-100 uppercase tracking-wider">Bientôt expirés</p>
                    <p class="text-2xl font-bold text-white">{{ $documents->filter(fn($doc) => !\Carbon\Carbon::parse($doc->date_expiration)->isPast() && \Carbon\Carbon::parse($doc->date_expiration)->diffInDays(now()) <= 7)->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl bg-gradient-to-br from-red-500 to-red-600 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-red-100 uppercase tracking-wider">Expirés</p>
                    <p class="text-2xl font-bold text-white">{{ $documents->filter(fn($doc) => \Carbon\Carbon::parse($doc->date_expiration)->isPast())->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animations personnalisées */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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

    .animate-slide-down {
        animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    /* Style pour les champs de formulaire */
    input:focus, select:focus {
        outline: none;
    }

    /* Transition douce pour tous les éléments */
    * {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endsection
