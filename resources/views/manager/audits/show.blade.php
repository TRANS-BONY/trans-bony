@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.audits.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-purple-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Détails de l'Audit #{{ $audit->id }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Utilisateur</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $audit->user_name ?? 'Système' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Action</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $audit->action }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Date & Heure</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $audit->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">IP / Contexte</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $audit->ip_address ?? 'N/A' }}</p>
            </div>
        </div>
        @if($audit->details)
        <div class="mt-8 pt-8 border-t border-gray-100">
            <p class="text-sm text-gray-500 mb-4">Données supplémentaires</p>
            <div class="bg-gray-50 p-4 rounded-xl font-mono text-sm overflow-x-auto text-gray-700">
                <pre>{{ is_array($audit->details) ? json_encode($audit->details, JSON_PRETTY_PRINT) : $audit->details }}</pre>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
