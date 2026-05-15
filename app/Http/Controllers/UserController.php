<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // Supprimé pour permettre l'accès au manager via web.php
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $search = request('search');
        $users = User::when($search, function($q) use ($search) {
            return $q->where(function($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%")
                ;
            });
        })->with('roles')->orderBy('created_at', 'desc')->paginate(10)->appends(request()->query());

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $view = 'admin.users.index';
        if ($role === 'manager') $view = 'manager.users.index';

        return view($view, compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z]/',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z][a-zA-Z0-9._%+-]*@(gmail\.com|transbony\.com)$/i'],
            'password' => ['required', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'boolean',
        ], [
            'name.regex' => 'Le nom doit commencer par une lettre.',
            'email.lowercase' => 'L\'adresse e-mail doit être en minuscules.',
            'email.regex' => 'L\'adresse e-mail doit commencer par une lettre, sans espaces, et se terminer par @gmail.com ou @transbony.com.',
            'password.mixed' => 'Le mot de passe doit contenir au moins une lettre majuscule et une lettre minuscule.',
            'password.letters' => 'Le mot de passe doit contenir au moins une lettre.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un symbole.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->boolean('is_active', true),
        ]);

        $user->roles()->sync([$request->role_id]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $view = 'admin.users.show';
        if ($role === 'manager') $view = 'manager.users.show';

        return view($view, compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');
        $user->load('roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'is_active' => $request->is_active,
        ]);

        $user->roles()->sync([$request->role_id]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur (Rôle & Statut) mis à jour avec succès.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}

