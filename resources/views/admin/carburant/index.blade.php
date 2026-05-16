@extends($rolePrefix === 'admin' ? 'layouts.app' : 'layouts.' . $rolePrefix)

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
    
    .list-scroll-container {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        overflow-y: auto !important;
        padding-right: 0.25rem;
    }
</style>

<div class="module-index-wrapper custom-scrollbar" x-data="{ showModal: false, editMode: false, currentFuel: {} }">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-pink-600 via-rose-600 to-red-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-gas-pump text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Suivi Carburant</h1>
                    <p class="text-pink-100 text-sm mt-1">Gérez la consommation et les dépenses énergétiques</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route($rolePrefix.'.carburant.pdf', ['search' => request('search')]) }}" 
                   class="px-5 py-3 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl transition-all duration-300 flex items-center gap-2 backdrop-blur-md">
                    <i class="fas fa-file-pdf text-white"></i>
                    <span class="text-white font-medium">Exporter PDF</span>
                </a>
                <button @click="editMode = false; currentFuel = {}; showModal = true"
                   class="group relative overflow-hidden px-6 py-3 bg-white/20 hover:bg-white/30 border border-white/30 rounded-xl shadow-lg transition-all duration-300 hover:scale-105 backdrop-blur-md">
                    <div class="relative flex items-center gap-2">
                        <i class="fas fa-plus text-white"></i>
                        <span class="text-white font-medium">Enregistrer un plein</span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Dépense Totale (Mois)</p>
            <p class="text-2xl font-black text-gray-900 dark:text-white">{{ number_format($carburants->where('date', '>=', now()->startOfMonth())->sum('montant'), 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Volume Total (Mois)</p>
            <p class="text-2xl font-black text-pink-600">{{ number_format($carburants->where('date', '>=', now()->startOfMonth())->sum('quantite'), 1) }} L</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Prix Moyen / L</p>
            @php 
                $totalAmt = $carburants->sum('montant');
                $totalQty = $carburants->sum('quantite');
                $avg = $totalQty > 0 ? $totalAmt / $totalQty : 0;
            @endphp
            <p class="text-2xl font-black text-gray-900 dark:text-white">{{ number_format($avg, 0) }} FCFA</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Nombre de Pleins</p>
            <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $carburants->total() }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="list-scroll-container bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
        <table class="w-full text-left text-sm">
            <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900 z-10">
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th class="p-4 font-bold text-gray-600 dark:text-gray-300 uppercase text-[10px]">Date</th>
                    <th class="p-4 font-bold text-gray-600 dark:text-gray-300 uppercase text-[10px]">Véhicule</th>
                    <th class="p-4 font-bold text-gray-600 dark:text-gray-300 uppercase text-[10px]">Quantité (L)</th>
                    <th class="p-4 font-bold text-gray-600 dark:text-gray-300 uppercase text-[10px]">Montant</th>
                    <th class="p-4 font-bold text-gray-600 dark:text-gray-300 uppercase text-[10px]">Compteur (KM)</th>
                    <th class="p-4 font-bold text-gray-600 dark:text-gray-300 uppercase text-[10px]">Station</th>
                    <th class="p-4 font-bold text-gray-600 dark:text-gray-300 uppercase text-[10px] text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($carburants as $c)
                <tr class="hover:bg-pink-50/30 dark:hover:bg-pink-900/10 transition-all group">
                    <td class="p-4 font-medium">{{ $c->date->format('d/m/Y') }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-md font-bold text-xs">{{ $c->vehicule->immatriculation }}</span>
                    </td>
                    <td class="p-4 font-bold text-pink-600">{{ number_format($c->quantite, 1) }} L</td>
                    <td class="p-4 font-bold">{{ number_format($c->montant, 0, ',', ' ') }}</td>
                    <td class="p-4 text-gray-500">{{ number_format($c->compteur_km, 0, ',', ' ') }} km</td>
                    <td class="p-4 text-xs">{{ $c->station ?? '-' }}</td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button @click="editMode = true; currentFuel = {{ json_encode($c) }}; showModal = true" class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route($rolePrefix . '.carburant.destroy', $c->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Supprimer cet enregistrement ?')" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
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

    <!-- Pagination -->
    <div class="animate-fade-in-up" style="animation-delay: 0.3s">
        {{ $carburants->links() }}
    </div>

    <!-- Modal Form -->
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-zoom-in">
            <div class="p-6 bg-gradient-to-r from-pink-600 to-rose-600 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white" x-text="editMode ? 'Modifier le plein' : 'Enregistrer un plein'"></h2>
                <button @click="showModal = false" class="text-white/80 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form :action="editMode ? '{{ url($rolePrefix . '/carburant') }}/' + currentFuel.id : '{{ route($rolePrefix . '.carburant.store') }}'" method="POST" class="p-6 space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Véhicule</label>
                    <select name="vehicule_id" x-model="currentFuel.vehicule_id" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 focus:ring-2 focus:ring-pink-500 outline-none transition" required>
                        <option value="">Sélectionner un bus</option>
                        @foreach($vehicules as $v)
                            <option value="{{ $v->id }}">{{ $v->immatriculation }} ({{ $v->marque }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Date</label>
                        <input type="date" name="date" x-model="currentFuel.date" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Litres</label>
                        <input type="number" step="0.01" min="0.1" name="quantite" x-model="currentFuel.quantite" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 outline-none" placeholder="0.0" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Montant (FCFA)</label>
                        <input type="number" min="0" name="montant" x-model="currentFuel.montant" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 outline-none" placeholder="0" required>
                        @error('montant') <p class="text-[9px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Compteur KM</label>
                        <input type="number" min="0" name="compteur_km" x-model="currentFuel.compteur_km" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 outline-none" placeholder="KM actuel" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Station Service</label>
                    <input type="text" name="station" x-model="currentFuel.station" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 outline-none" placeholder="Nom de la station" required>
                </div>

                <button type="submit" class="w-full py-4 bg-gradient-to-r from-pink-600 to-rose-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-pink-500/20 transition-all transform hover:scale-[1.02]">
                    Valider l'enregistrement
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes zoomIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .animate-slide-down { animation: slideDown 0.5s ease-out forwards; }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
    .animate-zoom-in { animation: zoomIn 0.3s ease-out forwards; }
    [x-cloak] { display: none !important; }
</style>

@endsection
