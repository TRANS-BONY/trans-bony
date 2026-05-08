@extends('layouts.guest')

@section('content')
<div class="form-container">
    {{-- Header --}}
    <div class="form-header">
        <div style="width: 60px; height: 60px; background: rgba(59, 130, 246, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fas fa-unlock-keyhole" style="font-size: 24px; color: var(--primary);"></i>
        </div>
        <h1 class="form-title">Nouveau mot de passe</h1>
        <p class="form-desc">Veuillez entrer votre nouveau mot de passe pour sécuriser votre compte.</p>
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

    <form method="POST" action="{{ route('password.store') }}" id="reset-form">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                    value="{{ old('email', $request->email) }}"
                    required
                    readonly
                    style="color: rgba(255,255,255,0.5);"
                >
            </div>
        </div>

        {{-- Password --}}
        <div class="input-group">
            <label for="password" class="input-label">Nouveau mot de passe</label>
            <div class="input-wrapper">
                <i class="fas fa-lock input-icon"></i>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="auth-input @error('password') is-invalid @enderror"
                    placeholder="••••••••••••"
                    required
                    autocomplete="new-password"
                    autofocus
                >
                <button
                    type="button"
                    class="pwd-toggle"
                    onclick="togglePassword('password', 'pwd-icon-1')"
                >
                    <i class="fas fa-eye" id="pwd-icon-1"></i>
                </button>
            </div>
        </div>

        {{-- Confirm Password --}}
        <div class="input-group">
            <label for="password_confirmation" class="input-label">Confirmer le mot de passe</label>
            <div class="input-wrapper">
                <i class="fas fa-lock input-icon"></i>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="auth-input @error('password_confirmation') is-invalid @enderror"
                    placeholder="••••••••••••"
                    required
                    autocomplete="new-password"
                >
                <button
                    type="button"
                    class="pwd-toggle"
                    onclick="togglePassword('password_confirmation', 'pwd-icon-2')"
                >
                    <i class="fas fa-eye" id="pwd-icon-2"></i>
                </button>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-submit" id="submit-btn">
            <span>
                <i class="fas fa-check-circle"></i>
                RÉINITIALISER LE MOT DE PASSE
            </span>
        </button>
    </form>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.getElementById('reset-form').addEventListener('submit', function() {
        const btn  = document.getElementById('submit-btn');
        btn.innerHTML = '<span><i class="fas fa-circle-notch fa-spin"></i> Traitement en cours...</span>';
        btn.disabled = true;
        btn.style.opacity = '0.8';
    });
</script>
@endsection
