<?php
// Routes

$app->get('/[{feed}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("App'/' route");
    
    $params = [ 
        'feed' => $args['feed'],
        'error' => false, 
        'error_message' =>''
    ];
    $rssNewsReader = $this->get('rssNewsReader');
    
    try {
        $params['news_lists'] = $rssNewsReader->find($args['feed']);
    } catch (\Exception $e){
        $params['error']            = true;
        $params['error_message']    = $e->getMessage(); 
    }

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $params);
});
