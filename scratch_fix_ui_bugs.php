<?php

function fixPaginationNewlines($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $path = $file->getPathname();
            $content = file_get_contents($path);
            
            // Remove literal \n around the pagination links
            $newContent = str_replace('\n', '', $content);
            
            if ($newContent !== $content) {
                file_put_contents($path, $newContent);
                echo "Fixed literal \\n in: $path\n";
            }
        }
    }
}

function fixSidebarScroll($dir) {
    $files = glob($dir . '/*.blade.php');
    foreach ($files as $file) {
        $content = file_get_contents($file);
        
        $search = 'lg:relative lg:translate-x-0 overflow-y-auto"';
        $replace = 'lg:relative lg:translate-x-0 overflow-y-auto lg:h-screen lg:sticky lg:top-0"';
        
        // Also handle cases without trailing quote if it differs slightly
        $search2 = 'lg:relative lg:translate-x-0 overflow-y-auto';
        $replace2 = 'lg:relative lg:translate-x-0 overflow-y-auto lg:h-screen lg:sticky lg:top-0';
        
        if (strpos($content, $search2) !== false && strpos($content, 'lg:h-screen') === false) {
            $newContent = str_replace($search2, $replace2, $content);
            file_put_contents($file, $newContent);
            echo "Fixed sidebar scroll in: $file\n";
        }
    }
}

fixPaginationNewlines(__DIR__ . '/resources/views');
fixSidebarScroll(__DIR__ . '/resources/views/layouts');

echo "All done.\n";
