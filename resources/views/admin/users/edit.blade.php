@extends('layouts.app')

@section('content')

<h2 class="text-2xl mb-4">🛡️ Admin - Modifier Utilisateur</h2>

<div class="bg-white/10 p-6 rounded">

 <form method="POST" action="{{ route('admin.users.update',$user->id) }}">
@csrf
@method('PUT')

<input type="text" name="name" value="{{ $user->name }}" class="w-full p-2 mb-3 text-black rounded" required>
<input type="email" name="email" value="{{ $user->email }}" class="w-full p-2 mb-3 text-black rounded" required>

<select name="role_id" class="w-full p-2 mb-3 text-black rounded" required>
<option value="">Sélectionner un rôle</option>
@foreach($roles as $id => $name)
<option value="{{ $id }}" {{ $user->roles->first()?->id == $id ? 'selected' : '' }}>{{ $name }}</option>
@endforeach
</select>

<select name="is_active" class="w-full p-2 mb-3 text-black rounded">
<option value="1" {{ $user->is_active ? 'selected' : '' }}>Actif</option>
<option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactif</option>
</select>

<button class="bg-blue-500 px-4 py-2 rounded">
Modifier
</button>

</form>

</div>

@endsection

