<?php

return [

    'media_items_per_page' => 30,

    'system_content_types' => ['Gallery'],

    'upload_paths' => [
        [
            // E.g.: http://chronos.ro/uploads/media/{year}/{month}
            'asset_path' => env('APP_URL') . '/uploads/media/' . date('Y') . '/' . date('m'),
            // E.g.: /var/www/public/uploads/media/{year}/{month}
            'upload_path' => env('UPLOAD_URL') . 'uploads/media/' . date('Y') . '/' . date('m')
        ]
    ]

];