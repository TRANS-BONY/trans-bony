@extends('layouts.app')

@section('content')

<h2 class="text-xl mb-4">Modifier Document</h2>

<form method="POST" action="{{ route('admin.documents.update', $document->id) }}" enctype="multipart/form-data"
class="bg-white rounded-xl p-8 shadow-2xl">
@csrf
@method('PUT')

<input type="text" name="type" placeholder="Type document (ex: Assurance)" required
class="w-full mb-4 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ old('type', $document->type) }}">

<label class="block text-sm font-medium text-gray-700 mb-2">Date d'émission</label>
<input type="date" name="date_emission" value="{{ old('date_emission', $document->date_emission ? $document->date_emission->format('Y-m-d') : '') }}" required
class="w-full mb-4 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">

<label class="block text-sm font-medium text-gray-700 mb-2">Date d'expiration</label>
<input type="date" name="date_expiration" value="{{ old('date_expiration', $document->date_expiration ? $document->date_expiration->format('Y-m-d') : '') }}" required
class="w-full mb-6 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">

<label class="block text-sm font-medium text-gray-700 mb-2">Fichier PDF/JPG/PNG (Laisser vide pour ne pas modifier)</label>
<input type="file" name="fichier" accept=".pdf,.jpg,.jpeg,.png"
class="w-full mb-6 p-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer">

<button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">💾 Modifier le document</button>

</form>

@endsection
