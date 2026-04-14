<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        // Tentative connexion
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects',
            ]);
        }

        // Régénérer session
        $request->session()->regenerate();

        // 🔥 REDIRECTION SELON ROLE
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect('/dashboard');
        }

        if ($user->hasRole('gestionnaire')) {
            return redirect('/dashboard');
        }

        if ($user->hasRole('agent')) {
            return redirect('/dashboard');
        }

        if ($user->hasRole('technicien')) {
            return redirect('/dashboard');
        }

        if ($user->hasRole('comptable')) {
            return redirect('/dashboard');
        }

        // fallback
        return redirect('/dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
