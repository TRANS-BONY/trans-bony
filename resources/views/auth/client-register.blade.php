<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Créer un compte Client</h2>
        <p class="text-sm text-gray-600 mt-2">Rejoignez-nous pour réserver rapidement vos prochains voyages.</p>
    </div>

    <form method="POST" action="{{ route('client.register.post') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom et Prénom')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" href="{{ route('client.login') }}">
                Déjà inscrit ?
            </a>

            <x-primary-button class="ms-4 bg-orange-600 hover:bg-orange-700">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
