<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        'twig' => [
            'template_path'         => __DIR__ . '/../templates/',
            'cache_template_path'   => __DIR__ . '/../templates/cache/',
            'auto_reload'           => true
        ],
            
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
        
        'news-reader' => [
            'athome'    => 'http://www.athome.lu/blog/feed/',
            'slim'      => 'http://www.slimframework.com/blog/feed.rss'
        ]
    ],
];
