@extends('layouts.technicien')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center gap-4">
        <a href="{{ route('technicien.maintenances.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-orange-600 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modifier la Maintenance #{{ $maintenance->id }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <form action="{{ route('technicien.maintenances.update', $maintenance) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Véhicule concerné <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-bus text-gray-400"></i>
                    </div>
                    <select name="vehicule_id" class="pl-10 w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition py-2.5" required>
                        <option value="">Sélectionner un véhicule...</option>
                        @foreach($vehicules as $vehicule)
                            <option value="{{ $vehicule->id }}" {{ (old('vehicule_id', $maintenance->vehicule_id) == $vehicule->id) ? 'selected' : '' }}>
                                {{ $vehicule->immatriculation }} - {{ $vehicule->marque }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Type de maintenance <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-wrench text-gray-400"></i>
                        </div>
                        <select name="type" class="pl-10 w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition py-2.5" required>
                            <option value="preventive" {{ old('type', $maintenance->type) == 'preventive' ? 'selected' : '' }}>Préventive</option>
                            <option value="curative" {{ old('type', $maintenance->type) == 'curative' ? 'selected' : '' }}>Curative</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Statut <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-info-circle text-gray-400"></i>
                        </div>
                        <select name="statut" class="pl-10 w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition py-2.5" required>
                            <option value="planifiee" {{ old('statut', $maintenance->statut) == 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                            <option value="en cours" {{ old('statut', $maintenance->statut) == 'en cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminee" {{ old('statut', $maintenance->statut) == 'terminee' ? 'selected' : '' }}>Terminée</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date prévue / réalisée <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                        <input type="date" name="date_prevue" value="{{ old('date_prevue', $maintenance->date_prevue->format('Y-m-d')) }}" class="pl-10 w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition py-2.5" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Coût <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-money-bill-wave text-gray-400"></i>
                        </div>
                        <input type="number" name="cout" value="{{ old('cout', $maintenance->cout) }}" min="5000" max="65000" placeholder="Ex: 50000" class="pl-10 w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500 transition py-2.5" required>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
                <a href="{{ route('technicien.maintenances.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition">
                    Annuler
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-orange-500 hover:bg-orange-600 rounded-xl transition shadow-sm">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
