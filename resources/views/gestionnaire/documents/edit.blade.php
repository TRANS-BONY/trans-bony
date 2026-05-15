@extends('layouts.gestionnaire')

@section('title', 'Modifier document')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Modifier le document</h2>
            <p class="text-sm text-gray-500">Mettez à jour les informations. La validité doit être de 5 ans.</p>
        </div>

        <form action="{{ route('gestionnaire.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="documentForm">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Véhicule <span class="text-red-500">*</span></label>
                <select name="vehicule_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                    @foreach($vehicules as $v)
                        <option value="{{ $v->id }}" {{ old('vehicule_id', $document->vehicule_id) == $v->id ? 'selected' : '' }}>{{ $v->immatriculation }} ({{ $v->marque }})</option>
                    @endforeach
                </select>
                @error('vehicule_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Type de document <span class="text-red-500">*</span></label>
                <select name="type" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                    <option value="Assurance" {{ old('type', $document->type) == 'Assurance' ? 'selected' : '' }}>Assurance</option>
                    <option value="Carte Grise" {{ old('type', $document->type) == 'Carte Grise' ? 'selected' : '' }}>Carte Grise</option>
                    <option value="Visite Technique" {{ old('type', $document->type) == 'Visite Technique' ? 'selected' : '' }}>Visite Technique</option>
                    <option value="Patente" {{ old('type', $document->type) == 'Patente' ? 'selected' : '' }}>Patente</option>
                    <option value="Carte de Transport" {{ old('type', $document->type) == 'Carte de Transport' ? 'selected' : '' }}>Carte de Transport</option>
                    <option value="Autres" {{ old('type', $document->type) == 'Autres' ? 'selected' : '' }}>Autres</option>
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date d'émission <span class="text-red-500">*</span></label>
                    <input type="date" name="date_emission" id="date_emission" required value="{{ old('date_emission', \Carbon\Carbon::parse($document->date_emission)->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                    @error('date_emission') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date d'expiration <span class="text-red-500">*</span></label>
                    <input type="date" name="date_expiration" id="date_expiration" required value="{{ old('date_expiration', \Carbon\Carbon::parse($document->date_expiration)->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                    @error('date_expiration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Changer le fichier (Optionnel)</label>
                <input type="file" name="fichier" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition">
                @error('fichier') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition shadow-lg shadow-teal-500/20">Mettre à jour</button>
                <a href="{{ route('gestionnaire.documents.index') }}" class="px-8 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl transition">Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('date_emission').addEventListener('change', function() {
    const emissionDate = new Date(this.value);
    if (!isNaN(emissionDate)) {
        const expirationDate = new Date(emissionDate);
        expirationDate.setFullYear(emissionDate.getFullYear() + 5);
        
        // Format to YYYY-MM-DD
        const y = expirationDate.getFullYear();
        const m = String(expirationDate.getMonth() + 1).padStart(2, '0');
        const d = String(expirationDate.getDate()).padStart(2, '0');
        
        document.getElementById('date_expiration').value = `${y}-${m}-${d}`;
    }
});
</script>
@endsection
