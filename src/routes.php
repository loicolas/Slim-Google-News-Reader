<?php
// Routes

$app->any('/preference', function ($request, $response, $args) {
    $this->logger->info("get route '".$request->getAttribute('route')->getName()."' with uri '". $request->getUri() ."' ");
    
    $authService = $this->get('authService');
    if( ! $authService->isLoggedIn() ){
        $this->flash->addMessage('danger', 'Access to the requested page is forbidden');
        return $response->withStatus(401)->withHeader('Location', '/login');
    }
    
    // get available feeds declared in the configuration
    $available_feeds = $this->get('settings')['news-reader'];
    
    if( $request->isPost() ){
        $userManager = $this->get('userManager');
        $allPostPutVars = $request->getParsedBody();
        $preference_params = $allPostPutVars['preference_form'];
        
        try {
            // get current user
            $user = $userManager->getById($authService->getUserId());
            
            if( $user == null ){
                $this->flash->addMessage('danger', 'Access to the requested page is forbidden');
                return $response->withStatus(401)->withHeader('Location', '/login');
            }
            
            // update user Manager from request
            $userManager->setPreferences($user, $preference_params);
            // user values in the session
            $authService->registerUser($user);
            
            $this->flash->addMessage('success', 'User preferences saved');
            return $response->withStatus(302)->withHeader('Location', '/preference');
            
        } catch (\Exception $e){
            $this->flash->addMessage('danger', $e->getMessage());
        }
    }
    
        // initialize view paramaters
    $view_params = [ 
        'available_feeds'   => $available_feeds,
        'user_preferences'   => $authService->getUserPreferences()
    ];
    
    return $this->view->render($response, 'preference.twig', $view_params);
    
})->setName('preference');

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

