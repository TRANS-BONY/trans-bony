@extends('layouts.guest')

@section('content')
<div class="form-container">
    {{-- Header --}}
    <div class="form-header">
        <div style="width: 60px; height: 60px; background: #eff6ff; border-radius: 20px; display: flex; items-center justify-center; margin: 0 auto 20px;">
            <i class="fas fa-key text-blue-600" style="font-size: 24px; line-height: 60px;"></i>
        </div>
        <h1 class="form-title">Mot de passe oublié</h1>
        <p class="form-desc">Pas de problème. Indiquez-nous votre adresse e-mail et nous vous enverrons un lien de réinitialisation.</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div style="background: #ecfdf5; border: 1px solid #10b981; color: #065f46; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 500;">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('status') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Email --}}
        <div class="input-group">
            <label for="email" class="input-label">Adresse e-mail</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope input-icon"></i>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="auth-input"
                    placeholder="nom@entreprise.com"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-submit">
            <span>
                <i class="fas fa-paper-plane"></i>
                ENVOYER LE LIEN
            </span>
        </button>

        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ route('login') }}" style="color: #64748b; font-size: 0.875rem; text-decoration: none; font-weight: 500;">
                <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
            </a>
        </div>
    </form>
</div>
@endsection
