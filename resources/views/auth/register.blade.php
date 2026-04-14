@extends('layouts.guest')

@section('content')

<div class="glass">

    <h3 style="color:rgb(21, 20, 20);">Créer un compte</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="text" name="name" placeholder="Nom" class="input" required>

        <input type="email" name="email" placeholder="Email" class="input" required>

        <input type="password" name="password" placeholder="Mot de passe" class="input" required>

        <input type="password" name="password_confirmation" placeholder="Confirmer mot de passe" class="input" required>

        <button class="btn">Créer compte</button>
    </form>

</div>

@endsection
