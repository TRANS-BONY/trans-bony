<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Autorisation
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation des champs
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * Authentification utilisateur
     */
    public function authenticate(): void
    {
        // 🔒 Anti brute-force
        $this->ensureIsNotRateLimited();

        // 🔑 Tentative de connexion
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Identifiants incorrects.',
            ]);
        }

        // 🧠 Vérifier compte actif
        if (! Auth::user()->is_active) {

            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Votre compte est désactivé.',
            ]);
        }

        // ✅ Reset compteur tentative
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Limite de tentatives
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => "Trop de tentatives. Réessayez dans $seconds secondes.",
        ]);
    }

    /**
     * Clé unique
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
