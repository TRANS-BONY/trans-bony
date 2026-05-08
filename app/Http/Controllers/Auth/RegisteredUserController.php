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
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[^0-9]*$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class, 'regex:/^[a-z0-9._%+-]+@(gmail\.com|transbony\.com)$/i'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.regex' => 'Le nom ne doit pas contenir de chiffres.',
            'email.email' => 'L\'adresse e-mail doit impérativement contenir le symbole "@".',
            'email.regex' => 'L\'adresse mail doit utiliser les domaines @gmail.com ou @transbony.com',
            'email.unique' => 'Cette adresse e-mail est déjà enregistrée.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // ❌ Ne pas connecter l'utilisateur automatiquement :
        // il doit attendre la validation de l'administrateur.
        // Auth::login($user) est volontairement supprimé.

        return redirect()->route('login')
            ->with('status', 'Votre compte a été créé avec succès. Veuillez attendre que l\'administrateur valide votre accès avant de vous connecter.');
    }
}
