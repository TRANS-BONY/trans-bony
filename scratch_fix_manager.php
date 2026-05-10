<?php
$path = __DIR__ . '/resources/views/layouts/manager.blade.php';
$content = file_get_contents($path);

$search = <<<EOD
            </div>
        
                </div>

                <!-- Info utilisateur dans sidebar (visible sur mobile) -->
EOD;

$replace = <<<EOD
            </div>

                <!-- Info utilisateur dans sidebar (visible sur mobile) -->
EOD;

$content = str_replace($search, $replace, $content);
file_put_contents($path, $content);

echo "Fixed manager.blade.php\n";

$pathAgent = __DIR__ . '/resources/views/layouts/agent.blade.php';
if(file_exists($pathAgent)) {
    $contentAgent = file_get_contents($pathAgent);
    $contentAgent = str_replace($search, $replace, $contentAgent);
    file_put_contents($pathAgent, $contentAgent);
    echo "Fixed agent.blade.php\n";
}

$pathComptable = __DIR__ . '/resources/views/layouts/comptable.blade.php';
if(file_exists($pathComptable)) {
    $contentComptable = file_get_contents($pathComptable);
    $contentComptable = str_replace($search, $replace, $contentComptable);
    file_put_contents($pathComptable, $contentComptable);
    echo "Fixed comptable.blade.php\n";
}
