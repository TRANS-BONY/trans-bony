@extends('layouts.app')

@section('content')

<h2 class="text-xl mb-4">Ajouter Document</h2>

<form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data"
class="bg-white rounded-xl p-8 shadow-2xl">
@csrf

@if ($errors->any())
<div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
<ul>
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<select name="vehicule_id" class="w-full mb-3 p-2 text-black rounded" required>
<option value="">Choisir véhicule</option>
@foreach($vehicules as $vehicule)
<option value="{{ $vehicule->id }}">{{ $vehicule->immatriculation }}</option>
@endforeach
</select>

<input type="text" name="type" placeholder="Type document (ex: Assurance)" required
class="w-full mb-4 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ old('type') }}">

<label class="block text-sm font-medium text-gray-700 mb-2">Date d'émission</label>
<input type="date" name="date_emission" value="{{ old('date_emission', now()->format('Y-m-d')) }}" max="{{ old('date_expiration') }}" required
class="w-full mb-4 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">

<label class="block text-sm font-medium text-gray-700 mb-2">Date d'expiration</label>
<input type="date" name="date_expiration" min="{{ old('date_emission', now()->format('Y-m-d')) }}" required
class="w-full mb-6 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ old('date_expiration') }}">

<label class="block text-sm font-medium text-gray-700 mb-2">Fichier PDF/JPG/PNG (max 2MB)</label>
<input type="file" name="fichier" accept=".pdf,.jpg,.jpeg,.png" required
class="w-full mb-6 p-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer">

<button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">📤 Ajouter le document</button>

</form>

@endsection
