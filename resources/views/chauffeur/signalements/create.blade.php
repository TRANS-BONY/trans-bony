@extends('layouts.chauffeur')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
        <!-- Header -->
        <div class="bg-gradient-to-r from-red-600 to-rose-600 px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <i class="fas fa-exclamation-triangle text-xl text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Signaler un Incident</h2>
                    <p class="text-rose-100 text-xs">Informez le gestionnaire en cas de panne ou perturbation</p>
                </div>
            </div>
        </div>

        <form action="{{ route('chauffeur.signalements.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            <!-- Voyage concerné -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Voyage concerné <span class="text-red-500">*</span></label>
                <select name="voyage_id" required class="w-full rounded-2xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-red-500 focus:border-red-500 p-4">
                    <option value="" disabled selected>-- Sélectionnez le voyage --</option>
                    @foreach($voyages as $v)
                        <option value="{{ $v->id }}">{{ $v->destination }} ({{ $v->date_depart->format('d/m H:i') }})</option>
                    @endforeach
                </select>
                @error('voyage_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Type d'incident -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Type d'incident <span class="text-red-500">*</span></label>
                    <select name="type" required class="w-full rounded-2xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-red-500 focus:border-red-500 p-4">
                        <option value="panne">🔧 Panne mécanique</option>
                        <option value="accident">💥 Accident</option>
                        <option value="embouteillage">🚦 Embouteillage majeur</option>
                        <option value="meteo">⛈️ Météo défavorable</option>
                        <option value="autre">❓ Autre</option>
                    </select>
                </div>

                <!-- Gravité -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Gravité <span class="text-red-500">*</span></label>
                    <select name="gravite" required class="w-full rounded-2xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-red-500 focus:border-red-500 p-4">
                        <option value="faible">Faible (Information)</option>
                        <option value="moyenne">Moyenne (Besoin d'aide)</option>
                        <option value="critique">Critique (Urgent / Immobilisé)</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Description détaillée <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required placeholder="Expliquez la situation précisément..."
                          class="w-full rounded-2xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-red-500 focus:border-red-500 p-4"></textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Localisation -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Localisation (Ville / Borne km)</label>
                <input type="text" name="localisation" placeholder="ex: PK 145 route de Yamoussoukro"
                       class="w-full rounded-2xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-red-500 focus:border-red-500 p-4">
            </div>

            <!-- Photo -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Photo de l'incident (Optionnel)</label>
                <div class="relative group h-32 border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-2xl flex flex-col items-center justify-center hover:border-red-400 transition-colors cursor-pointer overflow-hidden">
                    <input type="file" name="photo" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" id="photo_input">
                    <div class="flex flex-col items-center" id="photo_preview_ui">
                        <i class="fas fa-camera text-2xl text-gray-400 mb-2"></i>
                        <span class="text-xs text-gray-400">Prendre ou choisir une photo</span>
                    </div>
                    <img id="photo_preview" class="hidden absolute inset-0 w-full h-full object-cover">
                </div>
            </div>

            <!-- Bouton -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-red-200 dark:shadow-none transition-all transform active:scale-95">
                    Envoyer le signalement
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('photo_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('photo_preview').src = event.target.result;
                document.getElementById('photo_preview').classList.remove('hidden');
                document.getElementById('photo_preview_ui').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
