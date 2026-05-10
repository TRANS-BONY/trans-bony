<?php

$appPath = __DIR__ . '/resources/views/layouts/app.blade.php';
$app = file_get_contents($appPath);
$role = 'gestionnaire';

$layoutPath = __DIR__ . '/resources/views/layouts/' . $role . '.blade.php';

$layoutContent = file_get_contents($layoutPath);

// Extract the links block from the role layout
preg_match('/<nav class=\"space-y-1\">(.*?)<\/nav>/s', $layoutContent, $linksMatch);

if($linksMatch) {
    $roleLinks = $linksMatch[1];
    
    // Extract the target replacement area in app.blade.php
    preg_match('/(<div class=\"space-y-1\">)(.*?)(<\/div>\s+<!-- Info utilisateur)/s', $app, $appLinksMatch);
    
    if($appLinksMatch) {
        $newContent = str_replace($appLinksMatch[2], "\n" . $roleLinks . "\n                ", $app);
        $newContent = str_replace('Tableau de bord Professionnel', 'Espace ' . ucfirst($role), $newContent);
        
        file_put_contents($layoutPath, $newContent);
        echo "Updated $role\n";
    } else {
        echo "Could not find links block in app.blade.php\n";
    }
} else {
    echo "Could not find links block in $role.blade.php\n";
}
