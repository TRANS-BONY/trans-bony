<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ClientAuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion client.
     */
    public function showLoginForm(): View
    {
        return view('auth.client-login');
    }

    /**
     * Affiche le formulaire d'inscription client.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.client-register');
    }

    /**
     * Crée un compte client.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assigner le rôle client
        $user->assignRole('client');
        $user->update(['actif' => 1]); // Client toujours actif directement

        // Créer un profil client
        \App\Models\Client::create([
            'nom' => $request->name,
            'email' => $request->email,
            'type' => 'passager',
            'telephone' => 'A renseigner', 
        ]);

        event(new Registered($user));

        // Connecter automatiquement et rediriger vers l'espace client
        Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'Bienvenue sur votre espace personnel.');
    }

    /**
     * Gère la connexion client.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (auth()->user()->hasRole('client')) {
                return redirect()->intended(route('client.dashboard'));
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Cette interface de connexion est réservée aux clients. Veuillez utiliser l\'accès staff.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }
}
