@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-700 via-gray-700 to-zinc-800 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-search text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Détail de l'Audit</h1>
                    <p class="text-gray-300 text-sm mt-1">Examen approfondi de l'action #{{ $audit->id }}</p>
                </div>
            </div>
            <a href="{{ route('admin.audits.index') }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all flex items-center gap-2 backdrop-blur-sm">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <!-- Infos Générales -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                    <i class="fas fa-info-circle text-slate-500"></i> Informations
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Utilisateur</p>
                        <p class="text-sm font-semibold">{{ $audit->user->name ?? 'Système' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Action</p>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                            {{ $audit->action }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Date & Heure</p>
                        <p class="text-sm font-semibold">{{ $audit->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Cible</p>
                        <p class="text-sm font-semibold">{{ $audit->table_name }} (ID: {{ $audit->record_id }})</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                    <i class="fas fa-network-wired text-slate-500"></i> Métadonnées
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Adresse IP</p>
                        <p class="text-sm font-semibold font-mono">{{ $audit->ip_address }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Agent Utilisateur</p>
                        <p class="text-xs text-gray-500 break-words">{{ $audit->user_agent }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Valeurs Modifiées -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                    <i class="fas fa-exchange-alt text-blue-500"></i> Changements
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-2">Anciennes Valeurs</p>
                        <div class="bg-gray-900 rounded-xl p-4 overflow-auto max-h-96">
                            <pre class="text-[10px] text-emerald-400 font-mono">{{ json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-2">Nouvelles Valeurs</p>
                        <div class="bg-gray-900 rounded-xl p-4 overflow-auto max-h-96">
                            <pre class="text-[10px] text-blue-400 font-mono">{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>
@endsection
