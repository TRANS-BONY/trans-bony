@extends('layouts.guest')

@section('content')

<div class="glass">

    <img src="/images/truck-icon.png" width="60">
    <h2 style="color:rgb(16, 15, 15);margin:10px 0;">Trans Bony</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" placeholder="Email" class="input" required>

        <input type="password" name="password" placeholder="Mot de passe" class="input" required>

        <button class="btn">SE CONNECTER</button>
    </form>

    <div style="margin-top:10px;">
        <a href="/register" class="text-blue-300">Créer un compte</a>
        <a href="/forgot-password" class="text-blue-300">Mot de passe oublié</a>
    </div>

</div>

@endsection
