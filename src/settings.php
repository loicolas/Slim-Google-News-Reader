<?php
$local_settings = require __DIR__ . '/../src/local_settings.php';
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
        ],
        
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    'src/App/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' =>  __DIR__.'/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver'   => $local_settings['doctrine']['connection']['driver'],
                'host'     => $local_settings['doctrine']['connection']['host'],
                'dbname'   => $local_settings['doctrine']['connection']['dbname'],
                'user'     => $local_settings['doctrine']['connection']['user'],
                'password' => $local_settings['doctrine']['connection']['password']
            ]
        ]
    ],
];
