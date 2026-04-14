@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 md:p-12 text-center border border-gray-100 dark:border-gray-700">
        <div class="w-24 h-24 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-cogs text-5xl text-blue-500 dark:text-blue-400"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Paramètres de l'application</h2>
        <p class="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
            Cette section est actuellement en cours de construction. Bientôt, vous pourrez modifier les préférences de votre système, les notifications et d'autres paramètres avancés ici.
        </p>
        <div class="mt-8">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-all transform hover:-translate-y-1">
                <i class="fas fa-arrow-left"></i>
                Retour au Tableau de bord
            </a>
        </div>
    </div>
</div>
@endsection
