<?php

$agent = __DIR__ . '/resources/views/layouts/agent.blade.php';
$contentAgent = file_get_contents($agent);
$contentAgent = preg_replace('/<!-- S.parateur -->\s*<div class="pt-4 pb-2">\s*<p class="text-xs uppercase tracking-widest text-blue-400\/60 font-semibold px-1">Modules<\/p>\s*<\/div>/', '<!-- Séparateur -->
                <div class="pt-4 pb-2">
                    <p class="text-xs uppercase tracking-widest text-blue-400/60 font-semibold px-1">Modules</p>
                </div>

                <!-- Voyages -->
                <a href="{{ route(\'agent.voyages\') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-blue-500/30 transition-all">
                        <i class="fas fa-route text-sm text-blue-300"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Voyages</span>
                </a>', $contentAgent);
file_put_contents($agent, $contentAgent);
echo "Fixed agent\n";

$comptable = __DIR__ . '/resources/views/layouts/comptable.blade.php';
$contentComptable = file_get_contents($comptable);
$contentComptable = preg_replace('/<!-- S.parateur -->\s*<div class="pt-4 pb-2">\s*<p class="text-xs uppercase tracking-widest text-teal-400\/60 font-semibold px-1">Modules<\/p>\s*<\/div>/', '<!-- Séparateur -->
                <div class="pt-4 pb-2">
                    <p class="text-xs uppercase tracking-widest text-teal-400/60 font-semibold px-1">Modules</p>
                </div>

                <!-- Recettes -->
                <a href="{{ route(\'comptable.recettes.index\') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-teal-500/30 transition-all">
                        <i class="fas fa-coins text-sm text-green-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Recettes</span>
                </a>

                <!-- Rapports -->
                <a href="{{ route(\'comptable.rapports.index\') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-teal-500/30 transition-all">
                        <i class="fas fa-chart-bar text-sm text-emerald-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Rapports</span>
                </a>', $contentComptable);
file_put_contents($comptable, $contentComptable);
echo "Fixed comptable\n";
