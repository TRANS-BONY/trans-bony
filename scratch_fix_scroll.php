<?php

$files = [
    'resources/views/agent/voyage/index.blade.php',
    'resources/views/comptable/rapports/index.blade.php',
    'resources/views/comptable/recettes/index.blade.php',
    'resources/views/manager/audits/index.blade.php',
    'resources/views/manager/chauffeurs/index.blade.php',
    'resources/views/manager/documents/index.blade.php',
    'resources/views/manager/maintenances/index.blade.php',
    'resources/views/manager/rapports/index.blade.php',
    'resources/views/manager/recettes/index.blade.php',
    'resources/views/manager/users/index.blade.php',
    'resources/views/manager/vehicules/index.blade.php',
    'resources/views/manager/voyages/index.blade.php',
];

$styleBlock = '
<style>
    /* Désactiver le scroll global */
    html, body { overflow: hidden !important; height: 100vh !important; }
    
    /* Scrollbar minimaliste */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.2); border-radius: 10px; }
    
    /* Wrapper Layout */
    .module-index-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        height: calc(100vh - 100px);
        overflow: hidden;
        padding-bottom: 0.5rem;
    }
    
    .module-index-wrapper > * {
        flex-shrink: 0;
    }
    
    .module-index-wrapper > .list-scroll-container {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        overflow-y: auto !important;
        padding-right: 0.25rem;
    }
</style>
<div class="module-index-wrapper custom-scrollbar">';

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (!file_exists($path)) {
        echo "File missing: $file\n";
        continue;
    }
    
    $content = file_get_contents($path);
    
    // Replace space-y-6 and inject style if not already using module-index-wrapper
    if (strpos($content, 'module-index-wrapper') === false) {
        $content = str_replace('<div class="space-y-6">', $styleBlock, $content);
    }
    
    // Add list-scroll-container to table container
    $content = str_replace(
        '<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">',
        '<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col list-scroll-container">',
        $content
    );
    
    // Add flex-1 overflow-y-auto to the direct table wrapper
    $content = str_replace(
        '<div class="overflow-x-auto">',
        '<div class="overflow-x-auto overflow-y-auto flex-1 custom-scrollbar">',
        $content
    );
    
    // Add shrink-0 to pagination container (usually just after the table wrapper div closes)
    // Looking for <div class="p-4"> or <div class="mt-4"> wrapping links()
    $content = preg_replace('/<div class="p-4">\s*(\{\{ [^>]+->links\(\) \}\})\s*<\/div>/', '<div class="p-4 border-t border-gray-100 dark:border-gray-700 shrink-0">\n            $1\n        </div>', $content);
    $content = preg_replace('/<div class="mt-4">\s*(\{\{ [^>]+->links\(\) \}\})\s*<\/div>/', '<div class="mt-4 shrink-0">\n            $1\n        </div>', $content);
    
    file_put_contents($path, $content);
    echo "Updated $file\n";
}
