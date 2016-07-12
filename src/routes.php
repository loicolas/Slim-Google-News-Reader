<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("App'/' route");
    
    $params =  array_merge($args, ['error' => false, 'error_message' =>'']);
    $googleNewsReader = $this->get('googleNewsReader');
    
    try {
        $news = $googleNewsReader->find();
    } catch (\Exception $e){
        $params['error']            = true;
        $params['error_message']    = $e->getMessage(); 
    }

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $params);
});
