<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour optimiser les uploads de fichiers
    |
    */

    'max_file_size' => env('UPLOAD_MAX_FILE_SIZE', 512000), // 500MB en KB
    'max_image_size' => env('UPLOAD_MAX_IMAGE_SIZE', 51200), // 50MB en KB
    'allowed_video_types' => ['video/mp4', 'video/avi', 'video/mov', 'video/mkv', 'video/webm'],
    'allowed_image_types' => ['image/jpeg', 'image/png', 'image/jpg'],
    
    'compression' => [
        'image_quality' => env('IMAGE_COMPRESSION_QUALITY', 85),
        'max_width' => env('IMAGE_MAX_WIDTH', 800),
        'max_height' => env('IMAGE_MAX_HEIGHT', 600),
    ],
    
    'chunk_size' => env('UPLOAD_CHUNK_SIZE', 1024 * 1024), // 1MB par chunk
    'timeout' => env('UPLOAD_TIMEOUT', 300), // 5 minutes
];
