<?php
$file = __DIR__ . '/resources/views/agent/voyage/index.blade.php';
$content = file_get_contents($file);

// Replace the flex row container with list-scroll-container
$content = preg_replace('/<!-- Contenu principal -->\s*<div class="flex flex-col lg:flex-row gap-6">/s', '<!-- Contenu principal -->
    <div class="list-scroll-container custom-scrollbar flex flex-col lg:flex-row gap-6 w-full">', $content);

file_put_contents($file, $content);
echo "Fixed agent voyage index.\n";
