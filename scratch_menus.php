<?php

$files = [
    'agent.blade.php' => [
        'insert_after' => 'text-blue-400/60 font-semibold px-1">Modules</p>
                </div>',
        'content' => '
                <!-- Voyages -->
                <a href="{{ route(\'agent.voyages\') }}" class="nav-item flex items-center space-x-3 px-4 py-3 text-white/90 hover:text-white group nav-fluid-hover" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 group-hover:bg-blue-500/30 transition-all">
                        <i class="fas fa-route text-sm text-amber-400"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">Voyages</span>
                </a>
'
    ],
    'comptable.blade.php' => [
        'insert_after' => 'text-teal-400/60 font-semibold px-1">Modules</p>
                </div>',
        'content' => '
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
                </a>
'
    ]
];

$dir = __DIR__ . '/resources/views/layouts/';

foreach ($files as $filename => $data) {
    $path = $dir . $filename;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        if (strpos($content, 'href="{{ route(\'agent.voyages\') }}"') === false && strpos($content, 'href="{{ route(\'comptable.recettes.index\') }}"') === false) {
            $content = str_replace($data['insert_after'], $data['insert_after'] . "\n" . $data['content'], $content);
            file_put_contents($path, $content);
            echo "Updated $filename modules\n";
        }
    }
}

// Add logout button to all layouts at the end of sidebar menu (before the mobile user info)
$layouts = ['app.blade.php', 'manager.blade.php', 'agent.blade.php', 'comptable.blade.php', 'technicien.blade.php'];
$logoutBtn = '
                <!-- Déconnexion -->
                <div class="pt-4 mt-4 border-t border-white/20 dark:border-gray-700">
                    <form method="POST" action="{{ route(\'logout\') }}">
                        @csrf
                        <button type="submit" class="w-full nav-item flex items-center space-x-3 px-4 py-3 text-red-400 hover:text-red-300 group nav-fluid-hover transition" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-red-500/10 scale-[1.02] floating-fast\' : \'\'">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-500/10 group-hover:bg-red-500/30 transition-all">
                                <i class="fas fa-sign-out-alt text-sm"></i>
                            </div>
                            <span class="flex-1 text-sm font-medium text-left">Déconnexion</span>
                        </button>
                    </form>
                </div>
';

foreach ($layouts as $filename) {
    $path = $dir . $filename;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        // Find the place right before "<!-- Info utilisateur dans sidebar (visible sur mobile) -->"
        // Wait, some have </div> before it. Let's just replace `<!-- Info utilisateur dans sidebar (visible sur mobile) -->`
        if (strpos($content, 'Déconnexion') === false || strpos($content, 'bg-red-500/10') === false) {
            $search = '<!-- Info utilisateur dans sidebar (visible sur mobile) -->';
            if (strpos($content, $search) !== false) {
                // Ensure we don't insert it multiple times. Wait, if it has 'Déconnexion' inside the sidebar it's fine.
                // We will just do a str_replace:
                $content = str_replace($search, $logoutBtn . "\n                " . $search, $content);
                file_put_contents($path, $content);
                echo "Added logout button to $filename\n";
            }
        }
    }
}
