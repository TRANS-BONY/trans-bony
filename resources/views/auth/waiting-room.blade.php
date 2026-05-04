@extends('layouts.guest')

@section('content')
<div class="form-container" style="max-width: 500px; text-align: center;">
    <div class="form-header">
        <div style="width: 80px; height: 80px; background: #fef3c7; border-radius: 50%; display: flex; items-center justify-center; margin: 0 auto 20px;">
            <i class="fas fa-hourglass-half text-amber-500" style="font-size: 32px; line-height: 80px;"></i>
        </div>
        <h1 class="form-title">Compte en attente</h1>
        <p class="form-desc" style="margin-top: 15px;">
            Bienvenue chez <strong>Trans Bony</strong>, {{ auth()->user()->name }}.
        </p>
    </div>

    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; margin: 25px 0; text-align: left;">
        <p style="color: #475569; font-size: 0.95rem; line-height: 1.6;">
            Votre inscription a été enregistrée avec succès. Cependant, pour des raisons de sécurité, un administrateur doit valider votre profil et vous assigner un rôle avant que vous ne puissiez accéder au tableau de bord.
        </p>
        <div style="margin-top: 15px; display: flex; gap: 10px; align-items: center;">
            <div style="width: 10px; height: 10px; background: #f59e0b; border-radius: 50%; animation: pulse 2s infinite;"></div>
            <span style="color: #f59e0b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Status : En attente de validation</span>
        </div>
    </div>

    <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 30px;">
        Vous recevrez un e-mail dès que votre compte sera activé.
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-submit" style="background: #ef4444; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);">
            <span>
                <i class="fas fa-sign-out-alt"></i>
                SE DÉCONNECTER
            </span>
        </button>
    </form>
</div>

<style>
@keyframes pulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
}
</style>
@endsection
