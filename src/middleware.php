<?php
// Application middleware

$app->add(new \Slim\Middleware\Session([
  'name' => 'slim_reader_session',
  'autorefresh' => true,
  'lifetime' => '1 hour'
]));

$app->add( function ($request, $response, $next) {
    $twig = $this->get('view')->getEnvironment(); 
    $twig->addGlobal('authservice', $this->get('authService'));
    $response = $next($request, $response);
        
    return $response;
});
