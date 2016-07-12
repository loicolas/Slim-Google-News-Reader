<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// Google news reader service
$container['googleNewsReader'] = function($c){
    $settings = $c->get('settings')['google-news-reader'];
    $google_news_endpoint   = $settings['endpoint'];
    $google_news_version    = $settings['version'];
    return new App\Service\GoogleNewsReaderService($google_news_endpoint, $google_news_version,  $c['logger']);
};