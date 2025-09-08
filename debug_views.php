<?php

/**
 * Script de debug pour vérifier les vues
 */

// Vérifier l'existence des fichiers
$baseDir = __DIR__ . '/resources/views/';

$files_to_check = [
    'index.blade.php' => $baseDir . 'index.blade.php',
    'pages/login.blade.php' => $baseDir . 'pages/login.blade.php',
    'pages/home.blade.php' => $baseDir . 'pages/home.blade.php',
    'welcome.blade.php' => $baseDir . 'welcome.blade.php',
];

echo "=== Vérification des fichiers de vues ===\n";

foreach ($files_to_check as $name => $path) {
    $exists = file_exists($path);
    $readable = $exists ? is_readable($path) : false;
    $size = $exists ? filesize($path) : 0;
    
    echo sprintf(
        "%-25s : %s %s %s\n",
        $name,
        $exists ? '✓ Existe' : '✗ Manquant',
        $readable ? '✓ Lisible' : '✗ Non lisible',
        $exists ? "({$size} bytes)" : ''
    );
}

echo "\n=== Contenu du répertoire resources/views ===\n";
if (is_dir($baseDir)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDir),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $relativePath = str_replace($baseDir, '', $file->getPathname());
            echo "- {$relativePath}\n";
        }
    }
} else {
    echo "Le répertoire resources/views n'existe pas !\n";
}

echo "\n=== Test Laravel (si disponible) ===\n";
if (file_exists(__DIR__ . '/artisan')) {
    echo "Artisan trouvé. Essayez ces commandes :\n";
    echo "php artisan view:cache\n";
    echo "php artisan view:clear\n";
    echo "php artisan config:clear\n";
    echo "php artisan route:clear\n";
} else {
    echo "Artisan non trouvé dans le répertoire actuel.\n";
}

