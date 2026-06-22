<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Voyages - TRANS-BONY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .booking-gradient { background: linear-gradient(135deg, #003580 0%, #00224f 100%); }
    </style>
</head>
<body class="antialiased">
    <nav class="booking-gradient text-white py-4 shadow-lg">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold tracking-tight">TRANS-BONY</a>
            <div class="flex gap-4 items-center">
                <span class="text-sm font-medium opacity-80">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-xs bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded transition">Déconnexion</button></form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900">Mes Voyages</h1>
            <p class="text-gray-500">Retrouvez ici tous vos billets et l'historique de vos déplacements.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-100 p-4 rounded-2xl text-green-700 flex items-center gap-3">
                <i class="fas fa-check-circle text-xl"></i>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            @forelse($reservations as $r)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                    <!-- Ticket Left (Main Info) -->
                    <div class="p-8 flex-1">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <span class="bg-blue-100 text-blue-700 text-[10px] font-black uppercase px-2 py-1 rounded mb-2 inline-block">Billet {{ $r->statut }}</span>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $r->voyage->destination }}</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Numéro de billet</p>
                                <p class="font-mono font-bold text-blue-600">{{ $r->numero_billet }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Date</p>
                                <p class="font-bold text-gray-800">{{ $r->voyage->date_depart->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Départ</p>
                                <p class="font-bold text-gray-800">{{ $r->voyage->date_depart->format('H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Passagers</p>
                                <p class="font-bold text-gray-800">{{ $r->nb_passagers }} PERS</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Véhicule</p>
                                <p class="font-bold text-gray-800">{{ $r->voyage->vehicule->immatriculation ?? 'Trans-Bony' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Right (Actions) -->
                    <div class="bg-gray-50 border-l border-gray-100 p-8 flex flex-col justify-center gap-3 w-full md:w-64">
                        <a href="{{ route('agent.reservations.ticket', $r->id) }}" target="_blank" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-blue-100">
                            <i class="fas fa-file-pdf"></i> Imprimer Billet
                        </a>
                        <button class="flex items-center justify-center gap-2 bg-white hover:bg-gray-100 text-gray-700 font-bold py-3 rounded-xl transition border border-gray-200">
                            <i class="fas fa-info-circle"></i> Détails Voyage
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white p-20 text-center rounded-2xl border-2 border-dashed border-gray-200">
                    <img src="https://illustrations.popsy.co/blue/traveling.svg" class="w-48 mx-auto mb-6">
                    <h3 class="text-gray-400 font-bold text-xl mb-2">Vous n'avez pas encore de voyage ?</h3>
                    <p class="text-gray-400 mb-6">Explorez nos destinations et réservez votre première place !</p>
                    <a href="{{ route('welcome') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg shadow-blue-200">
                        Trouver un voyage
                    </a>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>
