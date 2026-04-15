@extends('layouts.guest')

@section('content')

<div class="form-container">

    {{-- Header --}}
    <div class="form-header">
        <p class="form-eyebrow">
            <i class="fas fa-lock" style="margin-right:6px;font-size:10px;"></i>
            Accès sécurisé
        </p>
        <h1 class="form-title">Connexion à votre<br>espace de travail</h1>
        <p class="form-desc">Entrez vos identifiants pour accéder au tableau de bord de gestion de flotte.</p>
    </div>

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

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}" id="login-form">
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
                    autocomplete="email"
                    autofocus
                >
            </div>
        </div>

        {{-- Password --}}
        <div class="input-group">
            <label for="password" class="input-label">Mot de passe</label>
            <div class="input-wrapper">
                <i class="fas fa-key input-icon"></i>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="auth-input"
                    placeholder="••••••••••••"
                    required
                    autocomplete="current-password"
                >
                <button
                    type="button"
                    class="pwd-toggle"
                    id="toggle-pwd"
                    aria-label="Afficher/masquer le mot de passe"
                    onclick="togglePassword()"
                >
                    <i class="fas fa-eye" id="pwd-icon"></i>
                </button>
            </div>
        </div>

        {{-- Remember + Forgot --}}
        <div class="form-meta">
            <label class="remember-label" for="remember_me">
                <input
                    type="checkbox"
                    id="remember_me"
                    name="remember"
                    class="remember-checkbox"
                >
                Se souvenir de moi
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Mot de passe oublié&nbsp;?
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-submit" id="submit-btn">
            <span>
                <i class="fas fa-arrow-right-to-bracket"></i>
                SE CONNECTER
            </span>
        </button>
    </form>



    {{-- Footer --}}
    <div class="form-footer">
        <p>&copy; {{ date('Y') }} Trans Bony &mdash; Tous droits réservés</p>
    </div>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('pwd-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Loading state on submit
    document.getElementById('login-form').addEventListener('submit', function() {
        const btn  = document.getElementById('submit-btn');
        btn.innerHTML = '<span><i class="fas fa-circle-notch fa-spin"></i> Connexion en cours…</span>';
        btn.disabled = true;
        btn.style.opacity = '0.8';
    });
</script>

@endsection
