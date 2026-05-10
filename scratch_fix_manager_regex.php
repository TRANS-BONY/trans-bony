<?php
function fixFile($path) {
    if (!file_exists($path)) return;
    $content = file_get_contents($path);
    // There are two closing divs before the "Info utilisateur" comment. We only want one.
    // The exact structure is typically:
    //             </div>
    //         
    //                 </div>
    // 
    //                 <!-- Info utilisateur dans sidebar (visible sur mobile) -->
    
    // Replace multiple closing divs and whitespace with a single closing div
    $pattern = '/<\/div>\s*<\/div>\s*<!-- Info utilisateur dans sidebar/';
    $replacement = "</div>\n\n                <!-- Info utilisateur dans sidebar";
    
    $newContent = preg_replace($pattern, $replacement, $content);
    if ($newContent !== $content) {
        file_put_contents($path, $newContent);
        echo "Fixed $path\n";
    } else {
        echo "No change needed or pattern not found in $path\n";
    }
}

fixFile(__DIR__ . '/resources/views/layouts/manager.blade.php');
fixFile(__DIR__ . '/resources/views/layouts/agent.blade.php');
fixFile(__DIR__ . '/resources/views/layouts/comptable.blade.php');
