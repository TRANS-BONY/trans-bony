@extends('layouts.guest')

@section('content')

<div class="form-container">

    {{-- Header --}}
    <div class="form-header">
        <p class="form-eyebrow">
            <i class="fas fa-user-plus" style="margin-right:6px;font-size:10px;"></i>
            Nouveau membre
        </p>
        <h1 class="form-title">Rejoindre la plateforme<br>Trans Bony</h1>
        <p class="form-desc">Créez votre compte pour commencer à gérer votre activité de transport.</p>
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

    {{-- Registration Form --}}
    <form method="POST" action="{{ route('register') }}" id="register-form">
        @csrf

        {{-- Name --}}
        <div class="input-group">
            <label for="name" class="input-label">Nom complet</label>
            <div class="input-wrapper">
                <i class="fas fa-user input-icon"></i>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="auth-input @error('name') is-invalid @enderror"
                    placeholder="JEAN DUPONT"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    pattern="[A-ZÀ-ÿ][A-ZÀ-ÿ\s\'-]*"
                    title="Le nom doit commencer par une lettre et ne peut contenir que des lettres, des espaces, des tirets ou des apostrophes."
                >
                @error('name')
                    <span class="inline-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="input-group">
            <label for="email" class="input-label">Adresse e-mail</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope input-icon"></i>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="auth-input @error('email') is-invalid @enderror"
                    placeholder="utilisateur@gmail.com ou @transbony.com"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                >
                @error('email')
                    <span class="inline-error">{{ $message }}</span>
                @enderror
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
                    class="auth-input @error('password') is-invalid @enderror"
                    placeholder="••••••••••••"
                    required
                    autocomplete="new-password"
                >
                @error('password')
                    <span class="inline-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Confirm Password --}}
        <div class="input-group">
            <label for="password_confirmation" class="input-label">Confirmer le mot de passe</label>
            <div class="input-wrapper">
                <i class="fas fa-shield-check input-icon"></i>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="auth-input"
                    placeholder="••••••••••••"
                    required
                    autocomplete="new-password"
                >
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-submit" id="submit-btn">
            <span>
                <i class="fas fa-user-plus"></i>
                CRÉER MON COMPTE
            </span>
        </button>

        {{-- Login Link --}}
        <div style="text-align: center; margin-top: 25px;">
            <p style="color: #64748b; font-size: 0.875rem;">
                Déjà inscrit ? 
                <a href="{{ route('login') }}" style="color: #3b82f6; font-weight: 600; text-decoration: none; border-bottom: 1px dashed #3b82f6; transition: all 0.2s ease;" onmouseover="this.style.color='#2563eb'; this.style.borderBottomStyle='solid';" onmouseout="this.style.color='#3b82f6'; this.style.borderBottomStyle='dashed';">
                    Se connecter
                </a>
            </p>
        </div>
    </form>

    {{-- Footer --}}
    <div class="form-footer">
        <p>&copy; {{ date('Y') }} Trans Bony &mdash; Tous droits réservés</p>
    </div>

</div>

<script>
    // Name validation and formatting
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function(e) {
        let value = e.target.value.toUpperCase();
        
        // Filter allowed characters: letters, space, hyphen, apostrophe
        value = value.replace(/[^A-ZÀ-ÿ\s\'-]/g, '');

        // Ensure it starts with a letter (strip non-letters from the beginning)
        while (value.length > 0 && !/[A-ZÀ-ÿ]/.test(value[0])) {
            value = value.substring(1);
        }
        
        e.target.value = value;
    });

    // Loading state on submit
    document.getElementById('register-form').addEventListener('submit', function() {
        const btn  = document.getElementById('submit-btn');
        btn.innerHTML = '<span><i class="fas fa-circle-notch fa-spin"></i> Création en cours…</span>';
        btn.disabled = true;
        btn.style.opacity = '0.8';
    });
</script>

@endsection
