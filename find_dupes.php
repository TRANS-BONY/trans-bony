<?php
$dirs = ['manager', 'admin', 'technicien', 'agent', 'comptable'];
foreach ($dirs as $dir) {
    $files = glob(__DIR__ . "/resources/views/$dir/*/index.blade.php");
    foreach ($files as $f) {
        $content = file_get_contents($f);
        $count = substr_count($content, 'name="search"');
        if ($count > 1) {
            echo "Duplicate search in: $f ($count times)\n";
        }
    }
}
