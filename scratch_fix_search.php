<?php

$dirs = ['manager', 'agent', 'comptable', 'gestionnaire', 'technicien'];

$searchBlockRegex = '/\s*<!-- Barre de recherche injectée -->\s*<div class="mb-4">\s*<form method="GET" class="relative shadow-sm rounded-xl overflow-hidden">\s*<i class="fas fa-search absolute left-4 top-1\/2 -translate-y-1\/2 text-gray-400"><\/i>\s*<input type="text" name="search" placeholder="Rechercher\.\.\." value="\{\{ request\(\'search\'\) \}\}"\s*class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">\s*<\/form>\s*<\/div>/s';

$searchBlockToInsert = '
    <!-- Barre de recherche injectée -->
    <div class="mb-4">
        <form method="GET" class="relative shadow-sm rounded-xl overflow-hidden">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request(\'search\') }}"
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
        </form>
    </div>
';

foreach ($dirs as $dir) {
    $path = __DIR__ . "/resources/views/$dir/*/*.blade.php";
    foreach (glob($path) as $file) {
        $content = file_get_contents($file);
        
        // Count existing injected bars
        $count = preg_match_all($searchBlockRegex, $content);
        
        if ($count > 0) {
            // Remove all
            $content = preg_replace($searchBlockRegex, '', $content);
            
            // Re-insert once after the header.
            // The header typically looks like:
            // <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            //     ...
            // </div>
            // We can match:
            // </div>
            // 
            // <div class="list-scroll-container
            // OR
            // <div class="bg-white
            
            $content = preg_replace('/(<\/div>)\s*(<div class="list-scroll-container|<div class="bg-white|<div class="grid|<table)/s', '$1' . $searchBlockToInsert . '$2', $content, 1);
            
            file_put_contents($file, $content);
            echo "Fixed $file (removed $count, inserted 1)\n";
        }
    }
}
