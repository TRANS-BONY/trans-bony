<?php

$appPath = __DIR__ . '/resources/views/layouts/app.blade.php';
$layoutPath = __DIR__ . '/resources/views/layouts/technicien.blade.php';

$app = file_get_contents($appPath);

$roleLinks = '
                <!-- Dashboard -->
                <a href="{{ route(\'technicien.dashboard\') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-orange-500/30 transition-all">
                        <i class="fas fa-tachometer-alt text-sm text-orange-300"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Tableau de bord</span>
                </a>

                <!-- Séparateur -->
                <div class="pt-4 pb-2">
                    <p class="text-xs uppercase tracking-widest text-orange-400/60 font-semibold px-1">Modules</p>
                </div>

                <!-- Véhicules -->
                <a href="{{ route(\'technicien.vehicules.index\') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-blue-500/30 transition-all">
                        <i class="fas fa-bus text-sm text-blue-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Véhicules</span>
                </a>

                <!-- Maintenances -->
                <a href="{{ route(\'technicien.maintenances.index\') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-amber-500/30 transition-all">
                        <i class="fas fa-tools text-sm text-amber-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Maintenances</span>
                </a>
';

preg_match('/(<div class=\"space-y-1\">)(.*?)(<\/div>\s+<!-- Info utilisateur)/s', $app, $appLinksMatch);

if($appLinksMatch) {
    $newContent = str_replace($appLinksMatch[2], "\n" . $roleLinks . "\n                ", $app);
    $newContent = str_replace('Tableau de bord Professionnel', 'Espace Technicien', $newContent);
    file_put_contents($layoutPath, $newContent);
    echo "technicien layout fixed!";
} else {
    echo "Could not find links block in app.blade.php";
}
