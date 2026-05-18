<?php

$dir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);

        $pattern = '/<i class="fas fa-search absolute ([^"]*)"><\/i>/';
        
        $newContent = preg_replace_callback($pattern, function($matches) {
            $classes = $matches[1];
            // Add z-10 and cursor-pointer to make it clickable and over the input
            if (strpos($classes, 'cursor-pointer') === false) {
                $classes .= ' z-10 cursor-pointer hover:opacity-80 transition-opacity';
            }
            return '<button type="submit" class="absolute ' . $classes . '"><i class="fas fa-search"></i></button>';
        }, $content, -1, $count);

        if ($count > 0) {
            file_put_contents($path, $newContent);
            echo "Updated: $path\n";
        }
    }
}
