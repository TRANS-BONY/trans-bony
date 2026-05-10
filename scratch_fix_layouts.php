<?php

$appPath = __DIR__ . '/resources/views/layouts/app.blade.php';
if (!file_exists($appPath)) {
    echo "app.blade.php not found\n";
    exit;
}

$app = file_get_contents($appPath);
$roles = ['manager', 'agent', 'comptable', 'gestionnaire', 'technicien'];

foreach($roles as $role) {
    $layoutPath = __DIR__ . '/resources/views/layouts/' . $role . '.blade.php';
    if(!file_exists($layoutPath)) {
        echo "Layout $layoutPath not found\n";
        continue;
    }
    
    $layoutContent = file_get_contents($layoutPath);
    
    // Extract the links block from the role layout
    preg_match('/<div class=\"space-y-1\">(.*?)<\/div>\s+<!--/s', $layoutContent, $linksMatch);
    if (!$linksMatch) {
        preg_match('/<div class=\"space-y-1\">(.*?)<\/div>\s+<\/div>\s+<!-- Pied/s', $layoutContent, $linksMatch);
    }
    
    if($linksMatch) {
        $roleLinks = $linksMatch[1];
        
        // Extract the target replacement area in app.blade.php
        preg_match('/(<div class=\"space-y-1\">)(.*?)(<\/div>\s+<!-- Info utilisateur)/s', $app, $appLinksMatch);
        
        if($appLinksMatch) {
            $newContent = str_replace($appLinksMatch[2], "\n" . $roleLinks . "\n                ", $app);
            $newContent = str_replace('Tableau de bord Professionnel', 'Espace ' . ucfirst($role), $newContent);
            
            // Fix Alpine JS app init name
            // app.blade.php uses x-data="app()" and function app() {}
            // we should probably rename it to x-data="roleApp()" to avoid collisions, but it's okay if they all use app()
            // Just need to make sure we don't have multiple app() functions. Wait, each page only includes ONE layout.
            // But wait, the manager layout has function managerApp(). Since we replace the WHOLE manager layout with app layout structure,
            // we will replace function managerApp() with function app() anyway, so it's fine.
            
            file_put_contents($layoutPath, $newContent);
            echo "Updated $role\n";
        } else {
            echo "Could not find links block in app.blade.php\n";
        }
    } else {
        echo "Could not find links block in $role.blade.php\n";
    }
}
