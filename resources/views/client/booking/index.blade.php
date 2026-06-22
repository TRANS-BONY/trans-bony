<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trans-Bony - Réservez votre prochain voyage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f3f4f6; }
        .booking-gradient { background: linear-gradient(135deg, #003580 0%, #00224f 100%); }
    </style>
</head>
<body class="antialiased">
    <!-- Navbar -->
    <nav class="booking-gradient text-white py-4 shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold tracking-tight">TRANS-BONY</a>
            <div class="flex gap-6 items-center">
                @auth
                    <a href="{{ route('client.dashboard') }}" class="text-sm font-semibold hover:underline">Mes réservations</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg text-sm transition">Déconnexion</button></form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:underline">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-lg text-sm font-bold transition shadow-lg">S'inscrire</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero / Search bar -->
    <div class="booking-gradient pb-20 pt-10 px-4">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Trouvez votre prochain voyage</h1>
            <p class="text-blue-100 text-lg mb-8">Recherchez parmi nos destinations pour un voyage confortable et sécurisé.</p>
            
            <!-- Search Form -->
            <form action="{{ route('voyages.recherche') }}" method="GET" class="bg-amber-400 p-1 rounded-xl shadow-2xl flex flex-col md:flex-row gap-1">
                <div class="flex-1 bg-white rounded-lg flex items-center px-4 py-3">
                    <i class="fas fa-location-dot text-gray-400 mr-3"></i>
                    <select name="destination" class="w-full border-none focus:ring-0 text-gray-700 font-medium bg-transparent">
                        <option value="">Où allez-vous ?</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest }}" {{ request('destination') == $dest ? 'selected' : '' }}>{{ $dest }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 bg-white rounded-lg flex items-center px-4 py-3">
                    <i class="fas fa-calendar text-gray-400 mr-3"></i>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full border-none focus:ring-0 text-gray-700 font-medium">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-3 rounded-lg transition text-lg">Rechercher</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 -mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <aside class="hidden lg:block space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg mb-4">Filtrer par</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-blue-600">
                            <input type="checkbox" class="rounded text-blue-600"> Direct uniquement
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-blue-600">
                            <input type="checkbox" class="rounded text-blue-600"> Climatisation
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-blue-600">
                            <input type="checkbox" class="rounded text-blue-600"> Wifi à bord
                        </label>
                    </div>
                </div>
            </aside>

            <!-- Results -->
            <div class="lg:col-span-3 space-y-6 mb-20">
                <h2 class="text-2xl font-bold text-gray-800">{{ $voyages->total() }} voyages trouvés</h2>
                
                @forelse($voyages as $v)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-64 h-48 bg-gray-200 shrink-0 relative overflow-hidden">
                                <img src="{{ asset('img/vehicules/bus' . (($v->id % 4) + 1) . '.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div class="absolute top-2 left-2 bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded">TRANS-BONY SELECT</div>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $v->destination }}</h3>
                                        <p class="text-sm text-green-600 font-semibold mt-1">Départ : {{ $v->date_depart->translatedFormat('d F Y') }} à {{ $v->date_depart->format('H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center gap-1 text-blue-600">
                                            <span class="text-xs font-bold uppercase tracking-tight">Excellent</span>
                                            <span class="bg-blue-600 text-white text-sm font-bold px-2 py-1 rounded-lg">8.9</span>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-1">42 avis vérifiés</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 flex flex-col md:flex-row md:items-end justify-between gap-4">
                                    <div class="space-y-1">
                                        <p class="text-xs text-gray-500"><i class="fas fa-bus mr-1"></i> {{ $v->vehicule->modele ?? 'Bus Premium' }}</p>
                                        <p class="text-xs text-gray-500"><i class="fas fa-wifi mr-1"></i> Wifi gratuit • USB à bord</p>
                                        <p class="text-xs text-red-600 font-bold">Plus que {{ $v->vehicule->capacite - $v->reservations->sum('nb_passagers') }} places disponibles !</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Par passager</p>
                                        <p class="text-2xl font-bold text-gray-900">10 000 FCFA</p>
                                        <p class="text-[10px] text-gray-400 mb-2">Taxes et frais inclus</p>
                                        <a href="{{ route('voyages.details', $v->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-lg shadow-blue-200">
                                            Voir disponibilité
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-20 text-center rounded-2xl border-2 border-dashed border-gray-200">
                        <i class="fas fa-search-minus text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 font-medium">Aucun voyage ne correspond à votre recherche.</p>
                        <a href="{{ route('welcome') }}" class="text-blue-600 font-bold hover:underline mt-2 inline-block">Voir tous les départs</a>
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $voyages->links() }}
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-12 mt-20 px-4">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 text-gray-600">
            <div class="space-y-4">
                <h4 class="font-bold text-gray-900">TRANS-BONY</h4>
                <p class="text-sm">Votre partenaire de confiance pour tous vos voyages inter-urbains et la logistique de marchandises.</p>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Liens Utiles</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="#" class="hover:text-blue-600">Aide & Support</a></li>
                    <li><a href="#" class="hover:text-blue-600">Conditions d'utilisation</a></li>
                    <li><a href="#" class="hover:text-blue-600">Politique de confidentialité</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Support</h4>
                <ul class="text-sm space-y-2">
                    <li><i class="fas fa-phone mr-2"></i> +225 00 00 00 00</li>
                    <li><i class="fas fa-envelope mr-2"></i> support@transbony.com</li>
                </ul>
            </div>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-black hover:text-white transition"><i class="fab fa-x-twitter"></i></a>
            </div>
        </div>
        <div class="max-w-6xl mx-auto pt-8 mt-8 border-t border-gray-100 text-center text-xs text-gray-400">
            © 2026 TRANS-BONY LOGISTICS. Tous droits réservés. Design Inspiré.
        </div>
    </footer>
</body>
</html>
