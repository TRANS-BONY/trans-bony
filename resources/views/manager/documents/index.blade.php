@extends('layouts.manager')

@section('content')

<style>
    /* Désactiver le scroll global */
    html, body { overflow: hidden !important; height: 100vh !important; }
    
    /* Scrollbar minimaliste */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.2); border-radius: 10px; }
    
    /* Wrapper Layout */
    .module-index-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        height: calc(100vh - 100px);
        overflow: hidden;
        padding-bottom: 0.5rem;
    }
    
    .module-index-wrapper > * {
        flex-shrink: 0;
    }
    
    .module-index-wrapper > .list-scroll-container {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        overflow-y: auto !important;
        padding-right: 0.25rem;
    }
</style>
<div class="module-index-wrapper custom-scrollbar">
    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Documents</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gestion administrative du parc</p>
        </div>
    </div>
    <!-- Barre de recherche injectée -->
    <div class="mb-4">
        <form method="GET" class="relative shadow-sm rounded-xl overflow-hidden">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
        </form>
    </div>
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col list-scroll-container">
        <div class="overflow-x-auto overflow-y-auto flex-1 custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-medium">Type de Document</th>
                        <th class="p-4 font-medium">Véhicule</th>
                        <th class="p-4 font-medium">Date d'Expiration</th>
                        <th class="p-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($documents as $d)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="p-4">
                            <p class="font-bold text-gray-900 dark:text-white">{{ $d->type }}</p>
                        </td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $d->vehicule->immatriculation ?? 'N/A' }}</td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $d->date_expiration ? $d->date_expiration->format('d/m/Y') : '-' }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('manager.documents.show', $d) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-8 text-center text-gray-500">Aucun document enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($documents->hasPages())
        <div class="p-4 bg-gray-50 shrink-0">{{ $documents->links() }}</div>
        @endif
    </div>
</div>
@endsection
