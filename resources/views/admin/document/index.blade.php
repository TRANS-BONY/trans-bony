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

        <!-- Tableau des documents -->
        <div class="animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Documents enregistrés</h2>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $documents->count() }} document(s) au total</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Véhicule</th>
                                <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Émission</th>
                                <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Expiration</th>
                                <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Fichier</th>
                                <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($documents as $doc)
                            @php
                                $expire = \Carbon\Carbon::parse($doc->date_expiration);
                                $statusConfig = [];
                                if ($expire->isPast()) {
                                    $statusConfig = ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Expiré'];
                                } elseif ($expire->diffInDays(now()) <= 7) {
                                    $statusConfig = ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'label' => 'Bientôt'];
                                } else {
                                    $statusConfig = ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Valide'];
                                }

                                $typeConfig = [
                                    'assurance' => ['icon' => '🛡️', 'color' => 'text-blue-600'],
                                    'carte grise' => ['icon' => '📄', 'color' => 'text-purple-600'],
                                    'visite technique' => ['icon' => '🔧', 'color' => 'text-amber-600'],
                                ];
                                $typeInfo = $typeConfig[$doc->type] ?? ['icon' => '📁', 'color' => 'text-gray-600'];
                            @endphp
                            <tr class="hover:bg-gray-50 transition-all duration-300 group">
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
<span class="font-semibold text-gray-900">{{ $doc->vehicule?->immatriculation ?? 'Véhicule supprimé' }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $doc->vehicule?->marque ?? 'N/A' }} {{ $doc->vehicule?->modele ?? '' }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1 {{ $typeInfo['color'] }}">
                                        <span class="text-lg">{{ $typeInfo['icon'] }}</span>
                                        <span class="capitalize">{{ $doc->type }}</span>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $doc->date_emission ? \Carbon\Carbon::parse($doc->date_emission)->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $expire->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $expire->diffForHumans() }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.documents.download', $doc) }}" target="_blank"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-all duration-200 group/btn border border-emerald-200/50 shadow-sm hover:shadow-md rounded">
                                            <span class="text-sm font-medium">📄 Télécharger</span>
                                        </a>
                                        <a href="{{ route('admin.documents.edit', $doc) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 transition-all duration-200 group/btn border border-blue-200/50 shadow-sm hover:shadow-md rounded">
                                            <span class="text-sm font-medium">✏️ Modifier</span>
                                        </a>
                                        <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 transition-all duration-200 group/btn border border-red-200/50 shadow-sm hover:shadow-md rounded">
                                                <span class="text-sm font-medium">🗑️</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusConfig['icon'] }}"></path>
                                        </svg>
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="p-4 rounded-full bg-gray-100">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-semibold text-gray-700">Aucun document</p>
                                            <p class="text-sm text-gray-500 mt-1">Commencez par ajouter un document</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
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
