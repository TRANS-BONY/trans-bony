@extends('layouts.app')

@section('content')

<h2 class="text-xl mb-4">Modifier Voyage</h2>

action="{{ route('admin.voyages.update',$voyage->id) }}"
class="bg-white/10 p-6 rounded">
@csrf
@method('PUT')

<input type="text" name="destination"
value="{{ $voyage->destination }}"
class="w-full p-2 mb-3 text-black rounded">

<input type="datetime-local" name="date_depart"
value="{{ $voyage->date_depart }}"
class="w-full p-2 mb-3 text-black rounded">

<button class="bg-blue-500 px-4 py-2 rounded">Modifier</button>

</form>

@endsection
