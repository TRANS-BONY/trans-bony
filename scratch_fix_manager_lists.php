<?php

$dir = __DIR__ . '/resources/views/manager';
$files = glob($dir . '/*/index.blade.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    $changed = false;
    
    // Fix missing list-scroll-container around table or grid
    if (strpos($content, 'class="grid') !== false && strpos($content, 'list-scroll-container') === false) {
        $content = preg_replace('/<div class="grid([^"]*)">/', '<div class="list-scroll-container custom-scrollbar grid$1">', $content);
        $changed = true;
    }
    if (strpos($content, '<div class="overflow-x-auto">') !== false) {
        $content = str_replace('<div class="overflow-x-auto">', '<div class="list-scroll-container flex-1 overflow-y-auto custom-scrollbar">' . "\n" . '            <table', $content);
        $content = str_replace('</table>' . "\n" . '        </div>', '</table>' . "\n" . '        </div>', $content); // wait, need to close it carefully
        $changed = true;
    }

    // Fix pagination wrapper to be shrink-0
    if (strpos($content, 'links()') !== false) {
        // If it's wrapped in `<div class="p-4 bg-gray-50">`
        if (strpos($content, '<div class="p-4 bg-gray-50">') !== false) {
            $content = str_replace('<div class="p-4 bg-gray-50">', '<div class="p-4 bg-gray-50 shrink-0">', $content);
            $changed = true;
        }
        // If wrapped in <div class="p-4 border-t ... shrink-0"> it's fine
    }
    
    if ($changed) {
        file_put_contents($file, $content);
        echo "Fixed wrapper/pagination in: $file\n";
    }
}
