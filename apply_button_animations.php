<?php

$files = glob(__DIR__ . '/resources/views/layouts/*.blade.php');
foreach ($files as $file) {
    if (basename($file) === 'guest.blade.php' || basename($file) === 'navigation.blade.php') {
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Add floating styles to topbar buttons
    $content = preg_replace_callback('/<button([^>]*)@click="([^"]*)"([^>]*)>/i', function($matches) {
        $attrs1 = $matches[1];
        $click = $matches[2];
        $attrs2 = $matches[3];
        
        // Don't add to simple close buttons or if it already has mouseenter
        if (strpos($click, 'show = false') !== false || strpos($attrs1 . $attrs2, '@mouseenter') !== false) {
            return $matches[0];
        }
        
        // Add alpine floating to interactive buttons like User Profile and Notifications
        // For buttons that already have x-data or inside x-data (like dropdowns)
        return sprintf(
            '<button%s@click="%s"%s @mouseenter="$el.classList.add(\'floating-fast\', \'scale-105\')" @mouseleave="$el.classList.remove(\'floating-fast\', \'scale-105\')">',
            $attrs1,
            $click,
            $attrs2
        );
    }, $content);
    
    file_put_contents($file, $content);
    echo "Updated buttons in " . basename($file) . "\n";
}

echo "Done.\n";
