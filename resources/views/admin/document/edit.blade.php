@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header avec dégradé -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex items-center gap-6">
            <div class="p-4 bg-white/20 rounded-2xl shadow-lg backdrop-blur-md border border-white/30">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    Modifier le document
                </h1>
                <p class="text-blue-100 mt-1 opacity-90">Mise à jour des informations administratives</p>
            </div>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="animate-fade-in-up">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-8 py-5">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Détails du document</h2>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.documents.update', $document) }}" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Véhicule -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i class="fas fa-truck text-blue-500 w-4"></i>
                            Véhicule <span class="text-red-500">*</span>
                        </label>
                        <select name="vehicule_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white shadow-sm">
                            @foreach($vehicules as $v)
                            <option value="{{ $v->id }}" {{ $document->vehicule_id == $v->id ? 'selected' : '' }}>
                                {{ $v->immatriculation }} - {{ $v->marque }} {{ $v->modele }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i class="fas fa-tag text-blue-500 w-4"></i>
                            Type de document <span class="text-red-500">*</span>
                        </label>
                        <select name="type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white shadow-sm">
                            <option value="assurance" {{ $document->type == 'assurance' ? 'selected' : '' }}>🛡️ Assurance</option>
                            <option value="carte grise" {{ $document->type == 'carte grise' ? 'selected' : '' }}>📄 Carte Grise</option>
                            <option value="visite technique" {{ $document->type == 'visite technique' ? 'selected' : '' }}>🔧 Visite Technique</option>
                        </select>
                    </div>

                    <!-- Date Émission -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-blue-500 w-4"></i>
                            Date d'émission <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_emission" 
                               value="{{ old('date_emission', $document->date_emission ? $document->date_emission->format('Y-m-d') : '') }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    </div>

                    <!-- Date Expiration -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-check text-blue-500 w-4"></i>
                            Date d'expiration <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_expiration" 
                               value="{{ old('date_expiration', $document->date_expiration ? $document->date_expiration->format('Y-m-d') : '') }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    </div>
                </div>

                <!-- Fichier -->
                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                        <i class="fas fa-cloud-upload-alt text-blue-500 w-4"></i>
                        Nouveau Fichier (Optionnel)
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-0 bg-blue-50 border-2 border-dashed border-blue-200 rounded-2xl group-hover:border-blue-400 transition-all"></div>
                        <input type="file" name="fichier" accept=".pdf,.jpg,.jpeg,.png"
                               class="relative w-full h-32 opacity-0 cursor-pointer z-10">
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <i class="fas fa-file-upload text-3xl text-blue-400 mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-sm text-gray-500">Cliquez pour modifier le fichier (PDF, JPG, PNG)</p>
                            <p class="text-xs text-blue-400 mt-1">Fichier actuel : {{ basename($document->fichier) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.documents.index') }}" 
                       class="px-6 py-3 text-gray-700 font-semibold hover:text-gray-900 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all hover:scale-105 active:scale-95">
                        <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-down { animation: slideDown 0.5s ease-out forwards; }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
</style>
@endsection
