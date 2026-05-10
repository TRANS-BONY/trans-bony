<?php

$agent = __DIR__ . '/resources/views/layouts/agent.blade.php';
$contentAgent = file_get_contents($agent);

// Find where "Modules</p>" is
$pos = strpos($contentAgent, 'Modules</p>');
if ($pos !== false) {
    // Find the next </div>
    $divPos = strpos($contentAgent, '</div>', $pos);
    if ($divPos !== false) {
        // Insert right after this </div>
        $insertPos = $divPos + 6; // length of </div>
        
        $toInsert = '

                <!-- Voyages -->
                <a href="{{ route(\'agent.voyages\') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-blue-500/30 transition-all">
                        <i class="fas fa-route text-sm text-blue-300"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Voyages</span>
                </a>';
                
        // Only insert if not already there
        if (strpos($contentAgent, 'route(\'agent.voyages\')') === false) {
            $contentAgent = substr($contentAgent, 0, $insertPos) . $toInsert . substr($contentAgent, $insertPos);
            file_put_contents($agent, $contentAgent);
            echo "Added Voyages to Agent.\n";
        } else {
            echo "Voyages already in Agent.\n";
        }
    }
}

$comptable = __DIR__ . '/resources/views/layouts/comptable.blade.php';
$contentComptable = file_get_contents($comptable);

$pos = strpos($contentComptable, 'Modules</p>');
if ($pos !== false) {
    $divPos = strpos($contentComptable, '</div>', $pos);
    if ($divPos !== false) {
        $insertPos = $divPos + 6;
        
        $toInsert = '

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
                </a>';
                
        if (strpos($contentComptable, 'route(\'comptable.recettes.index\')') === false) {
            $contentComptable = substr($contentComptable, 0, $insertPos) . $toInsert . substr($contentComptable, $insertPos);
            file_put_contents($comptable, $contentComptable);
            echo "Added Recettes/Rapports to Comptable.\n";
        } else {
            echo "Recettes already in Comptable.\n";
        }
    }
}
