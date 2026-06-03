@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-receipt text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Détail de la Recette</h1>
                    <p class="text-emerald-100 text-sm mt-1">
                        {{ \Carbon\Carbon::parse($recette->mois ?? $recette->date)->isoFormat('MMMM YYYY') }}
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.recettes.edit', $recette) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-emerald-700 font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.recettes.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl border border-white/30 backdrop-blur-sm transition hover:scale-105">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- CARD MONTANT --}}
        <div class="lg:col-span-1 animate-fade-in-up" style="animation-delay:0.1s">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 text-center border border-gray-100 dark:border-gray-700 h-full flex flex-col justify-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 mx-auto flex items-center justify-center shadow-xl mb-4">
                    <i class="fas fa-coins text-white text-2xl"></i>
                </div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Montant</p>
                <p class="text-4xl font-black text-emerald-600 dark:text-emerald-400">
                    {{ number_format($recette->montant, 0, ',', ' ') }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">FCFA</p>

                <div class="mt-6 space-y-2">
                    <a href="{{ route('admin.recettes.edit', $recette) }}"
                       class="flex items-center justify-center gap-2 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl shadow hover:shadow-md hover:scale-105 transition-all">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form method="POST" action="{{ route('admin.recettes.destroy', $recette) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer cette recette ?')"
                                class="w-full flex items-center justify-center gap-2 py-2.5 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 text-sm font-semibold rounded-xl transition hover:scale-105">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- INFOS --}}
        <div class="lg:col-span-2 animate-fade-in-up" style="animation-delay:0.15s">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                    <i class="fas fa-info-circle text-emerald-500"></i> Informations
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Mois de référence</p>
                        <p class="text-base font-bold text-gray-800 dark:text-white">
                            {{ \Carbon\Carbon::parse($recette->mois ?? $recette->date)->isoFormat('MMMM YYYY') }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Date</p>
                        <p class="text-base font-bold text-gray-800 dark:text-white">
                            {{ \Carbon\Carbon::parse($recette->date ?? $recette->mois)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Type</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold
                            {{ ($recette->type ?? '') === 'Billet'   ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ ($recette->type ?? '') === 'Location' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ ($recette->type ?? '') === 'Fret'     ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ !in_array($recette->type ?? '', ['Billet','Location','Fret']) ? 'bg-gray-100 text-gray-600' : '' }}">
                            {{ $recette->type ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Véhicule</p>
                        <p class="text-base font-bold text-gray-800 dark:text-white">
                            {{ optional($recette->vehicule)->immatriculation ?? '—' }}
                        </p>
                        @if($recette->vehicule)
                        <p class="text-xs text-gray-400">{{ optional($recette->vehicule)->marque }} {{ optional($recette->vehicule)->modele }}</p>
                        @endif
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Créé le</p>
                        <p class="text-base font-bold text-gray-800 dark:text-white">
                            {{ $recette->created_at ? $recette->created_at->format('d/m/Y H:i') : '—' }}
                        </p>
                    </div>
                    <div class="sm:col-span-2 p-4 bg-emerald-50 dark:bg-emerald-900/10 rounded-xl border border-emerald-100 dark:border-emerald-800">
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 uppercase tracking-wider font-semibold mb-1">Voyage associé</p>
                        @if($recette->voyage)
                            <p class="text-base font-bold text-gray-800 dark:text-white">
                                {{ $recette->voyage->destination }}
                            </p>
                            <p class="text-xs text-gray-400">Date de départ : {{ $recette->voyage->date_depart->format('d/m/Y') }}</p>
                        @else
                            <p class="text-sm italic text-gray-400 line-through">Aucun voyage lié</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px);  } to { opacity: 1; transform: translateY(0); } }
.animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>
@endsection

