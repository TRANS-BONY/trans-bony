@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up">
    <!-- Header Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 shadow-2xl">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="relative p-8 md:p-12 flex flex-col md:flex-row items-center gap-8">
            <div class="relative group">
                <div class="w-32 h-32 rounded-full ring-4 ring-white/30 shadow-xl overflow-hidden bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <i class="fas fa-user-astronaut text-6xl text-white"></i>
                </div>
                <div class="absolute inset-0 rounded-full bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                    <i class="fas fa-camera text-white text-xl"></i>
                </div>
            </div>
            
            <div class="text-center md:text-left flex-1">
                <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2">Mon Profil</h1>
                <p class="text-blue-100 text-lg max-w-2xl">
                    Gérez les paramètres de votre compte, sécurisez vos accès et personnalisez votre expérience sur Trans Bony.
                </p>
                
                <div class="mt-4 inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-white text-sm font-semibold border border-white/20">
                    <i class="fas fa-shield-alt text-green-300"></i>
                    Compte Sécurisé
                </div>
            </div>
        </div>
    </div>

    <!-- Forms Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Navigation / Summary (Optional extra flair) -->
        <div class="lg:col-span-4 space-y-6 hidden lg:block">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 border border-gray-100 dark:border-gray-700 sticky top-24">
                <h3 class="text-gray-900 dark:text-white font-bold text-xl mb-6">Menu Rapide</h3>
                <nav class="space-y-2">
                    <a href="#info" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold transition hover:bg-blue-100">
                        <i class="fas fa-id-card w-5 text-center"></i> Informations
                    </a>
                    <a href="#security" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 dark:text-gray-300 font-semibold transition hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <i class="fas fa-lock w-5 text-center"></i> Sécurité
                    </a>
                    <a href="#danger" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-red-500 font-semibold transition hover:bg-red-50 dark:hover:bg-red-900/20 mt-4 border border-transparent hover:border-red-100">
                        <i class="fas fa-exclamation-triangle w-5 text-center"></i> Zone de danger
                    </a>
                </nav>
            </div>
        </div>

        <!-- Right Column: Settings Cards -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Informations Card -->
            <div id="info" class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 transition duration-300 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <i class="fas fa-user-edit text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informations Personnelles</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mettez à jour vos informations de base et votre adresse email.</p>
                    </div>
                </div>
                <div class="p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Card -->
            <div id="security" class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 transition duration-300 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <i class="fas fa-key text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Sécurité du compte</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.</p>
                    </div>
                </div>
                <div class="p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div id="danger" class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-red-100 dark:border-red-900/30 transition duration-300 hover:shadow-2xl hover:border-red-200">
                <div class="bg-gradient-to-r from-red-50 to-white dark:from-red-900/10 dark:to-gray-800/50 px-8 py-6 border-b border-red-100 dark:border-red-900/20 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center text-red-600 dark:text-red-400">
                        <i class="fas fa-trash-alt text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Zone de Danger</h2>
                        <p class="text-sm text-gray-500 dark:text-red-400/80">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.</p>
                    </div>
                </div>
                <div class="p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    /* Clean up the default Breeze inputs when inside our beautiful cards */
    .bg-white section header h2 {
        display: none; /* Hide duplicate headers since we built our own card headers */
    }
    .bg-white section header p {
        display: none; /* Hide duplicate descriptions */
    }
    
    .dark .bg-gray-800 section header h2, .dark .bg-gray-800 section header p {
        display: none;
    }
</style>
@endsection
