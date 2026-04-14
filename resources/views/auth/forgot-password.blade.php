@extends('layouts.guest')

@section('content')

<div class="glass">

    <h3 style="color:rgb(21, 20, 20);">Mot de passe oublié</h3>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <input type="email" name="email" placeholder="Entrer votre email" class="input" required>

        <button class="btn">Envoyer lien</button>
    </form>

</div>

@endsection
