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
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative connexion
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'login_error' => 'Vos identifiants sont incorrects',
            ])->withInput($request->only('email'));
        }

        // Régénérer session
        $request->session()->regenerate();

        // 🔥 REDIRECTION SELON ROLE
        $user = Auth::user();

        $role = $user->roles->first();
        if ($role) {
            $activeUserId = \Illuminate\Support\Facades\Cache::get('active_role_' . $role->name);
            
            if ($activeUserId && $activeUserId != $user->id) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'login_error' => "Un autre utilisateur avec le rôle " . ucfirst($role->name) . " est déjà connecté. Veuillez patienter jusqu'à sa déconnexion.",
                ]);
            }
            
            \Illuminate\Support\Facades\Cache::put('active_role_' . $role->name, $user->id, now()->addMinutes(2));
        }

        if (!$role) {
            return redirect()->route('waiting.room');
        }

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
        $user = Auth::user();
        if ($user) {
            $role = $user->roles->first();
            if ($role) {
                \Illuminate\Support\Facades\Cache::forget('active_role_' . $role->name);
            }
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
