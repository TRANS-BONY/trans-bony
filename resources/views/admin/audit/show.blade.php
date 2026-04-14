@extends('layouts.app')

@section('content')

<h1 class="text-xl font-bold mb-4">Détail Audit</h1>

<div class="bg-white p-4 rounded shadow">

<p><strong>Utilisateur :</strong> {{ $audit->user->name ?? 'Système' }}</p>
<p><strong>Action :</strong> {{ $audit->action }}</p>
<p><strong>Table :</strong> {{ $audit->table_name }}</p>

<p><strong>Anciennes valeurs :</strong></p>
<pre>{{ json_encode($audit->old_values, JSON_PRETTY_PRINT) }}</pre>

<p><strong>Nouvelles valeurs :</strong></p>
<pre>{{ json_encode($audit->new_values, JSON_PRETTY_PRINT) }}</pre>

<p><strong>IP :</strong> {{ $audit->ip_address }}</p>

</div>

@endsection
