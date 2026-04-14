@extends('layouts.app')

@section('content')

<h2 class="text-2xl mb-4">🛡️ Admin - Ajouter Utilisateur</h2>

<div class="bg-white/10 p-6 rounded">

 <form method="POST" action="{{ route('admin.users.store') }}">
@csrf

<input type="text" name="name" placeholder="Nom complet" class="w-full p-2 mb-3 text-black rounded" required>
<input type="email" name="email" placeholder="Email" class="w-full p-2 mb-3 text-black rounded" required>
<input type="password" name="password" placeholder="Mot de passe" class="w-full p-2 mb-3 text-black rounded" required>
<input type="password" name="password_confirmation" placeholder="Confirmer mot de passe" class="w-full p-2 mb-3 text-black rounded" required>

 <select name="role_id" class="w-full p-2 mb-3 text-black rounded" required>
<option value="">Sélectionner un rôle</option>
@foreach($roles as $id => $name)
<option value="{{ $id }}">{{ $name }}</option>
@endforeach
</select>

<select name="is_active" class="w-full p-2 mb-3 text-black rounded">
<option value="1">Actif</option>
<option value="0">Inactif</option>
</select>

<button class="bg-green-500 px-4 py-2 rounded">
Enregistrer
</button>

</form>

</div>

@endsection

