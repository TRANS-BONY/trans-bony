@extends('layouts.gestionnaire')

@section('title', 'Modifier document')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <form action="{{ route('gestionnaire.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Véhicule</label>
                <select name="vehicule_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                    @foreach($vehicules as $v)
                        <option value="{{ $v->id }}" {{ $document->vehicule_id == $v->id ? 'selected' : '' }}>{{ $v->immatriculation }} ({{ $v->marque }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Type de document</label>
                <input type="text" name="type" required value="{{ old('type', $document->type) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date d'émission</label>
                    <input type="date" name="date_emission" required value="{{ old('date_emission', \Carbon\Carbon::parse($document->date_emission)->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date d'expiration</label>
                    <input type="date" name="date_expiration" required value="{{ old('date_expiration', \Carbon\Carbon::parse($document->date_expiration)->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Changer le fichier (Optionnel)</label>
                <input type="file" name="fichier" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition shadow-lg shadow-teal-500/20">Mettre à jour</button>
                <a href="{{ route('gestionnaire.documents.index') }}" class="px-8 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl transition">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
