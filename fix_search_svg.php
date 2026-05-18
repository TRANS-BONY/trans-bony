<?php

$files = [
    'resources/views/technicien/vehicules/index.blade.php',
    'resources/views/manager/vehicules/index.blade.php',
    'resources/views/manager/chauffeurs/index.blade.php',
    'resources/views/gestionnaire/vehicules/index.blade.php',
    'resources/views/gestionnaire/chauffeurs/index.blade.php',
    'resources/views/admin/maintenance/index.blade.php',
    'resources/views/admin/vehicule/index.blade.php',
    'resources/views/admin/chauffeur/index.blade.php'
];

$find = '<div class="relative flex items-center">
                <div class="pl-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <form method="GET" class="flex-1">';

$replace = '<form method="GET" class="relative flex items-center w-full">
                <button type="submit" class="pl-4 cursor-pointer text-gray-400 hover:text-indigo-500 transition-colors z-10" title="Rechercher">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <div class="flex-1">';

$find_close = '</form>
                @if(request(\'search\'))';

$replace_close = '</div>
                @if(request(\'search\'))';

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        // Replace opening
        if (strpos($content, $find) !== false) {
            $content = str_replace($find, $replace, $content);
            
            // Replace closing
            // Since we replaced <form> with <div>, we must replace </form> with </div> and then close the outer form.
            // But wait, the structure was:
            // </form>
            // @if(...) ... @endif
            // </div>
            // We want it to be:
            // </div>
            // @if(...) ... @endif
            // </form>
            
            // Let's do a regex to capture everything from </form> to </div>
            $content = preg_replace(
                '/<\/form>\s*(@if\(request\(\'search\'\)\).*?@endif\s*)<\/div>/s',
                "</div>\n                $1</form>",
                $content
            );
            
            file_put_contents($path, $content);
            echo "Updated: $path\n";
        } else {
            echo "Pattern not found in: $path\n";
        }
    }
}
