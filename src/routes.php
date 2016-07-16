<?php
// Routes

$app->post('/auth', function ($request, $response, $args) {
    // log used route
    $this->logger->info("get route '".$request->getAttribute('route')->getName()."' with uri '". $request->getUri() ."' ");
    $allPostPutVars = $request->getParsedBody();
    $login_params = $allPostPutVars['login_form'];
    $userManager = $this->get('userManager');
    
    $user = $userManager->authenticate($login_params['email'], $login_params['password']);
    if( $user ){
        $authService = $this->get('authService');
        $authService->registerUser($user);
        
        $this->logger->info('Authentication successfull');
        return $response->withStatus(302)->withHeader('Location', '/');
    } else {
        $this->logger->info('Authentication failure');
        $this->flash->addMessage('danger', 'Email or password invalid');
        return $response->withStatus(302)->withHeader('Location', '/login');
    }
    

    
})->setName('auth');

$app->get('/logout', function ($request, $response, $args) {
    // log used route
    $this->logger->info("get route '".$request->getAttribute('route')->getName()."' with uri '". $request->getUri() ."' ");
    
    $authService = $this->get('authService');
    $authService->logout();
    $this->flash->addMessage('success', 'Successfully logged-out');
    
    return $response->withStatus(302)->withHeader('Location', '/');
    
})->setName('logout');

$app->get('/login', function ($request, $response, $args) {
    // log used route
    $this->logger->info("get route '".$request->getAttribute('route')->getName()."' with uri '". $request->getUri() ."' ");
    
    // initialize view paramaters
    $view_params = [
        'flash_message'     => $this->flash
    ];
    
    return $this->view->render($response, 'login.twig', $view_params);
    
})->setName('login');

//$app->get('/passwd', function ($request, $response, $args) {
//    //$salt = 'oZJorS9r';
//    $password = 'test';
//    
//    $encoded = password_hash($password, PASSWORD_BCRYPT);
//    
//    if(password_verify($password, '$2y$10$AAbVI/8p4koMaT9ssbIKeuMhgyQtqn1/xtMqvmNseT6QxlOnzKwmu') ){
//        echo 'pass $password OK';
//    }
//    
//    if(password_verify('tttt', '$2y$10$AAbVI/8p4koMaT9ssbIKeuMhgyQtqn1/xtMqvmNseT6QxlOnzKwmu') ){
//        echo 'pass $password OK';
//    } else {
//        echo 'KO';
//    }
//    
//    die($encoded);
//    
//});

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

