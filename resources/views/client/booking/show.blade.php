<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver votre voyage - {{ $voyage->destination }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f3f4f6; }
        .booking-gradient { background: linear-gradient(135deg, #003580 0%, #00224f 100%); }
    </style>
</head>
<body class="antialiased pb-20">
    <nav class="booking-gradient text-white py-4 shadow-lg sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 flex items-center">
            <a href="/" class="mr-4 hover:opacity-80"><i class="fas fa-arrow-left"></i></a>
            <span class="text-xl font-bold tracking-tight">TRANS-BONY</span>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Side: Summary & Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Trip Summary Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-48 bg-gray-200">
                        <img src="{{ asset('img/vehicules/bus' . (($voyage->id % 4) + 1) . '.png') }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $voyage->destination }}</h1>
                                <p class="text-gray-500 font-medium">Billet Premium - TRANS-BONY SELECT</p>
                            </div>
                            <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-bold border border-blue-100">
                                Confirmé
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 pt-6 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Départ</p>
                                <p class="font-bold text-gray-800">{{ $voyage->date_depart->translatedFormat('d F Y') }}</p>
                                <p class="text-lg font-bold text-blue-600">{{ $voyage->date_depart->format('H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Véhicule</p>
                                <p class="font-bold text-gray-800">{{ $voyage->vehicule->modele ?? 'Bus Premium' }}</p>
                                <p class="text-sm text-gray-500">{{ $voyage->vehicule->immatriculation ?? 'X-XXX-XX' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Safety & Amenities -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-xl mb-4">À quoi s'attendre ?</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i> Climatisation intégrale
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i> Sièges inclinables
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i> Ports USB à chaque siège
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i> Bagages sécurisés
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Booking Form -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-xl border border-blue-100 sticky top-24">
                    <h3 class="font-bold text-xl mb-6">Réserver</h3>
                    
                    @if(session('error'))
                        <div class="mb-4 bg-red-50 text-red-600 p-3 rounded-lg text-sm font-medium border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('client.reserver') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="voyage_id" value="{{ $voyage->id }}">
                        
                        <!-- Client Info (Automated if logged in) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre de places</label>
                            <input type="number" name="nb_passagers" min="1" max="{{ $placesDispo }}" value="1" 
                                   class="w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 p-3 font-bold text-lg">
                            @error('nb_passagers') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre de colis</label>
                            <input type="number" name="nb_colis" min="0" value="0" 
                                   class="w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 p-3">
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-500 text-sm">Prix par personne</span>
                                <span class="font-bold text-gray-800">10 000 FCFA</span>
                            </div>
                            <div class="flex justify-between items-center font-bold text-xl text-blue-600">
                                <span>Total</span>
                                <span>{{ number_format(10000, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>

                        @auth
                            <!-- Assuming the client profile exists or we create one on the fly based on account info -->
                            @php
                                $client = \App\Models\Client::where('email', auth()->user()->email)->first();
                            @endphp
                            @if($client)
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <input type="hidden" name="montant" value="10000" id="total_field">
                                <input type="hidden" name="mode_paiement" value="en_attente">
                                
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition shadow-lg shadow-blue-200 text-lg">
                                    Réserver maintenant
                                </button>
                                <p class="text-[10px] text-center text-gray-400 mt-3">En réservant, vous acceptez nos CGV et notre politique de transport.</p>
                            @else
                                <div class="bg-amber-50 p-4 rounded-xl border border-amber-200 text-amber-800 text-sm">
                                    <i class="fas fa-info-circle mb-2"></i><br>
                                    Veuillez d'abord compléter votre profil passager pour pouvoir réserver en ligne.
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block text-center bg-gray-100 py-3 rounded-xl font-bold text-gray-700 hover:bg-gray-200 transition">Compléter profil</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="block w-full bg-amber-400 hover:bg-amber-500 text-gray-900 text-center font-bold py-4 rounded-xl transition shadow-lg shadow-amber-200 text-lg">
                                Se connecter pour réserver
                            </a>
                            <p class="text-[10px] text-center text-gray-400 mt-3">Créez un compte en 2 minutes pour gérer vos billets.</p>
                        @endauth
                    </form>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h4 class="font-bold text-sm mb-2 text-gray-800">Besoin d'aide ?</h4>
                    <p class="text-xs text-gray-500 mb-4">Notre support client est disponible 24h/24 pour vous accompagner dans votre réservation.</p>
                    <a href="tel:+22500000000" class="text-blue-600 font-bold text-sm hover:underline flex items-center gap-2">
                        <i class="fas fa-phone-alt"></i> +225 00 00 00 00
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Simple price calculator (Demo)
        const nbPassagers = document.querySelector('input[name="nb_passagers"]');
        const totalDisplay = document.querySelector('.text-blue-600 span:last-child');
        const totalField = document.getElementById('total_field');

        if(nbPassagers) {
            nbPassagers.addEventListener('input', (e) => {
                const total = e.target.value * 10000;
                totalDisplay.textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
                if(totalField) totalField.value = total;
            });
        }
    </script>
</body>
</html>
