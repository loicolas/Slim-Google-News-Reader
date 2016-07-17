<?php

namespace App\Service;

use App\Model\UserInterface;
use SlimSession\Helper;
/**
 * Description of AuthService
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class AuthService
{
    /**
     *
     * @var  Helper
     */
    protected $session;
    
    public function __construct(Helper $session)
    {
        $this->session = $session;
    }

    /**
     * register user information in session
     * @param UserInterface $user
     */
    public function registerUser(UserInterface $user)
    {
        $this->session->set('user_id', $user->getId());
        $this->session->set('user_username', $user->getUsername());
        $this->session->set('user_email', $user->getUsername());
        
        
        $user_preferences = [];
        foreach( $user->getPreferences() as $preference){
            $user_preferences[$preference->getFeed()] = $preference->getActive();
        }
        
        $this->session->set('user_preferences', $user_preferences);
    }
    
    /**
     * Check if current user is logged in
     * @return boolean
     */
    public function isLoggedIn()
    {
        $logged_in = false;
        if( $this->session->get('user_id') ){
            $logged_in = true;
        }
        
        return $logged_in;
    }
    
    /**
     * logout the current user
     */
    public function logout()
    {
        $this->session->clear();
    }
    
    /**
     * return the user_id of the logged in user
     * 
     * @return int
     */
    public function getUserId(): int
    {
        return $this->session->get('user_id');
    }
    
    /**
     * return the username of the logged in user
     * 
     * @return string
     */
     public function getUsername(): string
    {
        return $this->session->get('user_username');
    }
    
    
    /**
     * return the feed preferences of the logged in user
     * 
     * @return array
     */
    public function getUserPreferences(): array
    {
        return $this->session->get('user_preferences');
    }
}
