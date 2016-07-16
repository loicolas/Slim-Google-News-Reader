<?php
// Routes

$app->post('/auth', function ($request, $response, $args) {
    // log used route
    $this->logger->info("get route '".$request->getAttribute('route')->getName()."' with uri '". $request->getUri() ."' ");
    
    // initialize view paramaters
    $view_params = [];
    
    return $this->view->render($response, 'login.twig', $view_params);
    
})->setName('auth');

$app->get('/login', function ($request, $response, $args) {
    // log used route
    $this->logger->info("get route '".$request->getAttribute('route')->getName()."' with uri '". $request->getUri() ."' ");
    
    // initialize view paramaters
    $view_params = [];
    
    return $this->view->render($response, 'login.twig', $view_params);
    
})->setName('login');

$app->get('/[{feed}]', function ($request, $response, $args) {
    // log used route
    $this->logger->info("get route '".$request->getAttribute('route')->getName()."' with uri '". $request->getUri() ."' ");
    $current_feed = $args['feed'] ?? null;
    
    // get available feeds declared in the configuration
    $available_feeds = $this->get('settings')['news-reader'];
    
    // initialize view paramaters
    $view_params = [ 
        'current_feed'      => $current_feed,
        'error'             => false, 
        'error_message'     => '',
        'available_feeds'   => $available_feeds,
        'flash_message'     => $this->flash
    ];
    
    // get news reader Service
    $rssNewsReader = $this->get('rssNewsReader');
    
    try {
        // get content of the news feed
        $view_params['news_lists'] = $rssNewsReader->find($current_feed);
    } catch (\Exception $e){
        $this->flash->addMessage('danger', $e->getMessage());
    }
    
    return $this->view->render($response, 'home.twig', $view_params);
    
})->setName('news');

