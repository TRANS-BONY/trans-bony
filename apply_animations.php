<?php

$files = glob(__DIR__ . '/resources/views/layouts/*.blade.php');
foreach ($files as $file) {
    if (basename($file) === 'guest.blade.php' || basename($file) === 'navigation.blade.php') {
        continue; // Skip login page as requested
    }
    
    $content = file_get_contents($file);
    
    // Add floating styles to <style> block if not present
    if (strpos($content, '@keyframes floating') === false) {
        $styleAddition = "
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    .floating { animation: floating 4s ease-in-out infinite; }
    .floating-fast { animation: floating 2.5s ease-in-out infinite; }
    .floating-slow { animation: floating 6s ease-in-out infinite; }
    .nav-fluid-hover { transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }
";
        $content = preg_replace('/<style>/i', '<style>' . $styleAddition, $content, 1);
    }
    
    // Convert static nav-item to Alpine.js enhanced nav-item
    // Only if not already having x-data
    $content = preg_replace_callback('/<a([^>]*)class="([^"]*nav-item[^"]*)"([^>]*)>/i', function($matches) {
        $attrs1 = $matches[1];
        $class = $matches[2];
        $attrs2 = $matches[3];
        
        if (strpos($attrs1 . $attrs2, 'x-data=') !== false) {
            return $matches[0];
        }
        
        // Add nav-fluid-hover class if not present
        if (strpos($class, 'nav-fluid-hover') === false) {
            $class .= ' nav-fluid-hover';
        }
        
        // Return with Alpine.js logic
        return sprintf(
            '<a%sclass="%s"%s x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" :class="hover ? \'shadow-lg -translate-y-1 bg-white/10 scale-[1.02] floating-fast\' : \'\'">',
            $attrs1,
            $class,
            $attrs2
        );
    }, $content);
    
    file_put_contents($file, $content);
    echo "Updated " . basename($file) . "\n";
}

// Now update dashboard statistic pages
$dashboards = [
    'resources/views/admin/dashboard.blade.php',
    'resources/views/agent/dashboard.blade.php',
    'resources/views/comptable/dashboard.blade.php',
    'resources/views/manager/dashboard.blade.php',
    'resources/views/technicien/dashboard.blade.php',
    'resources/views/gestionnaire/dashboard.blade.php'
];

foreach ($dashboards as $dashFile) {
    $fullPath = __DIR__ . '/' . $dashFile;
    if (!file_exists($fullPath)) continue;
    
    $content = file_get_contents($fullPath);
    
    // Add alpine js to stat cards
    // Cards usually have 'card-hover' or 'stat-card' class
    $content = preg_replace_callback('/<div([^>]*)class="([^"]*(?:card-hover|stat-card)[^"]*)"([^>]*)>/i', function($matches) {
        $attrs1 = $matches[1];
        $class = $matches[2];
        $attrs2 = $matches[3];
        
        if (strpos($attrs1 . $attrs2, 'x-data=') !== false) {
            return $matches[0];
        }
        
        return sprintf(
            '<div%sclass="%s"%s x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? \'floating shadow-2xl scale-[1.03] z-10\' : \'\'" x-transition.duration.500ms>',
            $attrs1,
            $class,
            $attrs2
        );
    }, $content);
    
    file_put_contents($fullPath, $content);
    echo "Updated " . basename($dashFile) . "\n";
}

echo "Done.\n";
