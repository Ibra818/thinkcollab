<?php

// Test simple pour vérifier si le système fonctionne

use Illuminate\Support\Facades\Route;

Route::get('/debug', function () {
    $viewExists = view()->exists('pages.login');
    $layoutExists = view()->exists('index');
    
    return response()->json([
        'views_path' => resource_path('views'),
        'pages_login_exists' => $viewExists,
        'index_layout_exists' => $layoutExists,
        'login_file_exists' => file_exists(resource_path('views/pages/login.blade.php')),
        'index_file_exists' => file_exists(resource_path('views/index.blade.php')),
    ]);
});

