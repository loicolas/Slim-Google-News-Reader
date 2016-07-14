<?php
// Routes

$app->get('/[{feed}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("App'/' route");
    $feed_name = $args['feed'] ?? null;
    
    $view_params = [ 
        'feed' => $feed_name,
        'error' => false, 
        'error_message' =>''
    ];
    $rssNewsReader = $this->get('rssNewsReader');
    
    try {
        $view_params['news_lists'] = $rssNewsReader->find($feed_name);
    } catch (\Exception $e){
        $view_params['error']            = true;
        $view_params['error_message']    = $e->getMessage(); 
    }
    

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $view_params);
});
