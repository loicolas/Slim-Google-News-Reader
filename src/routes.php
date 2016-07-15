<?php
// Routes

$app->get('/[{feed}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("App'/' route");
    $current_feed = $args['feed'] ?? null;
    
    $available_feeds = $this->get('settings')['news-reader'];
    
    $view_params = [ 
        'current_feed'      => $current_feed,
        'error'             => false, 
        'error_message'     => '',
        'available_feeds'   => $available_feeds,
        'flash_message'     => $this->flash
    ];
    $rssNewsReader = $this->get('rssNewsReader');
    
    try {
        $view_params['news_lists'] = $rssNewsReader->find($current_feed);
    } catch (\Exception $e){
        $this->flash->addMessage('danger', $e->getMessage());
        $view_params['error']            = true;
        $view_params['error_message']    = $e->getMessage(); 
    }
    
    return $this->view->render($response, 'home.twig', $view_params);
    
});
